<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGroup extends Model
{
    use HasFactory;
    public function total_application(){
        return $this->hasMany(JoinGroup::class,'group_id');
    }
}
