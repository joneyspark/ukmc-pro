<?php

namespace App\Models\Teacher;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    public $table = 'teachers';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
