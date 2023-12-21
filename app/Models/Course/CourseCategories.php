<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategories extends Model
{
    use HasFactory;
    public $table = 'course_categories';
    public function courses(){
        return $this->hasMany(Course::class,'category_id','id');
    }
}
