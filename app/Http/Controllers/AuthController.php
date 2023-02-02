<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Enums\UserRole;
use App\Mail\ForgotPassword;
use App\Mail\ForgotPasswordComplete;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends BaseController
{
    public function login(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect(route('students.index'));
        }
        return view('login.index',[
            'message' => $request->message,
        ]);
    }

    public function storeLogin(Request $request)
    {
//        $credentials = $request->validate([
//            'email' => ['required', 'email'],
//            'password' => ['required'],
//        ]);


        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response()->json([
                'url_redirect' => route('students.index'),
            ], StatusCode::OK);
        }

        return response()->json([
            'message' => 'Sai tài khoản hoặc mật khẩu',
        ], StatusCode::BAD_REQUEST);

    }

    public function forgotPassword()
    {
        return view('forgot-password.index');
    }

    public function storeForgotPassword(Request $request)
    {
        $message = '';
        $account = User::where('email', $request->email)->first();

        if ($account) {
            $account->reset_password_token = md5(Str::random(8));
            $account->reset_password_token_expire = Carbon::now()->addMinutes(15);
            $account->save();
            Mail::to($request->email)->send(new ForgotPassword($account));

            return response()->json([
                'status' => StatusCode::OK,
                'message' => '',
            ], StatusCode::OK);
        } else {
            $message = 'Email không tồn tại';
        }
        return response()->json(['message' => $message], StatusCode::BAD_REQUEST);
    }

    public function resetPassword(Request $request)
    {
        $message = '';
        if (User::where('reset_password_token', $request->reset_password_token)
            ->where('reset_password_token_expire', '>', Carbon::now())
            ->exists()
        ) {
            return view('reset-password.index',[
                'message' => $message,
            ]);
        }

        $message = 'token không đúng';
        return view('reset-password.index',[
            'message' => $message,
        ]);
    }

    public function storeResetPassword(Request $request)
    {
        $account = User::where('reset_password_token', $request->token)
            ->first();
        if ($account) {
            $account->password = Hash::make($request->password);
            $account->reset_password_token = null;
            $account->reset_password_token_expire = null;
            $account->save();


            Mail::to($account->email)->send(new ForgotPasswordComplete($account));

            return response()->json(['message' => 'Đổi mật khẩu thành công'], StatusCode::OK);
        }

        return response()->json(['message' => 'Token không đúng'], StatusCode::BAD_REQUEST);
    }


    public function logout()
    {
        auth()->logout();
        return redirect(route('login'));
    }
}
