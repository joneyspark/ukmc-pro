<?php

namespace App\Models\Application;

use App\Models\Agent\Company;
use App\Models\Campus\Campus;
use App\Models\Course\Course;
use App\Models\University\University;
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
        'reference',
        'title',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'phone',
        'ni_number',
        'emergency_contact_name',
        'emergency_contact_number',
        'house_number',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'address_country',
        'same_as',
        'current_house_number',
        'current_address_line_2',
        'current_city',
        'current_state',
        'current_postal_code',
        'current_country',
        'nationality',
        'other_nationality',
        'visa_category',
        'date_entry_of_uk',
        'ethnic_origin',
        'university_id',
        'course_id',
        'local_course_fee',
        'international_course_fee',
        'intake',
        'delivery_pattern',
        'admission_officer_id',
        'marketing_officer_id',
        'manager_id',
        'interviewer_id',
        'interview_status',
        'is_academic',
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
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function university(){
        return $this->belongsTo(University::class);
    }
    public function interviewer(){
        return $this->belongsTo(User::class,'interviewer_id','id');
    }
    public function sop(){
        return $this->hasOne(ApplicationSop::class);
    }
}
