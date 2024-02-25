<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinGroup extends Model
{
    use HasFactory;
    public function group(){
        return $this->belongsTo(CourseGroup::class,'group_id');
    }
}
