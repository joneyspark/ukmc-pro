<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseEditRequest;
use App\Models\Agent\Company;
use App\Models\Application\Application;
use App\Models\Application\ApplicationIntake;
use App\Models\Application\ApplicationStatus;
use App\Models\Campus\Campus;
use App\Models\Course\AttendenceConfirmation;
use App\Models\Course\AttendNote;
use App\Models\Course\ClassSchedule;
use App\Models\Course\Course;
use App\Models\Course\CourseAdditional;
use Illuminate\Support\Facades\Session;
use App\Traits\Service;
Use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use App\Models\Course\CourseCategories;
use App\Models\Course\CourseIntake;
use App\Models\Course\CourseLevel;
use App\Models\Course\CourseSubject;
use App\Models\Course\SubjectSchedule;
use App\Models\User;
use  Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;
use MeiliSearch\Client;
use Illuminate\Support\Str;
use App\Models\Course\CourseGroup;

class GroupController extends Controller
{
    public function create_course_group($id=NULL,$edit=NULL,$group_id=NULL){
        $data['page_title'] = 'Course | Subject';
        $data['course_intake_id'] = $id;
        $data['group_id'] = $group_id;
        if($group_id){
            $data['group_data'] = CourseGroup::where('id',$group_id)->first();
        }
        $data['groups'] = CourseGroup::where('course_intake_id',$id)->orderBy('id','desc')->paginate(15);
        $data['course'] = true;
        return view('course/group/create',$data);
    }
}
