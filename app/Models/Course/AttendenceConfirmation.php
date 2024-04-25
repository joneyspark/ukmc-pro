<?php

namespace App\Models\Course;

use App\Models\Application\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendenceConfirmation extends Model
{
    use HasFactory;
    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }
    public function group(){
        return $this->belongsTo(CourseGroup::class,'course_group_id');
    }
    public function class_schedule(){
        return $this->belongsTo(ClassSchedule::class,'class_schedule_id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function subject(){
        return $this->belongsTo(CourseSubject::class,'subject_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
