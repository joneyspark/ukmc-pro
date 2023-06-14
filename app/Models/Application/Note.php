<?php

namespace App\Models\Application;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
