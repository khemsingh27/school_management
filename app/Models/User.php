<?php

namespace App\Models;

// use App\Models\DB;
use Illuminate\Support\Facades\DB;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function school()
    {
        return $this->hasOne(School::class, 'users_id');
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'users_id');
    }
    public function student(){
        return $this->hasOne(Student::class, 'users_id');
    } 
    public function teacherDetails()
    {
        $userSchoolId = auth()->user()->school->id;
    
        $users = DB::table('users')
            ->join('teachers', 'users.id', '=', 'teachers.users_id')
            ->join('teacher_classes', 'teachers.id', '=', 'teacher_classes.teacher_id')
            ->join('schools', 'schools.id', '=', 'teachers.school_id')
            ->where('schools.id', '=', $userSchoolId)
            ->select('teachers.id', 'users.name', 'users.email', 'teacher_classes.class_id')
            ->get();
    
        return $users;
    }
    public function studentDetails()
    {
        $userSchoolId = auth()->user()->school->id;

        $Student = DB::table('users')
        ->join('students', 'users.id', '=', 'students.users_id')
        ->join('schools', 'schools.id', '=', 'students.school_id')
        ->where('schools.id', '=', $userSchoolId)
        ->select('students.id', 'users.name', 'users.email', 'students.class_id')
        ->get();
        return $Student;
    }
    public function studentAttendanceDetails($classId)
    {
        $userSchoolId = auth()->user()->school->id;
        $Student = DB::table('users')
        ->join('students', 'users.id', '=', 'students.users_id')
        ->join('schools', 'schools.id', '=', 'students.school_id')
        ->leftJoin('student_attendance', 'student_attendance.student_id', '=', 'students.id')
        ->where('schools.id', '=', $userSchoolId)
        ->where('students.class_id', '=', $classId)
        ->select('students.id', 'users.name', 'users.email', 'students.class_id', 'student_attendance.attendence_type')
        ->get();
        return $Student;
    }

    public function deleteTeacher($id, $email)
    {
        DB::table('teacher_classes')->where('teacher_id', $id)->delete();
        DB::table('teachers')->where('id', $id)->delete();
        DB::table('users')->where('email', $email)->delete();
        return true;
    }
}