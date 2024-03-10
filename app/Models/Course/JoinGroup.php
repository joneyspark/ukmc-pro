<?php

namespace App\Models\Course;

use App\Models\Application\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinGroup extends Model
{
    use HasFactory;
    public function group(){
        return $this->belongsTo(CourseGroup::class,'group_id');
    }
    public function application_data(){
        return $this->belongsTo(Application::class,'application_id');
    }
}
