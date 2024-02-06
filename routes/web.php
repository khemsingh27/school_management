<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
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
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// // My Crud File
// Route::post('insert', 'TeacherController');

// Teacher Route
Route::get('/viewTeacher', [TeacherController::class,'viewTeacher'])->name('viewTeacher');
Route::post('/editTeacher', [TeacherController::class,'editTeacher'])->name('editTeacher');
Route::post('/addTeacher',[TeacherController::class,'store'])->name('addTeacher');
Route::post('/deleteTeacher',[TeacherController::class,'delete'])->name('deleteTeacher');

// Class Route
Route::get('/viewClass', [ClassController::class,'viewClass'])->name('viewClass');
Route::post('/addClass',[ClassController::class,'addClass'])->name('addClass');
Route::post('/editClass', [ClassController::class,'editClass'])->name('editClass');
Route::post('/deleteClass',[ClassController::class,'deleteClass'])->name('deleteClass');

// Student Route
Route::get('/viewStudent', [StudentController::class,'viewStudent'])->name('viewStudent');
Route::post('/editStudent', [StudentController::class,'editStudent'])->name('editStudent');
Route::post('/addStudent',[StudentController::class,'addStudent'])->name('addStudent');
Route::post('/deleteStudent',[StudentController::class,'deleteStudent'])->name('deleteStudent');

//Attendance
Route::get('/studentAttendance', function () {
    return view('studentAttendance');
});
Route::post('/studentAttendance', [AttendanceController::class,'studentAttendance'])->name('studentAttendance');
Route::post('/deleteStudentAttendance', [AttendanceController::class,'deleteStudentAttendance'])->name('deleteStudentAttendance');
Route::get('/show', [AttendanceController::class,'viewStudentWithAttendance'])->name('show');
Route::get('/showTeacher', [AttendanceController::class,'showTeacher'])->name('showTeacher');

// DashBoard Route
Route::get('/dashboard/teachers', [DashboardController::class,'teachers'])->middleware(['auth', 'verified'])->name('dashboard.teachers');
Route::get('/dashboard/students', [DashboardController::class,'students'])->middleware(['auth', 'verified'])->name('dashboard.students');
Route::get('/dashboard/classes_', [DashboardController::class,'classes'])->middleware(['auth', 'verified'])->name('dashboard.classes');
Route::get('/dashboard/attendance', [DashboardController::class,'attendance'])->middleware(['auth', 'verified'])->name('dashboard.attendance');
Route::get('/dashboard/teacher_attendance', [DashboardController::class,'teacher_attendance'])->middleware(['auth', 'verified'])->name('dashboard.teacher_attendance');
require __DIR__.'/auth.php';
