<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentController extends Controller
{
    // View Student
    public function viewStudent(Request $request){
        $user = auth()->user();
        $Student = $user->studentDetails();
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $Student->count(),
            'recordsFiltered' => $Student->count(),
            'data' => $Student,
        ]);
    }
    // View Student
    public function viewStudentAttendance(Request $request){
        $classId = $request->classId;
        $user = auth()->user();
        $Student = $user->studentAttendanceDetails($classId);
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $Student->count(),
            'recordsFiltered' => $Student->count(),
            'data' => $Student,
        ]);
    }
    // Add Student
    public function addStudent(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'classes' => ['required'],
        ]);

        $user = auth()->user();

        $schoolId = $user->school->id;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type'=> $request->user_type,
        ]);
        $lastUserInsertedId = $user->id;

        $teachers = Student::create([
            'users_id' => $lastUserInsertedId,
            'school_id' => $schoolId,
            'class_id' => $request->classes,
        ]);
    }
    // Edit Student
    public function editStudent(Request $request){
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $class = $request->classes;

        $users = User::where('email',$email)->update(['name' => $name]);

        Student::where('id', $id)->update(['class_id' => $class]);
    }
    // Delete Student
    public function deleteStudent(Request $request){
        $id = $request->id;
        $email = $request->email;

        $Student = Student::find($id);
        $Student->delete();

        $User = User::where('email',$email)->delete();
        // return Redirect::to('/dashboard');
    }
        // New View Student
        public function newView(){
            $main = "Hello";
            $student = view('auth.addStudent')->render();
            return response()->json([
                'status' => true,
                'main' => $student,
            ]);
        }
}