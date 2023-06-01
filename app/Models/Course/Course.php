<?php

namespace App\Models\Course;

use App\Models\Campus\Campus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

class Course extends Model
{
    use HasFactory, Searchable;
    protected $table = 'courses';


    protected $fillable = [
        'campus_id',
        'category_id',
        'course_level_id',
        'course_name',
        'course_duration',
        'course_intake',
        'course_fee',
        'international_course_fee',
        'awarding_body',
        'is_lang_mendatory',
        'lang_requirements',
        'per_time_work_details',
        'addtional_info_course',
        'course_prospectus',
        'course_module',
        'status',
    ];

    public static function searchableAttributes()
    {
        return ['course_name', 'course_intake'];
    }
    public static function searchFilterableAttributes()
    {
        return ['campus_id', 'category_id', 'course_level_id'];
    }
    public static function searchSortableAttributes()
    {
        return ['id','created_at'];
    }
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $dateInMs = Carbon::createFromDate($array['created_at'])->getTimestampMs();
        $dateInMsUpdated = Carbon::createFromDate($array['updated_at'])->getTimestampMs();
        $array['created_at'] = $dateInMs;
        $array['updated_at'] = $dateInMsUpdated;

        return $array;
    }
    public function campus(){
        return $this->belongsTo(Campus::class);
    }
    public function category(){
        return $this->belongsTo(CourseCategories::class,'category_id','id');
    }
    public function course_level(){
        return $this->belongsTo(CourseLevel::class,'course_level_id','id');
    }
}
