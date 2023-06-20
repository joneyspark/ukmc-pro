<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\AddNewLead;
use App\Events\AdminMsgEvent;
use App\Events\AgentEvent;
use App\Http\Requests\Application\ApplicationStep2Request;
use App\Http\Requests\Application\ApplicationStep3Request;
use App\Http\Requests\Application\Step1Request;
use App\Models\Agent\Company;
use App\Models\Application\Application;
use App\Models\Application\Application_Step_2;
use App\Models\Application\Application_Step_3;
use App\Models\Application\Application_Step_5;
use App\Models\Application\Application_Step_6;
use App\Models\Application\ApplicationDocument;
use App\Models\Application\RequestDocument;
use App\Models\Campus\Campus;
use App\Models\Course\Course;
use App\Models\Course\CourseLevel;
use App\Models\Notification\Notification;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\requestDocumentMail;
use App\Models\Application\Followup;
use App\Models\Application\Meeting;
use App\Models\Application\Status;

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
            // 1 for agent, 2 for web
            if(Auth::user()->role=='agent'){
                $application->application_process_status = 1;
            }
            if(Auth::user()->role=='student'){
                $application->application_process_status = 2;
            }else{
                $application->application_process_status = 1; 
            }
            //$application->application_process_status = 1;
            $application->status = 1;
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
        $data['application_data'] = $application;
        $data['requested_documents'] = RequestDocument::where('application_id',$application->id)->where('status',0)->get();
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
        $data['app_step_5'] = Application_Step_5::where('application_id',$application->id)->first();
        $data['app_data'] = $application;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_5',$data);
    }
    //step 5 post
    public function step_5_post(Request $request){
        $role = Auth::user()->role;
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            Session::flash('error','Internal Server Error!');
            return redirect('application-create');
        }
        if($request->application_step5_id){
            $application_step5 = Application_Step_5::where('id',$request->application_step5_id)->first();
        }else{
            //update step
            $application->steps = $application->steps.','.'5';
            $application->application_status_id = 1;
            $application->save();
            //make notification
            if(Auth::user()->role=='agent'){
                $notification = new Notification();
                $notification->title = 'New Application';
                $notification->description = 'New Application Create By '.Auth::user()->name;
                $notification->create_date = time();
                $notification->create_by = Auth::user()->id;
                $notification->creator_name = Auth::user()->name;
                $notification->creator_image = Auth::user()->photo;
                $notification->user_id = 1;
                $notification->is_admin = 1;
                $notification->application_id = $application->id;
                $notification->slug = 'application/'.$application->id.'/details';
                $notification->save();
                //make instant messaging
                $message = 'New Application Create By '.Auth::user()->name;
                $url = url('application/'.$application->id.'/details');
                event(new AddNewLead($message,$url));
            }
            if(Auth::user()->role=='admin' || Auth::user()->role=='adminManager'){
                $notification = new Notification();
                $notification->title = 'New Application';
                $notification->description = 'New Application Create By '.Auth::user()->name;
                $notification->create_date = time();
                $notification->create_by = Auth::user()->id;
                $notification->creator_name = Auth::user()->name;
                $notification->creator_image = Auth::user()->photo;
                $notification->user_id = 1;
                $notification->is_admin = 1;
                $notification->application_id = $application->id;
                $notification->slug = 'application/'.$application->id.'/details';
                $notification->save();
                $message = 'New Application Create By '.Auth::user()->name;
                $url = url('application/'.$application->id.'/details');
                event(new AddNewLead($message,$url));
            }
            $application_step5 = new Application_Step_5();
            $application_step5->user_id = Auth::user()->id;
        }
        $application_step5->application_id = $application->id;
        $application_step5->save();
        if($role=='agent'){
            Session::flash('success','Application Successfully Submitted!');
            return redirect('agent-applications');
        }
        //if create by superadmin or admimission manager then go proced
        Session::flash('success','Application Submitted! Wait for Interview!');
        return redirect('application-create/'.$application->id.'/step-6');

    }

    public function create_step_6($id=NULL){
        $current_step = 5;
        $application = Application::where('id',$id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('application-create');
        }
        $step_arr = explode(",",$application->steps);
        if(!in_array($current_step,$step_arr)){
            Session::flash('error','Application Is Not Ready For Interview!');
            return redirect('application-create/'.$application->id.'/step-3');
        }
        $data['app_step6'] = Application_Step_6::where('application_id',$application->id)->first();
        $data['result_shows'] = Service::result_shows();
        $data['page_title'] = 'Application | Create | Step 6';
        $data['application_id'] = $application->id;
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_6',$data);
    }
    //step 6 post
    public function step_6_post(Request $request){
        $role = Auth::user()->role;
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            Session::flash('error','Internal Server Error!');
            return redirect('application-create');
        }
        if($request->app_step6_id){
            $application_step6 = Application_Step_6::where('id',$request->app_step6_id)->first();
        }else{
            //update step
            $application->steps = $application->steps.','.'6';
            $application->is_final_interview = 1;
            $application->save();
            $application_step6 = new Application_Step_6();
            $application_step6->interview_date = $request->interview_date;
            $application_step6->interview_time = $request->interview_time;
            $application_step6->results = $request->results;
            $application_step6->show = $request->show;
        }
        $application_step6->application_id = $application->id;
        $application_step6->save();
        Session::flash('success','Interview Done of This Application');
        return redirect('all-application');
    }
    public function application_details_by_admin($id=NULL){
        if(!Auth::user()){
            Session::flash('error','Auth Error!');
            return redirect('login');
        }
        if(Auth::user()->role == 'agent'){
            Session::flash('error','You dont have any permission to see application details');
            return redirect('login');
        }
        $data['page_title'] = 'Application | Details';
        $data['application'] = true;
        $data['application_all'] = true;
        $data['app_data'] = Application::where('id',$id)->first();
        return view('application.details',$data);
    }
    public function confirm_request_document($id=NULL){
        $check = RequestDocument::where('id',$id)->first();
        if(!$check){
            Session::flash('error','Requested Document Data Not Found!');
            return redirect('all-application');
        }
        $update = RequestDocument::where('id',$check->id)->update(['status'=>1]);
        $notification = new Notification();
        $notification->title = 'Document Confirmation';
        $notification->description = 'Requested Document Upload By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = $check->request_by;
        $notification->is_admin = 0;
        $notification->application_id = $check->application_id;
        $notification->slug = 'application-create/'.$check->application_id.'/step-4';
        $notification->save();
        event(new AddNewLead($notification->description,url($notification->slug)));
        return redirect('application-create/'.$check->application_id.'/step-4');
    }
    public function interview_list(){
        $data['page_title'] = 'Application | Details';
        $data['application'] = true;
        $data['interview_list'] = true;
        $data['meetings'] = Meeting::where('user_id',Auth::user()->id)->where('is_meeting_done',0)->take(20)->get();
        $data['followups'] = Followup::where('user_id',Auth::user()->id)->where('is_follow_up_done',0)->take(20)->get();
        return view('application.interview_list',$data);
    }

    public function agent_applications(){
        $data['page_title'] = 'Application | Details';
        $data['application'] = true;
        $data['application_all'] = true;
        $data['agent_applications'] = Application::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('application.agent.all',$data);
    }
    public function agent_application_details($id=NULL){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['application_all'] = true;
        if(Auth::user()->role=='agent'){
            $data['app_data'] = Application::where('company_id',Auth::user()->company_id)->where('id',$id)->first();
        }else{
            $data['app_data'] = Application::where('id',$id)->first();
        }
        return view('application.agent.details',$data);
    }
    public function main_application_details($id=NULL){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['application_all'] = true;
        $data['app_data'] = Application::where('id',$id)->first();
        return view('application.details',$data);
    }
    public function pending_applications(){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['application_pending'] = true;
        $data['agent_applications'] = Application::orderBy('id','desc')->where('application_status_id',0)->paginate(10);
        return view('application/pending',$data);
    }
    public function application_processing($id=NULL){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['application_all'] = true;
        $data['application_info'] = Application::where('id',$id)->first();
        $data['application_status'] = Status::where('status',0)->get();
        return view('application/processing',$data);
    }
    public function all(Request $request){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['application_all'] = true;
        $get_campus = $request->campus;
        $get_agent = $request->agent;
        $get_officer = $request->officer;
        $get_status = $request->status;
        $get_intake = $request->intake;
        $search = $request->q;
        //Session set data
        Session::put('get_campus',$get_campus);
        Session::put('get_agent',$get_agent);
        Session::put('get_officer',$get_officer);
        Session::put('get_status',$get_status);
        Session::put('get_intake',$get_intake);
        Session::put('search',$search);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = User::where('role','agent')->where('active',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['statuses'] = Status::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();

        $data['application_list'] = Application::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->when($get_campus, function ($query, $get_campus) {
            return $query->where('campus_id',$get_campus);
        })
        ->when($get_agent, function ($query, $get_agent) {
            return $query->where('company_id',$get_agent);
        })
        ->when($get_officer, function ($query, $get_officer) {
            return $query->where('admission_officer_id',$get_officer);
        })
        ->when($get_status, function ($query, $get_status) {
            return $query->where('status',$get_status);
        })
        ->when($get_intake, function ($query, $get_intake) {
            return $query->where('intake',$get_intake);
        })
        ->where('application_status_id','!=',0)
        ->orderBy('id','desc')
        ->paginate(15)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_campus,
            'officer' => $get_campus,
            'status' => $get_campus,
            'intake' => $get_campus,
        ]);

        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');
        //$data['application_list'] = Application::where('application_status_id','!=',0)->orderBy('id','desc')->paginate(15);
        return view('application/all',$data);
    }
    public function reset_application_search(){
        Session::put('get_campus','');
        Session::put('get_agent','');
        Session::put('get_officer','');
        Session::put('get_status','');
        Session::put('get_intake','');
        Session::put('search','');
        return redirect('all-application');
    }
    public function unique_intake_info()
    {
        $date_array = array();
        $return_date_array = array();
        $intakes = Application::select('intake')->pluck('intake')->filter()->unique()->values();
        //$intakes = Lead::select('intake_info')->distinct()->whereNotNull('intake_info')->get();
        if($intakes){
            foreach($intakes as $val){
                $date_array[] = strtotime($val);
            }
        }
        sort($date_array);
        foreach($date_array as $date){
            $return_date_array[] = date('Y-m',$date);
        }
        //return $intakes;
        $return_unique_date = array_unique($return_date_array);
        return $return_unique_date;
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
    //request doc file message
    public function request_document_message(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $application = Application::where('id',$request->set_application_id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found! Server Error!');
            return redirect('all-application');
        }
        $doc = new RequestDocument();
        $doc->application_id = $application->id;
        $doc->message = $request->message;
        $doc->request_by = Auth::user()->id;
        $doc->request_to = $application->create_by;
        $doc->save();
        $notification = new Notification();
        $notification->title = 'Document Request';
        $notification->description = 'New Document Requested By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = $application->create_by;
        $notification->is_admin = 1;
        $notification->application_id = $application->id;
        $notification->slug = 'application-create/'.$application->id.'/step-4';
        $notification->save();
        //make mail to student and agent
        $agentData = User::where('id',$application->create_by)->first();
        $studentEmail = $application->email;
        $agentEmail = $agentData->email;
        $details = [
            'create_by'=>Auth::user()->name,
            'message'=>$request->message,
        ];
        Mail::to($studentEmail)->send(new requestDocumentMail($details));
        Mail::to($agentEmail)->send(new requestDocumentMail($details));
        event(new AgentEvent($application->create_by,$notification->description,url('application-create/'.$application->id.'/step-4')));
        return redirect('application-create/'.$application->id.'/step-4');

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
    public function application_assign_to_me(Request $request){
        if(Auth::user()->role != 'adminManager'){
            $data['result'] = array(
                'key'=>101,
                'val'=>'You don,t have any permission To Assign Application!'
            );
            return response()->json($data,200);
        }
        $message = '';
        $application = Application::where('id',$request->application_id)->first();
        if($application->admission_officer_id != 0){
            if($application->admission_officer_id != Auth::user()->id){
                $data['result'] = array(
                    'key'=>101,
                    'val'=>'Application Assign By Other Admission Officer! Choose Another One!'
                );
                return response()->json($data,200);
            }
        }
        $notification = new Notification();

        if($application->admission_officer_id==Auth::user()->id){
            $application->admission_officer_id = 0;
            $message = 'Application Unassign By '.Auth::user()->name;
            $notification->title = 'Unassigned';
            $notification->description = 'Application Unassign By '.Auth::user()->name;
        }else{
            $application->admission_officer_id = Auth::user()->id;
            $message = 'Application Assign By '.Auth::user()->name;
            $notification->title = 'Assigned';
            $notification->description = 'Application Assign By '.Auth::user()->name;
        }
        $application->save();
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->application_id = $application->id;
        $notification->slug = 'application/'.$application->id.'/details';
        $notification->save();
        event(new AddNewLead($message,url('application/'.$application->id.'/details')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$message,
            'application_id'=>$application->id,
        );
        return response()->json($data,200);
    }
    //application status change
    public function application_status_change(Request $request){
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Application Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $current_status = Status::where('id',$application->status)->first();
        $update_status = Status::where('id',$request->status)->first();
        $application->status = $request->status;
        $application->update_by = Auth::user()->id;
        $application->save();
        //make notification to admin
        $notification = new Notification();
        $notification->title = 'Application Status Change';
        $notification->description = 'Application Status Change From <span style="color:red;">'.$current_status->title.'</span> to <span style="color:green;">'.$update_status->title.'</span> By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->application_id = $application->id;
        $notification->slug = 'application/'.$application->id.'/processing';
        $notification->save();
        //make instant notification for super admin
        event(new AdminMsgEvent($notification->description,url('application/'.$application->id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$notification->description,
        );
        return response()->json($data,200);
    }
    //meeting details 
    public function meeting_details($id=NULL){
        $data['page_title'] = 'Meeting | Details';
        $data['application'] = true;
        $data['application_all'] = true;
        $data['meeting_data'] = Meeting::where('id',$id)->first();
        return view('application/meeting_details',$data);
    }

}
