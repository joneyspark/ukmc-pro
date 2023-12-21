<?php

namespace App\Models\Course;

use App\Models\Application\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendenceConfirmation extends Model
{
    use HasFactory;
    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
