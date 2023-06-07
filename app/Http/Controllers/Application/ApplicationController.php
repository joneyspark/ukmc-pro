<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\AddNewLead;
use App\Http\Requests\Application\ApplicationStep2Request;
use App\Http\Requests\Application\ApplicationStep3Request;
use App\Http\Requests\Application\Step1Request;
use App\Models\Agent\Company;
use App\Models\Application\Application;
use App\Models\Application\Application_Step_2;
use App\Models\Application\Application_Step_3;
use App\Models\Application\ApplicationDocument;
use App\Models\Campus\Campus;
use App\Models\Course\Course;
use App\Models\Course\CourseLevel;
use Carbon\Carbon;
use App\Traits\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        $data['app_data_2'] = Application_Step_2::where('application_id',$id)->first();
        $data['nationalities'] = Service::nationalities();
        $data['ethnic_origins'] = Service::ethnic_origin();
        $data['country_of_birth'] = Service::countries();
        $data['highest_qualifications'] = Service::highest_qualifications();
        $data['last_institution_to_be_attend'] = Service::last_institution_to_be_attend();
        $data['application_id'] = $application->id;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_2',$data);
    }
    public function step_2_post(ApplicationStep2Request $request){
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            Session::flash('error','Internal Server Error!');
            return redirect('application-create');
        }
        if($request->app_step_2_id){
            $application_step2 = Application_Step_2::where('id',$request->app_step_2_id)->first();
        }else{
            //update step
            $application->steps = $application->steps.','.'2';
            $application->save();
            $application_step2 = new Application_Step_2();
        }
        $application_step2->application_id = $application->id;
        $application_step2->nationality = $request->nationality;
        $application_step2->other_nationality = $request->other_nationality;
        $application_step2->ethnic_origin = $request->ethnic_origin;
        $application_step2->country = $request->country;
        $application_step2->highest_qualification_entry = $request->highest_qualification_entry;
        $application_step2->highest_qualification = $request->highest_qualification;
        $application_step2->last_institution_you_attended = $request->last_institution_you_attended;
        $application_step2->unique_learner_number = $request->unique_learner_number;
        $application_step2->name_of_qualification = $request->name_of_qualification;
        $application_step2->you_obtained = $request->you_obtained;
        $application_step2->subject = $request->subject;
        $application_step2->grade = $request->grade;
        $application_step2->passport_no = $request->passport_no;
        $application_step2->passport_expiry = $request->passport_expiry;
        $application_step2->passport_place = $request->passport_place;
        $application_step2->spent_public_care = $request->spent_public_care;
        $application_step2->disability = $request->disability;
        $application_step2->house_number = $request->house_number;
        $application_step2->address_line_2 = $request->address_line_2;
        $application_step2->city = $request->city;
        $application_step2->state = $request->state;
        $application_step2->postal_code = $request->postal_code;
        $application_step2->address_country = $request->address_country;
        $application_step2->same_as = $request->same_as;
        $application_step2->current_house_number = $request->current_house_number;
        $application_step2->current_address_line_2 = $request->current_address_line_2;
        $application_step2->current_city = $request->current_city;
        $application_step2->current_state = $request->current_state;
        $application_step2->current_postal_code = $request->current_postal_code;
        $application_step2->current_country = $request->current_country;
        $application_step2->kin_name = $request->kin_name;
        $application_step2->kin_relation = $request->kin_relation;
        $application_step2->kin_email = $request->kin_email;
        $application_step2->kin_phone = $request->kin_phone;
        $application_step2->save();
        Session::flash('success','Step 2 Complete. Goto Step 3');
        return redirect('application-create/'.$application->id.'/step-3');

    }
    public function create_step_3($id=NULL){
        $current_step = 2;
        $application = Application::where('id',$id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('application-create');
        }
        $step_arr = explode(",",$application->steps);
        if(!in_array($current_step,$step_arr)){
            Session::flash('error','Complete Step 2 Then Proced!');
            return redirect('application-create/'.$application->id.'/step-2');
        }
        $data['app_data3'] = Application_Step_3::where('application_id',$application->id)->first();
        $data['application_id'] = $application->id;
        $data['page_title'] = 'Application | Create | Step 3';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_3',$data);
    }
    public function step_3_post(ApplicationStep3Request $request){
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            Session::flash('error','Internal Server Error!');
            return redirect('application-create');
        }
        if($request->application_step3_id){
            $application_step3 = Application_Step_3::where('id',$request->application_step3_id)->first();
        }else{
            //update step
            $application->steps = $application->steps.','.'3';
            $application->save();
            $application_step3 = new Application_Step_3();
        }
        $application_step3->application_id = $application->id;
        $application_step3->personal_statement = $request->personal_statement;
        $application_step3->save();
        Session::flash('success','Step 3 Complete. Goto Step 4');
        return redirect('application-create/'.$application->id.'/step-4');
    }
    public function create_step_4($id=NULL){
        $current_step = 3;
        $application = Application::where('id',$id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('application-create');
        }
        $step_arr = explode(",",$application->steps);
        if(!in_array($current_step,$step_arr)){
            Session::flash('error','Complete Step 3 Then Proced!');
            return redirect('application-create/'.$application->id.'/step-3');
        }
        //update step
        $document = ApplicationDocument::where('application_id',$application->id)->count();
        if($document > 2){
            $up_step = 4;
            $get_application = Application::where('id',$id)->first();
            $array = explode(",",$get_application->steps);
            if(!in_array($up_step,$array)){
                $update_step = $get_application->steps.','.$up_step;
                $get_application->steps = $update_step;
                $get_application->save();
            }
        }
        $data['document_count'] = $document;
        $data['application_documents'] = ApplicationDocument::where('application_id',$application->id)->get();
        $data['application_id'] = $application->id;
        $data['page_title'] = 'Application | Create | Step 4';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_4',$data);
    }
    //step 4 post
    public function step_4_post(Request $request){
        $validator = Validator::make($request->all(), [
            'document_type' => 'required',
            'doc' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('application-create');
        }
        $document = new ApplicationDocument();
        $document->application_id = $application->id;
        $document->document_type = $request->document_type;
        $doc = $request->doc;
        if ($request->hasFile('doc')) {
            $ext = $doc->getClientOriginalExtension();
            $doc_file_name = $doc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 999).'.'.$ext;
            $upload_path1 = 'backend/images/application/doc/'.$application->id.'/';
            Service::createDirectory($upload_path1);
            $request->file('doc')->move(public_path('backend/images/application/doc/'.$application->id.'/'), $doc_file_name);
            $document->doc = $upload_path1.$doc_file_name;
        }
        $document->save();
        Session::flash('success','Document Saved Successfully!');
        return redirect('application-create/'.$application->id.'/step-4');
    }
    //upload application document
    public function upload_application_document(Request $request){
        
    }
    public function create_step_5($id=NULL){
        $current_step = 4;
        $application = Application::where('id',$id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('application-create');
        }
        $step_arr = explode(",",$application->steps);
        if(!in_array($current_step,$step_arr)){
            Session::flash('error','Complete Step 4 Then Proced!');
            return redirect('application-create/'.$application->id.'/step-4');
        }
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
