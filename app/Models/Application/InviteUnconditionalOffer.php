<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteUnconditionalOffer extends Model
{
    use HasFactory;
    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }
}
