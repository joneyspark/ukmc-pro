<?php

namespace App\Models\Course;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendNote extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
}
