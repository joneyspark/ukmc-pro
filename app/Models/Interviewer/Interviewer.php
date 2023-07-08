<?php

namespace App\Models\Interviewer;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interviewer extends Model
{
    use HasFactory;
    public $table = 'interviewers';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
