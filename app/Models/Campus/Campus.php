<?php

namespace App\Models\Campus;

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
}
