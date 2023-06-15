<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admission\AdmissionOfficer;
use App\Models\Agent\Agent;
use App\Models\Agent\AgentTask;
use App\Models\Application\Application;
use App\Models\Application\Followup;
use App\Models\Application\Note;
use App\Models\Application\RequestDocument;
use App\Models\Task\Task;
use App\Models\Teacher\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teacher(){
        return $this->hasOne(Teacher::class);
    }
    public function officer(){
        return $this->hasOne(AdmissionOfficer::class);
    }
    public function company(){
        return $this->belongsTo(User::class);
    }
    public function agent(){
        return $this->hasOne(Agent::class);
    }
    public function tasks(){
        return $this->hasMany(Task::class, 'assign_to', 'id');
    }
    public function agent_tasks(){
        return $this->hasMany(AgentTask::class, 'assign_to', 'id');
    }
    public function applications(){
        return $this->hasMany(Application::class,'admission_officer_id','id');
    }
    public function documents(){
        return $this->hasMany(RequestDocument::class,'request_by','id');
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function followups(){
        return $this->hasMany(Followup::class);
    }
}
