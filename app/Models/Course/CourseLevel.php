<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model{
    use HasFactory;
    public $table = 'course_levels';
    public function courses(){
        return $this->hasMany(Course::class,'course_level_id','id');
    }
}
