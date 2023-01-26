<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
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

Route::get('/', function () {
    return view('content');
});

Route::resource('/admin', AdminController::class);
Route::post('/students/check-mail', [StudentController::class, 'checkMail'])->name('students.checkmail');
Route::post('/students/check-phone', [StudentController::class, 'checkPhone'])->name('students.checkphone');
Route::resource('/students', StudentController::class);


Route::resource('/teachers', TeacherController::class);


