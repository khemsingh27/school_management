<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function viewStudent(Request $request){
        $user = auth()->user();
        $Student = $user->studentAttendanceDetails($request->classId, $request->date);
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $Student->count(),
            'recordsFiltered' => $Student->count(),
            'data' => $Student,
        ]);
    }
    public function viewStudentWithAttendance(Request $request){
        $classId = $request->classId;
        $date = $request->date;
        $user = auth()->user();
        $Student = $user->studentAttendanceDetails($classId, $date);
        $attendencDetailsRender= [];
        foreach($Student as $student){
            if($student->attendence_type == "Present"){
                $attendencDetails = '<div class="d-flex justify-content-around"><div><input class="Attendance_type" type="radio" id="Present" checked="checked" name="fav_language" value="Present" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-success" for="html">Present</label><br></div><div><input class="Attendance_type" type="radio" id="Absent" name="fav_language" value="Absent" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-danger"for="html">Absent</label><br></div><div><input class="Attendance_type" type="radio" id="Half_Day" name="fav_language" value="Half Day" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-warning" for="html">Half Day</label><br></div><div><input class="Attendance_type" type="radio" id="leave" name="fav_language" value="leave" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-primary" for="html">leave</label><br></div><a class="link-info reset" data-id="'.$student->id.'"><i class="fas fa-undo"></i></div></a>';
            }elseif($student->attendence_type == "Absent"){
                $attendencDetails = '<div class="d-flex justify-content-around"><div><input class="Attendance_type" type="radio" id="Present" name="fav_language" value="Present" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-success" for="html">Present</label><br></div><div><input class="Attendance_type" type="radio" id="Absent" checked="checked" name="fav_language" value="Absent" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-danger"for="html">Absent</label><br></div><div><input class="Attendance_type" type="radio" id="Half_Day" name="fav_language" value="Half Day" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-warning" for="html">Half Day</label><br></div><div><input class="Attendance_type" type="radio" id="leave" name="fav_language" value="leave" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-primary" for="html">leave</label><br></div><a class="link-info reset" data-id="'.$student->id.'"><i class="fas fa-undo"></i></div></a>';
            }elseif($student->attendence_type == "Half Day"){
                $attendencDetails = '<div class="d-flex justify-content-around"><div><input class="Attendance_type" type="radio" id="Present" name="fav_language" value="Present" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-success" for="html">Present</label><br></div><div><input class="Attendance_type" type="radio" id="Absent" name="fav_language" value="Absent" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-danger"for="html">Absent</label><br></div><div><input class="Attendance_type" type="radio" id="Half_Day" checked="checked"name="fav_language" value="Half Day" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-warning" for="html">Half Day</label><br></div><div><input class="Attendance_type" type="radio" id="leave" name="fav_language" value="leave" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-primary" for="html">leave</label><br></div><a class="link-info reset" data-id="'.$student->id.'"><i class="fas fa-undo"></i></div></a>';
            }elseif($student->attendence_type == "leave"){
                $attendencDetails = '<div class="d-flex justify-content-around"><div><input class="Attendance_type" type="radio" id="Present" name="fav_language" value="Present" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-success" for="html">Present</label><br></div><div><input class="Attendance_type" type="radio" id="Absent" name="fav_language" value="Absent" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-danger"for="html">Absent</label><br></div><div><input class="Attendance_type" type="radio" id="Half_Day" name="fav_language" value="Half Day" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-warning" for="html">Half Day</label><br></div><div><input class="Attendance_type" type="radio" id="leave" checked="checked" name="fav_language" value="leave" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-primary" for="html">leave</label><br></div><a class="link-info reset" data-id="'.$student->id.'"><i class="fas fa-undo"></i></div></a>';
            }else{
                $attendencDetails = '<div class="d-flex justify-content-around"><div><input class="Attendance_type" type="radio" id="Present" name="fav_language" value="Present" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-success" for="html">Present</label><br></div><div><input class="Attendance_type" type="radio" id="Absent" name="fav_language" value="Absent" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-danger"for="html">Absent</label><br></div><div><input class="Attendance_type" type="radio" id="Half_Day" name="fav_language" value="Half Day" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-warning" for="html">Half Day</label><br></div><div><input class="Attendance_type" type="radio" id="leave" name="fav_language" value="leave" data-id="'.$student->id.'" data-name="'.$student->name.'" data-class_id="'.$student->class_id.'"> <label class="text-primary" for="html">leave</label><br></div><a class="link-info reset" data-id="'.$student->id.'"><i class="fas fa-undo"></i></div></a>';
            }
            $attendencDetailsRender[] = array(
                "id" => $student->id,
                'name' => $student->name,
                "attendence" => $attendencDetails,
            );
        }
        return response()->json([
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $Student->count(),
            'recordsFiltered' => $Student->count(),
            'data' => $attendencDetailsRender,
        ]);
    }
    // Attendance 
    public function studentAttendance(Request $request){

        $user = auth()->user();

        $schoolId = $user->school->id;
        $existingRecord = StudentAttendance::where('created_at', $request->date)->where('student_id', $request->id)->first();
        if($existingRecord){
            return response()->json(['message' => 'Attendance record already exists for the student on the same date'], 422);
    }
        $attendance = StudentAttendance::create([
            'name' => $request->name,
            'student_id' => $request->id,
            'school_id' => $schoolId,
            'class_id' => $request->class_id,
            'attendence_type' => $request->Attendance_type,
            'created_at' => $request->date,
        ]);
    }
    public function deleteStudentAttendance(Request $request){
        StudentAttendance::where('student_id',$request->studentId)
        ->wheredate('created_at', '=', $request->date)
        ->delete();
    }
}
