<?php

namespace App\Repositories\Student;

use App\Enums\UserRole;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Repositories\Student\StudentInterface;
use App\Utils\Base;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Paginator;

class StudentRepository extends BaseController implements StudentInterface
{
    private User $student;
    public function __construct(User $student)
    {
        $this->student = $student;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $studentBuilder = $this->student
            ->where('role', UserRole::Student)
            ->orderBy('cre_at', 'desc');

        if (isset($request['search_input'])) {
            $studentBuilder = $studentBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('email', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('address', $request['search_input']));
            });
        }
        $students = $studentBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($students)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $students = $studentBuilder->paginate($newSizeLimit);
        }

        return $students;
    }

    public function getById($id)
    {
        return $this->student->where('uuid', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $student = new $this->student();
            $student->uuid = Base::generateUuid('std');
            $student->name = $request->name;
            $student->email = $request->email;
            $student->password = Hash::make($request->password);
            $student->birthday = $request->birthday;
            $student->gender = $request->gender;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->major_id = $request->major;
            $student->course_id = $request->course;
            $student->year_of_admission = date("Y");
            $student->role = UserRole::Student;

            if (! $student->save()) {
                DB::rollBack();

                return false;
            }
            DB::commit();
            return true;
        }
        catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return false;
        }


    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();

            $student = $this->student->where('uuid', $id)->first();
            $student->uuid = Base::generateUuid('std');
            $student->name = $request->name;
            $student->email = $request->email;
//            $student->password = Hash::make($request->password);
            $student->birthday = $request->birthday;
            $student->gender = $request->gender;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->major_id = $request->major;
            $student->course_id = $request->course;
            $student->year_of_admission = date("Y");

            if (! $student->save()) {
                DB::rollBack();

                return false;
            }
            DB::commit();
            return true;
        }
        catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id)
    {
        $user = $this->student->where('uuid', $id)->first();
        if (! $user) {
            return false;
        }

        return $user->delete();
    }

    public function checkEmail($request)
    {
        if (isset($request['value']) != '') {
            return ! $this->student->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('uuid', '!=', $request['id']);
                }
                $query->where(['email' => $request['value']]);
            })->exists();
        }
        if (isset($request['email']) != '') {
            return $this->student->where('email', $request['email'])->exists();
        }

        return true;
    }

    public function checkPhone($request)
    {
        if (isset($request['value']) != '') {
            return ! $this->student->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('uuid', '!=', $request['id']);
                }
                $query->where(['phone' => $request['value']]);
            })->exists();
        }
        if (isset($request['phone']) != '') {
            return $this->student->where('phone', $request['phone'])->exists();
        }

        return true;
    }
}
