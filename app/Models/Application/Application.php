<?php

namespace App\Models\Application;

use App\Models\Agent\Company;
use App\Models\Campus\Campus;
use App\Models\Course\AttendenceConfirmation;
use App\Models\Course\Course;
use App\Models\University\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
//use Laravel\Scout\Searchable;

class Application extends Model
{
    use HasFactory;
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

    // public function searchableAs(): string
    // {
    //     return 'applications';
    // }
    public function applicant_attendence(){
        return $this->hasOne(AttendenceConfirmation::class,'application_id');
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
    public function sub_agent(){
        return $this->belongsTo(User::class,'create_by');
    }
    public function sop(){
        return $this->hasOne(ApplicationSop::class);
    }
    public function eligible(){
        return $this->hasOne(Eligibility::class,'application_id');
    }
    public static function timeLeft($passTime)
    {
        //echo $time;
        $time = time() - $passTime;
        $year = floor($time / (365 * 24 * 60 * 60));
        $month = floor($time / (30 * 24 * 60 * 60));
        $week = floor($time / (7 * 24 * 60 * 60));
        $day = floor($time / (24 * 60 * 60));
        $hour = floor($time / (60 * 60));
        $minute = floor(($time / 60) % 60);
        $seconds = $time % 60;
        if ($year != 0) {
            return $year.' year ago';
        } elseif ($month != 0) {
            return $month.' month ago';
        } elseif ($week != 0) {
            return $week.' week ago';
        } elseif ($day != 0) {
            return $day.' day ago';
        } elseif ($hour != 0) {
            return $hour.' hour ago';
        } elseif ($minute != 0) {
            return $minute.' minutes ago';
        } else {
            return $seconds.' seconds ago';
        }
        //return $hour.' hour '.$minute.' minutes '.$seconds.' seconds ago';
    }
}
