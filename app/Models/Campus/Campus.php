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
}
