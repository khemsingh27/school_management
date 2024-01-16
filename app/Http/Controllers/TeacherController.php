<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Psy\Readline\Hoa\Console;
error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Models\User;
use App\Models\TeacherClass;
use App\Models\Teacher;
use App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function viewTeacher(Request $request)
    {



        // $teachers = Teacher::with('teacherClass')->get()->toArray();
        // echo"<pre>";print_r($teachers);die();

        $user_teachers = User::find(64)->with('teacher')->get();
        foreach($user_teachers as $user_teacher){
            dd($user_teacher->with('teacherClass'));
        }




        $user = auth()->user();
        $teacherDetails = $user->teacherDetails();
    
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $teacherDetails->count(),
            'recordsFiltered' => $teacherDetails->count(),
            'data' => $teacherDetails,
        ]);
    }
    public function store(Request $request){
        echo'hello';
        echo '<pre>';
         print_r($request->all());
         echo '</pre>';

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'classes' => ['required'],
        ]);

        // $schoolId = auth()->user()->school();
        $user = auth()->user();

        $schoolId = $user->school->id;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type'=> $request->user_type,
        ]);
        $lastUserInsertedId = $user->id;

        $teachers = Teacher::create([
            'users_id' => $lastUserInsertedId,
            'school_id' => $schoolId,
        ]);

        $lastInsertedId = $teachers->id;
        $class = $request->classes;
        foreach($class as $classes){
        $teacherClass = TeacherClass::create([
            'teacher_id' => $lastInsertedId,
            'class_id' => $classes,
        ]);
    }
    }
    public function editTeacher(){

    }

    public function delete(Request $request){
        $id = $request->id;
        $email = $request->email;
        // DB::table('your_table_name')->where('column_name', '=', $value)->delete();

        $user = auth()->user();

        $user->deleteTeacher($id,$email);

        return Redirect::to('/dashboard');
    }
}
