<?php

namespace App\Models\University;

use App\Models\Application\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    public function applications(){
        return $this->hasMany(Application::class);
    }
}
