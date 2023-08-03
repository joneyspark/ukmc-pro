<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationSop extends Model
{
    use HasFactory;
    public $table = "application_sops";

    public function application(){
        return $this->belongsTo(Application::class);
    }
}
