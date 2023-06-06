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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        if($request->application_id){
            $application = Application::where('id',$request->application_id)->first();
            $application->update_by = (!empty(Auth::user()->id))?Auth::user()->id:0;
            $application->email = $request->email;
        }else{
            $application = new Application();
            $email = $request->email;
            $checkApp = Application::where('email',$email)->first();
            if($checkApp){
                Session::flash('error','Email Already Exists! Use Another Email or Search Application By Email!');
                return redirect('application-create');
            }else{
                $application->email = $email;
            }
            $application->steps = '1';
            $application->admission_officer_id = 0;
            $application->application_status_id = 0;
            $application->is_final_interview = 0;
            $application->application_process_status = 0;
            $application->status = 0;
            $application->create_by = (!empty(Auth::user()->id))?Auth::user()->id:0;
        }
        $application->company_id = $request->company_id;
        $application->applicant_fees_funded = $request->applicant_fees_funded;
        $application->current_residential_status = $request->current_residential_status;
        $application->campus_id = $request->campus_id;
        $application->course_id = $request->course_id;
        $application->local_course_fee = $request->local_course_fee;
        $application->international_course_fee = $request->international_course_fee;
        $application->course_program = $request->course_program;
        $application->intake = $request->intake;
        $application->course_level = $request->course_level;
        $application->delivery_pattern = $request->delivery_pattern;
        $application->title = $request->title;
        $application->first_name = $request->first_name;
        $application->last_name = $request->last_name;
        $application->name = $request->title.' '.$request->first_name.' '.$request->last_name;
        $application->gender = $request->gender;
        $application->date_of_birth = $request->date_of_birth;
        $application->phone = $request->phone;
        $application->is_applying_advanced_entry = $request->is_applying_advanced_entry;
        $application->save();
        Session::flash('success','Step 1 Complete. Now Complete Step 2!');
        return redirect('application-create/'.$application->id.'/step-2');
    }
    
    public function create_step_2($id=NULL){
        $current_step = 1;
        $application = Application::where('id',$id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('application-create');
        }
        $step_arr = explode(",",$application->steps);
        if(!in_array($current_step,$step_arr)){
            Session::flash('error','Complete Cerrent Step Then Proced!');
            return redirect('application-create');
        }
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
}
