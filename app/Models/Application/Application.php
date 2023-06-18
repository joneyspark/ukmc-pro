<?php

namespace App\Models\Application;

use App\Models\Campus\Campus;
use App\Models\Course\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Scout\Searchable;

class Application extends Model
{
    use HasFactory,Searchable;
    protected $table = 'applications';

    protected $fillable = [
        'company_id',
        'applicant_fees_funded',
        'current_residential_status',
        'campus_id',
        'course_id',
        'local_course_fee',
        'international_course_fee',
        'course_program',
        'intake',
        'course_level',
        'delivery_pattern',
        'title',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'phone',
        'is_applying_advanced_entry',
        'admission_officer_id',
        'application_status_id',
        'is_final_interview',
        'steps',
        'application_process_status',
        'status',
        'create_by',
        'update_by',
    ];

    public function searchableAs(): string
    {
        return 'applications';
    }
    public function step2Data(){
        return $this->hasOne(Application_Step_2::class);
    }
    public function step3Data(){
        return $this->hasOne(Application_Step_3::class);
    }
    public function applicationDocuments(){
        return $this->hasMany(ApplicationDocument::class);
    }
    public function campus(){
        return $this->belongsTo(Campus::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function assign(){
        return $this->belongsTo(User::class,'admission_officer_id','id');
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function meetings(){
        return $this->hasMany(Meeting::class);
    }
    public function followups(){
        return $this->hasMany(Followup::class);
    }
}
