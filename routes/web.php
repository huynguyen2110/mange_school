<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('content');
//});

Route::get('', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'storeLogin'])->name('store-login');
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'storeForgotPassword'])->name('store-forgot-password');
Route::get('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'storeResetPassword'])->name('store-reset-password');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::group([
    'middleware' => 'auth',
], function () {
    Route::resource('/admin', AdminController::class);
    Route::post('/students/check-mail', [StudentController::class, 'checkMail'])->name('students.checkmail');
    Route::post('/students/check-phone', [StudentController::class, 'checkPhone'])->name('students.checkphone');
    Route::resource('/students', StudentController::class);


    Route::resource('/teachers', TeacherController::class);

    Route::post('/majors/check-mail', [MajorController::class, 'checkName'])->name('majors.checkname');
    Route::resource('/majors', MajorController::class);

    Route::post('/courses/check-mail', [CourseController::class, 'checkName'])->name('courses.checkname');
    Route::resource('/courses', CourseController::class);

    Route::post('/subjects/check-mail', [SubjectController::class, 'checkName'])->name('subjects.checkname');
    Route::resource('/subjects', SubjectController::class);

    Route::post('/classes/check-mail', [ClassController::class, 'checkName'])->name('classes.checkname');
    Route::post('/classes/register-class', [ClassController::class, 'registerClass'])->name('classes.register-class');
    Route::post('/classes/cancel-class', [ClassController::class, 'cancelClass'])->name('classes.cancel-class');
    Route::resource('/classes', ClassController::class);
});
