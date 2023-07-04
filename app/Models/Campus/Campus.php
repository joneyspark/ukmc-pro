<?php

namespace App\Models\Campus;

use App\Models\Application\Application;
use App\Models\Course\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
    public $table = 'campuses';

    public function courses(){
        return $this->hasMany(Course::class);
    }
    public function application(){
        return $this->hasOne(Application::class);
    }

    public function total_applications(){
        return $this->hasMany(Application::class);
    }
    public function new_applications(){
        return $this->hasMany(Application::class)->where('status',1);
    }
    public function agent_applications(){
        return $this->hasMany(Application::class)->where('company_id','!=',0);
    }
    public function conditional_applications(){
        return $this->hasMany(Application::class)->where('status',9);
    }
    public function enrolled_applications(){
        return $this->hasMany(Application::class)->where('status',11);
    }
    public function reject_applications(){
        return $this->hasMany(Application::class)->where('status',12);
    }
}
