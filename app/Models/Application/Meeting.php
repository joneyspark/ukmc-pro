<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Meeting extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
