<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Psy\Readline\Hoa\Console;

use App\Models\User;
use App\Models\TeacherClass;
use App\Models\Teacher;
use App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // View Teacher
    public function viewTeacher(Request $request)
    {
        // $teacherDetails = array();
        // $teachers = Teacher::with('teacherClass')->get()->toArray();

        // $teacherDetails = $teachers;
        // $teacherCLass = TeacherClass::all();
        // $json = json_encode($teachers);

        // echo"<pre>";print_r($json);die();

        // $teacherDetails = User::find(28)->with('teacher')->get();

        // echo '<pre>'; print_r($teacherDetails); echo '</pre>';
        // foreach($teacherDetails as $user_teacher){
        //     $user_teacher->with('teacherClass');
            // $user_teacher->with('teacherClass');
            // print_r($user_teacher->with('teacherClass'));
        // }

        // $users = User::with('teacher')->get();
        // $users2 = $users->with('teacherClass')->get();
        // dd($users2);

        
        $user = auth()->user();
        $teacherDetails = $user->teacherDetails();
        
        $client_data = [];
        $uniqueTeachers = [];
        
        foreach ($teacherDetails as $teacherDetail) {
            // Check if teacher details are already added
            if (!isset($uniqueTeachers[$teacherDetail->id])) {
                $teacherClasses = Teacher::with('teacherClass')->find($teacherDetail->id);
        
                $teacher_class = "";
        
                foreach ($teacherClasses->teacherClass as $class) {
                    $teacher_class .= '<span class="badge bg-primary" style=" background-color:#717ff5!important; " >Class ' . $class->class_id . '</span>';
                }
        
                $client_data[] = array(
                    "id" => $teacherDetail->id,
                    'name' => $teacherDetail->name,
                    "email" => $teacherDetail->email,
                    "class_id" => $teacher_class,
                );
        
                // Mark teacher as added
                $uniqueTeachers[$teacherDetail->id] = true;
            }
        }
        
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => count($client_data),
            'recordsFiltered' => count($client_data),
            'data' => $client_data,
        ]);
        
        

    }
    // Add Teacher
    public function store(Request $request){
  
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
    // Edit Teacher
    public function editTeacher(Request $request){
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $class = $request->classes;

        $users = User::where('email',$email)->update(['name' => $name]);

        TeacherClass::where('teacher_id', $id)->delete();

        $class = $request->classes;
        foreach($class as $classes){
            $teacherClass = TeacherClass::create([
                'teacher_id' => $id,
                'class_id' => $classes,
            ]);
    }
}
   // Delete Teacher
    public function delete(Request $request){
        $id = $request->id;
        $email = $request->email;
        // DB::table('your_table_name')->where('column_name', '=', $value)->delete();

        $user = auth()->user();

        $user->deleteTeacher($id,$email);

        return Redirect::to('/dashboard');
    }
    // New View teacher
    public function newView(){
        $teacher = view('auth.addteacher')->render();
        return response()->json([
            'status' => true,
            'main' => $teacher,
        ]);
    }
}
