<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TempController;
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
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
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
// Route::get('/viewTeacher', [TeacherController::class,'viewTeacher'])->name('viewTeacher');
// Route::post('/editTeacher', [TeacherController::class,'editTeacher'])->name('editTeacher');
// Route::post('/addTeacher',[TeacherController::class,'store'])->name('addTeacher');
// Route::post('/deleteTeacher',[TeacherController::class,'delete'])->name('deleteTeacher');

// Student Route
// Route::get('/viewTeacher', [TeacherController::class,'viewTeacher'])->name('viewTeacher');
// Route::post('/editTeacher', [TeacherController::class,'editTeacher'])->name('editTeacher');
// Route::post('/addTeacher',[TeacherController::class,'store'])->name('addTeacher');
// Route::post('/deleteTeacher',[TeacherController::class,'delete'])->name('deleteTeacher');


require __DIR__.'/auth.php';
