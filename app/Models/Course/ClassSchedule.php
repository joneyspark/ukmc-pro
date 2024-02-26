<?php

namespace App\Models\Course;

use App\Models\course\CourseIntake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model{
    use HasFactory;
    public $table = "class_schedules";
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function subject(){
        return $this->belongsTo(CourseSubject::class,'subject_id');
    }
    public function intake(){
        return $this->belongsTo(CourseIntake::class,'intake_id');
    }
    public function subject_schedule(){
        return $this->belongsTo(SubjectSchedule::class,'subject_schedule_id');
    }
}
