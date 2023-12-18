<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;
    public $table = "class_schedules";

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function subject(){
        return $this->belongsTo(CourseSubject::class,'subject_id');
    }
}
