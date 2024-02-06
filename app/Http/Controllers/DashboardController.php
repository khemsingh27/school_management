<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function teachers()
    {
        return view('dashboard.teachers.addteacher', ['title' => 'Teachers']);
    }
    public function students()
    {
        return view('dashboard.students.addStudent', ['title' => 'Studnets']);
    }
    public function classes()
    {
        return view('dashboard.classes_.addClasses', ['title' => 'Classes']);
    }
    public function attendance()
    {
        return view('dashboard.attendance.studentAttendance', ['title' => 'StudentAttendance']);
    }
    public function teacher_attendance()
    {
        return view('dashboard.attendance.teacherAttendance', ['title' => 'TeacherAttendance']);
    }
}
