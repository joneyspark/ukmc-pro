<?php

namespace App\Models\Application;

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
    ];

    public function searchableAs(): string
    {
        return 'applications';
    }
}
