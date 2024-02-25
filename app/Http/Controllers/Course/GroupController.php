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
use App\Models\Course\JoinGroup;

class GroupController extends Controller
{
    public function create_course_group($id=NULL,$edit=NULL,$group_id=NULL){
        $data['page_title'] = 'Course | Group';
        $data['intake_id'] = $id;
        $data['course'] = true;
        if(!empty($group_id)){
            $data['group_data'] = CourseGroup::where('id',$group_id)->first();
        }
        return view('course/group/create',$data);
    }
    public function course_intake_group_list($id=NULL){
        $data['page_title'] = 'Course | Intake Group List';
        $data['course_intake_id'] = $id;
        $getIntake = CourseIntake::where('id',$id)->first();
        $data['groups'] = CourseGroup::where('course_intake_id',$id)->orderBy('id','desc')->paginate(15);
        $data['course'] = true;
        $data['course_id'] = $getIntake->course_id;
        return view('course/group/list',$data);
    }
    public function group_data_post(Request $request){
        $request->validate([
            'title'=>'required',
        ]);
        $getIntake = CourseIntake::where('id',$request->intake_id)->first();
        if($request->group_id){
            $group = CourseGroup::where('id',$request->group_id)->first();
        }else{
            $group = new CourseGroup();
        }
        $group->title = $request->title;
        $group->course_intake_id = $request->intake_id;
        $group->intake = (!empty($getIntake->intake_date))?$getIntake->intake_date:'';
        $group->save();
        Session::flash('success','Group Data Updated!');
        return redirect('course-intake-group-list/'.$getIntake->id);
    }
    public function group_status_change(Request $request){
        $courseGroup = CourseGroup::where('id',$request->group_id)->first();
        if(!$courseGroup){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Course Group Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($courseGroup->status==1){
            $courseGroup->status = 0;
            $courseGroup->save();
            $msg = 'Course Group Activated';
        }else{
            $courseGroup->status = 1;
            $courseGroup->save();
            $msg = 'Course Group Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    //join group
    public function join_group(Request $request){
        $request->validate([
            'group_id'=>'required',
            'assign_application_ids'=>'required'
        ]);
        $ids = $request->assign_application_ids;
        $arrayIds = explode(",",$ids);
        foreach($arrayIds as $row){
            $join = new JoinGroup();
            $join->application_id = $row;
            $join->group_id = $request->group_id;
            $join->save();
        }
        Session::flash('success',count($arrayIds) . 'Applicaton Assigned On This Group!');
        return redirect()->back();
    }
}
