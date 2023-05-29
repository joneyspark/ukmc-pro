<?php

namespace App\Models\Agent;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentTask extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }
}
