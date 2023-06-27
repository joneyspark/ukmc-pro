<?php

namespace App\Models\Agent;

use App\Models\Application\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public $table = 'companies';

    public function users(){
        return $this->hasMany(User::class);
    }
    public function applications(){
        return $this->hasMany(Application::class);
    }

}
