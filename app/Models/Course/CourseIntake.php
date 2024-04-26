<?php

namespace App\Models\course;

use App\Models\Course\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseIntake extends Model{
    use HasFactory;
    public $table = "course_intakes";

    public function course_data(){
        return $this->belongsTo(Course::class,'course_id');
    }
}
