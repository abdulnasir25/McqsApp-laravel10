<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// registration
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'saveRegister'])->name('save_register');

// login
Route::get('/login', [AuthController::class, 'loadLogin'])->name('loadLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// admin section
Route::group(['middleware' => 'admin_check'], function() {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // questions
    Route::resource('/admin/questions', QuestionController::class);
    
    // student results
    Route::get('/admin/exam/all-results', [ExamController::class, 'getExamResults'])->name('admin.exam.all.results');
});

// student section
Route::group(['middleware' => 'student_check'], function() {
    // dashboard
    Route::get('/student/dashboard', [AuthController::class, 'studentDashboard'])->name('student.dashboard');

    // exam
    Route::get('/student/exam', [ExamController::class, 'exam'])->name('student.exam');
    Route::get('/student/exam/continue', [ExamController::class, 'startExam'])->name('student.exam.continue');
    Route::post('/student/exam/continue', [ExamController::class, 'storeAnswer'])->name('student.answer.store');
    Route::get('/student/exam/finished', [ExamController::class, 'examFinished'])->name('student.exam.finished');
    Route::get('/student/exam/result', [ExamController::class, 'examResult'])->name('student.exam.result');
});