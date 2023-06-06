<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\AddNewLead;
use App\Http\Requests\Application\Step1Request;
use App\Models\Agent\Company;
use App\Models\Application\Application;
use App\Models\Campus\Campus;
use App\Models\Course\Course;
use App\Models\Course\CourseLevel;
use Carbon\Carbon;
use App\Traits\Service;

class ApplicationController extends Controller{
    use Service;
    public function create($id=NULL){

        $data['page_title'] = 'Application | Create';
        $data['application'] = true;
        $data['application_add'] = true;
        $data['a_company_data'] = Company::where('status',1)->get();
        $data['a_campuses_data'] = Campus::where('active',1)->get();
        $data['intakes'] = Service::get_intake_with_next_year();
        $data['residential_status'] = Service::residential_status();
        $data['programs'] = Service::program();
        $data['course_levels1'] = CourseLevel::where('status',0)->get();
        $data['delivery_pattern'] = Service::delivery_pattern();
        $data['name_title'] = Service::name_title();
        $data['gender'] = Service::gender();
        $data['apply_apl'] = Service::apply_apl();
        $data['app_data'] = Application::where('id',$id)->first();
        if($data['app_data']){
            $data['course_list_data'] = Course::where('campus_id',$data['app_data']->campus_id)->get();
        }
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_1',$data);
    }
    public function step_1_post(Step1Request $request){

    }
    public function get_courses_by_campus(Request $request){
        $campus = Campus::where('id',$request->campus_id)->first();
        if(!$campus){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Campus Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $courses = Course::where('campus_id',$campus->id)->orderBy('course_name','asc')->get();
        if($courses){
            $select = '';
            $select .= '<option selected>Choose...</option>';
            foreach($courses as $row){
                $select .= '<option value="'.$row->id.'">'.$row->course_name.'</option>';
            }
            $data['result'] = array(
                'key'=>200,
                'val'=>$select
            );
            return response()->json($data,200);
        }else{
            $data['result'] = array(
                'key'=>101,
                'val'=>'No Courses Found! Select Another Campus!'
            );
            return response()->json($data,200);
        }
    }
    //get course info
    public function get_course_info(Request $request){
        $course = Course::where('id',$request->course_id)->first();
        if(!$course){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Course Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $sintake = '';
        $course_fee_local = $course->course_fee;
        $course_fee_international = $course->international_course_fee;
        $getIntakes = explode(",",$course->course_intake);
        foreach($getIntakes as $irow){
            if(!empty($irow)){
                $sintake .= '<span style="margin-left:3px;" class="badge badge-info">'.$irow.'</span>';
            }
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$sintake,
            'course_fee_local'=>$course_fee_local,
            'course_fee_international'=>$course_fee_international,
        );
        return response()->json($data,200);
    }
    public function create_step_2(){
        $data['page_title'] = 'Application | Create | Step 2';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_2',$data);
    }
    public function create_step_3(){
        $data['page_title'] = 'Application | Create | Step 3';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_3',$data);
    }
    public function create_step_4(){
        $data['page_title'] = 'Application | Create | Step 4';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_4',$data);
    }
    public function create_step_5(){
        $data['page_title'] = 'Application | Create | Step 5';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_5',$data);
    }
    public function create_step_6(){
        $data['page_title'] = 'Application | Create | Step 6';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_6',$data);
    }
    public function all(){
        $data['page_title'] = 'Application / All';
        $data['application'] = true;
        $data['application_all'] = true;
        return view('application/all',$data);
    }
    public function ongoing(){
        $data['page_title'] = 'Application / Ongoing';
        $data['application'] = true;
        $data['application_ongoing'] = true;
        return view('application/ongoing',$data);
    }
    public function enrolled(){
        $data['page_title'] = 'Application / Enrolled';
        $data['application'] = true;
        $data['application_enrolled'] = true;
        return view('application/enrolled',$data);
    }
    public function archive_students(){
        $data['page_title'] = 'Archived / Students';
        $data['application'] = true;
        $data['application_archived'] = true;
        return view('application/archived',$data);
    }
    public function application_details(){
        $data['page_title'] = 'Application | Details';
        $data['application'] = true;
        $data['application_all'] = true;
        return view('application/details',$data);
    }
}
