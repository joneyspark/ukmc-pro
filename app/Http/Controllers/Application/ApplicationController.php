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
use App\Mail\Application\applicationStatusUpdateMail;
use App\Mail\Application\englishAssesmentMail;
use App\Mail\Application\meetingNoteConfirm;
use App\Mail\Interview\interviewResitMail;
use App\Mail\Interview\interviewStatusMail;
use App\Mail\Interview\interviewSuccessMail;
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
use App\Models\Application\ApplicationSop;
use App\Models\Application\ApplicationStatus;
use App\Models\Application\Experience;
use App\Models\Application\Followup;
use App\Models\Application\InterviewStatus;
use App\Models\Application\Meeting;
use App\Models\Application\MeetingDocument;
use App\Models\Application\Note;
use App\Models\Application\Qualification;
use App\Models\Application\Status;
use App\Models\Setting\CompanySetting;
use App\Models\University\University;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicationController extends Controller{
    use Service;
    public function application_step1_new($id=NULL){
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
        $data['nationalities'] = Service::nationalities();
        $data['ethnic_origins'] = Service::ethnic_origin();
        $data['country_of_birth'] = Service::countries();
        $data['visa_category'] = Service::visa_category();
        $data['a_list_university'] = University::where('status',0)->get();
        $data['app_data'] = Application::where('id',$id)->first();
        if($data['app_data']){
            $data['course_list_data'] = Course::where('campus_id',$data['app_data']->campus_id)->get();
        }
        //AddNewLead::dispatch('Hello this is test');
        return view('application/new/create_step_1',$data);
    }
    //application step1 post
    public function application_step1_post(Request $request){
        $request->validate([
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required_if:auth,false|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required_if:auth,false|min:6',
            'ni_number' => 'required',
            //'emergency_contact_name' => 'required',
            //'emergency_contact_number' => 'required',
            'house_number' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'address_country' => 'required',
            'same_as' => 'required',
            'current_house_number' => 'required',
            'current_address_line_2' => 'required',
            'current_city' => 'required',
            'current_state' => 'required',
            'current_postal_code' => 'required',
            'current_country' => 'required',
            'nationality' => 'required',
            'other_nationality' => 'required_if:nationality,Other',
            'visa_category' => 'required_if:nationality,Other',
            'date_entry_of_uk' => 'required_if:nationality,Other',
            'ethnic_origin' => 'required_if:nationality,Other',
            'university_id' => 'required',
            'campus_id' => 'required',
            'course_id' => 'required',
            'local_course_fee' => 'required',
            'intake' => 'required',
            'delivery_pattern' => 'required',

        ]);
        if($request->application_id){
            $application = Application::where('id',$request->application_id)->first();
            if(Auth::check()){
                $application->update_by = Auth::user()->id;
            }else{
                $application->update_by = 0;
            }
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
            $application->marketing_officer_id = 0;
            $application->application_status_id = 0;
            $application->is_final_interview = 0;
            $application->manager_id = 0;
            // 1 for agent, 2 for web
            if(Auth::check()){
                if(Auth::user()->role=='agent'){
                    $application->application_process_status = 1;
                    $application->application_type = 1;
                }
            }
            if(Auth::check()){
                if(Auth::user()->role=='student'){
                    $application->application_process_status = 2;
                    $application->application_type = 2;
                }
            }
            if(Auth::check()){
                if(Auth::user()->role=='admin' || Auth::user()->role=='manager'){
                    $application->application_process_status = 1;
                    $application->application_type = 3;
                }
            }
            //$application->application_process_status = 1;
            $application->status = 1;
            if(Auth::check()){
                $application->create_by = Auth::user()->id;
            }
            //craete new user
            if(!Auth::check()){
                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->name = $request->first_name.' '.$request->last_name;
                $user->email = $request->email;
                $user->role = 'student';
                $user->password = Hash::make($request->password);
                $user->save();
                $application->create_by = $user->id;
                $application->application_process_status = 2;
                $application->application_type = 2;
            }
        }
        $application->reference = $request->reference;
        $application->company_id = ($request->company_id > 0)?$request->company_id:0;
        $application->title = $request->title;
        $application->first_name = $request->first_name;
        $application->last_name = $request->last_name;
        $application->name = $request->title.' '.$request->first_name.' '.$request->last_name;
        $application->gender = $request->gender;
        $application->date_of_birth = $request->date_of_birth;
        $application->email = $request->email;
        $application->phone = $request->phone;
        $application->ni_number = $request->ni_number;
        $application->emergency_contact_name = $request->emergency_contact_name;
        $application->emergency_contact_number = $request->emergency_contact_number;
        //house info
        $application->house_number = $request->house_number;
        $application->address_line_2 = $request->address_line_2;
        $application->city = $request->city;
        $application->state = $request->state;
        $application->postal_code = $request->postal_code;
        $application->address_country = $request->address_country;
        $application->same_as = $request->same_as;
        if($request->same_as=='yes'){
            $application->current_house_number = $request->house_number;
            $application->current_address_line_2 = $request->address_line_2;
            $application->current_city = $request->city;
            $application->current_state = $request->state;
            $application->current_postal_code = $request->postal_code;
            $application->current_country = $request->address_country;
        }else{
            $application->current_house_number = $request->current_house_number;
            $application->current_address_line_2 = $request->current_address_line_2;
            $application->current_city = $request->current_city;
            $application->current_state = $request->current_state;
            $application->current_postal_code = $request->current_postal_code;
            $application->current_country = $request->current_country;
        }
        $application->nationality = $request->nationality;
        $application->other_nationality = $request->other_nationality;
        $application->visa_category = $request->visa_category;
        $application->date_entry_of_uk = $request->date_entry_of_uk;
        $application->ethnic_origin = $request->ethnic_origin;
        $application->university_id = $request->university_id;
        $application->campus_id = $request->campus_id;
        $application->course_id = $request->course_id;
        $application->local_course_fee = $request->local_course_fee;
        $application->international_course_fee = $request->international_course_fee;
        $application->intake = $request->intake;
        $application->delivery_pattern = $request->delivery_pattern;
        $application->save();
        Session::put('set_application_id',$application->id);
        Session::flash('success','Step 1 Complete. Now Complete Step 2!');
        return redirect('application-create/'.$application->id.'/step-2');

    }
    //get campus by university
    public function get_campus_by_university(Request $request){
        $university = University::where('id',$request->university_id)->first();
        if(!$university){
            $data['result'] = array(
                'key'=>101,
                'val'=>'University Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $campuses = Campus::where('university_id',$university->id)->orderBy('campus_name','asc')->get();
        if($campuses){
            $select = '';
            $select .= '<option selected>Choose...</option>';
            foreach($campuses as $row){
                $select .= '<option value="'.$row->id.'">'.$row->campus_name.'</option>';
            }
            $data['result'] = array(
                'key'=>200,
                'val'=>$select
            );
            return response()->json($data,200);
        }else{
            $data['result'] = array(
                'key'=>101,
                'val'=>'No Campuses Found! Select Another University!'
            );
            return response()->json($data,200);
        }
    }
    public function step2_new($id=NULL){
        $current_step = 1;
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
        if($document > 1){
            $up_step = 2;
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
        $data['qualification_list'] = Qualification::where('application_id',$application->id)->get();
        $data['page_title'] = 'Application | Create | Step 4';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/new/step2',$data);
    }
    //name of qualifications post
    public function qualification_post(Request $request){
        $request->validate([
            'name_of_qualification' => 'required',
            'name_of_institute' => 'required',
            'awarding_organization' => 'required',
            'grade' => 'required',
            'year_of_completion' => 'required',
        ]);
        $qualification = new Qualification();
        $qualification->application_id = $request->get_application_id;
        $qualification->name_of_qualification = $request->name_of_qualification;
        $qualification->name_of_institute = $request->name_of_institute;
        $qualification->awarding_organization = $request->awarding_organization;
        $qualification->grade = $request->grade;
        $qualification->year_of_completion = $request->year_of_completion;
        $qualification->save();
        Session::flash('success','Qualification Data Saved Successfully!');
        return redirect('application-create/'.$qualification->application_id.'/step-2');
    }
    //experience post
    public function experience_post(Request $request){
        $request->validate([
            'job_title' => 'required',
            'employer_name' => 'required',
            'start_date' => 'required',
        ]);
        $job = new Experience();
        $job->application_id = $request->get_application_id;
        $job->job_title = $request->job_title;
        $job->employer_name = $request->employer_name;
        $job->start_date = $request->start_date;
        $job->end_date = $request->end_date;
        $job->continue = $request->continue;
        $job->save();
        Session::flash('success','Experience Data Saved Successfully!');
        return redirect('application-create/'.$job->application_id.'/step-2');
    }
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
        $data['nationalities'] = Service::nationalities();
        $data['ethnic_origins'] = Service::ethnic_origin();
        $data['country_of_birth'] = Service::countries();
        $data['visa_category'] = Service::visa_category();
        $data['a_list_university'] = University::where('status',0)->get();
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
            if(Auth::check()){
                $application->update_by = Auth::user()->id;
            }else{
                $application->update_by = 0;
            }
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
            if(Auth::check()){
                $application->create_by = Auth::user()->id;
            }else{
                $application->create_by = 0;
            }
        }
        $application->reference = $request->reference;
        $application->company_id = ($request->company_id > 0)?$request->company_id:0;
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
        // if($id != Session::get('set_application_id')){
        //     Session::flash('error','Internal Server Error! Follow Step Carefully! Press Button Next');
        //     return redirect('application-create/'.Session::get('set_application_id'));
        // }
        $current_step = 1;
        $application = Application::where('id',$id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('application-create');
        }
        $step_arr = explode(",",$application->steps);
        if(!in_array($current_step,$step_arr)){
            Session::flash('error','Complete Step 1 Then Proced!');
            return redirect('application-create/'.$application->id.'/step-3');
        }
        //update step
        $document = ApplicationDocument::where('application_id',$application->id)->count();

        $data['document_count'] = $document;
        $data['application_documents'] = ApplicationDocument::where('application_id',$application->id)->get();
        $data['application_id'] = $application->id;
        $data['application_data'] = $application;
        $data['application_step2_data'] = Application_Step_2::where('application_id',$application->id)->first();
        $data['requested_documents'] = RequestDocument::where('application_id',$application->id)->get();
        $data['qualification_list'] = Qualification::where('application_id',$application->id)->get();
        $data['job_list'] = Experience::where('application_id',$application->id)->get();
        $data['page_title'] = 'Application | Create | Step 2';
        $data['application'] = true;
        $data['application_add'] = true;
        return view('application/create_step_2',$data);
    }
    public function step_2_post(Request $request){
        if($request->get_application_id != Session::get('set_application_id')){
            Session::flash('error','Internal Server Error! Follow Step Carefully! Press Button Next');
            return redirect('application-create/'.Session::get('set_application_id'));
        }
        $application = Application::where('id',$request->get_application_id)->first();
        if(!$application){
            Session::flash('error','Internal Server Error!');
            return redirect('application-create');
        }
        if($request->application_step2_id){
            $application_step2 = Application_Step_2::where('id',$request->application_step2_id)->first();
        }else{
            //update step
            $application->steps = $application->steps.','.'2';
            $application->save();
            $application_step2 = new Application_Step_2();
        }
        $application_step2->application_id = $application->id;
        $application_step2->disabilities = $request->disabilities;
        $application_step2->criminal_convictions = $request->criminal_convictions;
        $application_step2->save();
        Session::flash('success','Step 2 Complete. Goto Step 3');
        return redirect('application-create/'.$application->id.'/step-3');

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
        $is_view = $request->is_view;
        if($is_view){
            $document->is_view = $is_view;
        }else{
            $document->is_view = 1;
        }
        $doc = $request->doc;
        if ($request->hasFile('doc')) {
            $ext = $doc->getClientOriginalExtension();
            if(!$ext){
                Session::flash('error','Invalid Document! Please Upload PDF, JPG, Docs etc!');
                return redirect('application-create/'.$application->id.'/step-2');
            }
            $doc_file_name = $doc->getClientOriginalName();
            $doc_file_name = 'UKMC-'.Service::get_random_str_number().'-'.Service::slug_create($doc_file_name).'.'.$ext;
            $upload_path1 = 'backend/images/application/doc/'.$application->id.'/';
            Service::createDirectory($upload_path1);
            $request->file('doc')->move(public_path('backend/images/application/doc/'.$application->id.'/'), $doc_file_name);
            $document->doc = $upload_path1.$doc_file_name;
        }
        $document->save();
        Session::flash('success','Document Saved Successfully!');
        return redirect('application-create/'.$application->id.'/step-2');
    }
    public function create_step_3($id=NULL){
        // if($id != Session::get('set_application_id')){
        //     Session::flash('error','Internal Server Error! Follow Step Carefully! Press Button Next');
        //     return redirect('application-create/'.Session::get('set_application_id'));
        // }
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
        $data['page_title'] = 'Application | Create | Step 3';
        $data['application'] = true;
        $data['application_add'] = true;
        $data['app_step_3'] = Application_Step_3::where('application_id',$application->id)->first();
        $data['app_data'] = $application;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_3',$data);
    }
    public function step_3_post(Request $request){
        if($request->application_id != Session::get('set_application_id')){
            Session::flash('error','Internal Server Error! Follow Step Carefully! Press Button Next');
            return redirect('application-create/'.Session::get('set_application_id'));
        }
        $role = '';
        if(Auth::check()){
            $role = Auth::user()->role;
        }

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
            $application->application_status_id = 1;
            $application->save();
            //make notification
            if(Auth::check()){
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
                    $notification->manager_id = 1;
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
                    $notification->manager_id = 1;
                    $notification->application_id = $application->id;
                    $notification->slug = 'application/'.$application->id.'/details';
                    $notification->save();
                    $message = 'New Application Create By '.Auth::user()->name;
                    $url = url('application/'.$application->id.'/details');
                    event(new AddNewLead($message,$url));
                }
                if(Auth::user()->role=='student'){
                    $notification = new Notification();
                    $notification->title = 'New Application From Web Portal';
                    $notification->description = 'New Application Create By '.Auth::user()->name;
                    $notification->create_date = time();
                    $notification->create_by = Auth::user()->id;
                    $notification->creator_name = Auth::user()->name;
                    $notification->creator_image = Auth::user()->photo;
                    $notification->user_id = 1;
                    $notification->is_admin = 1;
                    $notification->manager_id = 1;
                    $notification->application_id = $application->id;
                    $notification->slug = 'application/'.$application->id.'/details';
                    $notification->save();
                    //make instant messaging
                    $message = 'New Application Create By '.Auth::user()->name;
                    $url = url('application/'.$application->id.'/details');
                    event(new AddNewLead($message,$url));
                }
            }else{
                $notification = new Notification();
                    $notification->title = 'New Application From Web Portal';
                    $notification->description = 'New Application Create By '.$application->name;
                    $notification->create_date = time();
                    $notification->create_by = $application->id;
                    $notification->creator_name = $application->name;
                    $notification->creator_image = url('web/avatar/user.png');
                    $notification->user_id = 1;
                    $notification->is_admin = 1;
                    $notification->manager_id = 1;
                    $notification->application_id = $application->id;
                    $notification->slug = 'application/'.$application->id.'/details';
                    $notification->save();
                    //make instant messaging
                    $message = 'New Application Create By '.$application->name;
                    $url = url('application/'.$application->id.'/details');
                    event(new AddNewLead($message,$url));
            }

            $application_step3 = new Application_Step_3();
        }
        $application_step3->application_id = $application->id;
        $application_step3->save();
        Session::forget('set_application_id');
        Session::flash('success','Application Successfully Submitted!');
        if($role=='agent'){
            return redirect('agent-applications');
        }
        if($role=='student'){
            return redirect('student-portal');
        }
        if($role=='admin' || $role=='manager'){
            return redirect('all-application');
        }
        if($role=='adminManager'){
            return redirect('my-applications');
        }
        return view('application/thankyou');
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
        $get_application = Application::where('id',$check->application_id)->first();
        $update = RequestDocument::where('id',$check->id)->update(['status'=>1]);
        $notification = new Notification();
        $notification->title = 'Document Confirmation';
        $notification->description = 'Requested Document Upload By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = $check->request_by;
        $notification->manager_id = ($get_application->manager_id > 0)?$get_application->manager_id:0;
        $notification->is_admin = 0;
        $notification->application_id = $check->application_id;
        $notification->slug = 'application-create/'.$check->application_id.'/step-2';
        $notification->save();
        event(new AddNewLead($notification->description,url($notification->slug)));
        return redirect('application-create/'.$check->application_id.'/step-2');
    }
    public function interview_list(){
        $data['page_title'] = 'Application | Details';
        $data['application'] = true;
        $data['interview_list'] = true;
        $data['meetings'] = Meeting::where('user_id',Auth::user()->id)->where('is_meeting_done',0)->take(20)->get();
        $data['followups'] = Followup::where('user_id',Auth::user()->id)->where('is_follow_up_done',0)->take(20)->get();
        return view('application.interview_list',$data);
    }

    public function agent_applications(Request $request){
        $data['page_title'] = 'Agent | Applications';
        $data['application'] = true;
        $data['application_all'] = true;
        $get_campus = $request->campus;
        $get_agent = $request->agent;
        $get_officer = $request->officer;
        $get_status = $request->status;
        $get_intake = $request->intake;
        $search = $request->q;
        $get_interview_status = $request->interview_status;
        $get_from_date = $request->from_date;
        $get_to_date = $request->to_date;
        //Session set data
        Session::put('get_campus',$get_campus);
        Session::put('get_agent',$get_agent);
        Session::put('get_officer',$get_officer);
        Session::put('get_status',$get_status);
        Session::put('get_intake',$get_intake);
        Session::put('search',$search);
        Session::put('get_interview_status',$get_interview_status);
        Session::put('get_from_date',$get_from_date);
        Session::put('get_to_date',$get_to_date);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['interviewer_list'] = User::where('role','interviewer')->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
        $data['interview_statuses'] = InterviewStatus::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();
        $data['agent_applications'] = Application::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })

        ->when($request->get('from_date') && $request->get('to_date'), function ($query) use ($request) {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        })
        ->when($get_campus, function ($query, $get_campus) {
            return $query->where('campus_id',$get_campus);
        })
        ->when($get_interview_status, function ($query, $get_interview_status) {
            return $query->where('interview_status',$get_interview_status);
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
        ->where('company_id',Auth::user()->company_id)
        ->where('application_status_id',1)
        ->orderBy('created_at','desc')
        ->paginate(15)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_agent,
            'officer' => $get_officer,
            'status' => $get_status,
            'intake' => $get_intake,
            'interview_status' => $get_interview_status,
            'from_date' => $get_from_date,
            'to_date' => $get_to_date,
        ]);
        $data['my_teams'] = User::where('role','adminManager')->where('active',1)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();

        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');
        $data['get_interview_status'] = Session::get('get_interview_status');
        $data['get_from_date'] = Session::get('get_from_date');
        $data['get_to_date'] = Session::get('get_to_date');
        $data['get_application_id'] = Session::get('get_application_id');
        //$data['agent_applications'] = Application::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('application.agent.all',$data);
    }
    public function agent_application_details($id=NULL){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['application_all'] = true;
        $data['my_application_list'] = true;
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
        $data['application_status_list'] = ApplicationStatus::where('status',0)->get();
        $data['interview_status_list'] = InterviewStatus::where('status',0)->get();
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
        $get_interviewer = $request->interviewer;
        $get_intake = $request->intake;
        $search = $request->q;
        $get_interview_status = $request->interview_status;
        $get_from_date = $request->from_date;
        $get_to_date = $request->to_date;
        //Session set data
        Session::put('get_campus',$get_campus);
        Session::put('get_agent',$get_agent);
        Session::put('get_officer',$get_officer);
        Session::put('get_status',$get_status);
        Session::put('get_interviewer',$get_interviewer);
        Session::put('get_intake',$get_intake);
        Session::put('search',$search);
        Session::put('get_interview_status',$get_interview_status);
        Session::put('get_from_date',$get_from_date);
        Session::put('get_to_date',$get_to_date);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['interviewer_list'] = User::where('role','interviewer')->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
        $data['interview_statuses'] = InterviewStatus::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();

        $data['application_list'] = Application::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->when($request->get('from_date') && $request->get('to_date'), function ($query) use ($request) {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        })
        ->when($get_campus, function ($query, $get_campus) {
            return $query->where('campus_id',$get_campus);
        })
        ->when($get_interview_status, function ($query, $get_interview_status) {
            return $query->where('interview_status',$get_interview_status);
        })
        ->when($get_agent, function ($query, $get_agent) {
            return $query->where('company_id',$get_agent);
        })
        ->when($get_officer, function ($query, $get_officer) {
            return $query->where('admission_officer_id',$get_officer);
        })
        ->when($get_interviewer, function ($query, $get_interviewer) {
            return $query->where('interviewer_id',$get_interviewer);
        })
        ->when($get_status, function ($query, $get_status) {
            return $query->where('status',$get_status);
        })
        ->when($get_intake, function ($query, $get_intake) {
            return $query->where('intake',$get_intake);
        })
        ->where('application_status_id','!=',3)
        ->orderBy('created_at','desc')
        ->paginate(50)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_agent,
            'officer' => $get_officer,
            'interviewer' => $get_interviewer,
            'status' => $get_status,
            'intake' => $get_intake,
            'interview_status' => $get_interview_status,
            'from_date' => $get_from_date,
            'to_date' => $get_to_date,
        ]);

        $data['my_teams'] = User::where('role','adminManager')->where('active',1)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();

        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_interviewer'] = Session::get('get_interviewer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');
        $data['get_interview_status'] = Session::get('get_interview_status');
        $data['get_from_date'] = Session::get('get_from_date');
        $data['get_to_date'] = Session::get('get_to_date');
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
        Session::put('get_interview_status','');
        Session::put('get_from_date','');
        Session::put('get_to_date','');
        return redirect('all-application');
    }
    public function reset_my_assigned_application_search(){
        Session::put('get_campus','');
        Session::put('get_agent','');
        Session::put('get_officer','');
        Session::put('get_status','');
        Session::put('get_intake','');
        Session::put('search','');
        return redirect('my-assigned-applications');
    }
    public function reset_my_application_search(){
        Session::put('get_campus','');
        Session::put('get_agent','');
        Session::put('get_officer','');
        Session::put('get_status','');
        Session::put('get_intake','');
        Session::put('search','');
        Session::put('get_interview_status','');
        Session::put('get_from_date','');
        Session::put('get_to_date','');
        return redirect('my-applications');
    }
    public function reset_agent_application_search(){
        Session::put('get_campus','');
        Session::put('get_status','');
        Session::put('get_intake','');
        Session::put('search','');
        Session::put('get_interview_status','');
        Session::put('get_from_date','');
        Session::put('get_to_date','');
        return redirect('agent-applications');
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
    public function enrolled(Request $request){
        $data['page_title'] = 'Application | Enrolled';
        $data['application'] = true;
        $data['application_enrolled'] = true;
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
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
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
        ->where('status',5)
        ->orderBy('id','desc')
        ->paginate(50)
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
        return view('application/enrolled',$data);
    }
    public function archive_students(Request $request){
        $data['page_title'] = 'Archived / Students';
        $data['application'] = true;
        $data['application_archived'] = true;
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
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
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
        ->where('status',8)
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
            'subject' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $application = Application::where('id',$request->set_application_id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found! Server Error!');
            if(Auth::user()->role=='admin' || Auth::user()->role=='manager'){
                return redirect('all-application');
            }
            if(Auth::user()->role=='adminManager'){
                return redirect('my-applications');
            }
        }
        $doc = new RequestDocument();
        $doc->application_id = $application->id;
        $doc->subject = $request->subject;
        $doc->message = $request->message;
        $doc->request_by = Auth::user()->id;
        $doc->request_to = ($application->create_by > 0)?$application->create_by:0;
        $doc->save();
        $agentData = User::where('company_id',$application->company_id)->where('is_admin',1)->first();
        if($application->create_by > 0){
            $notification = new Notification();
            $notification->title = 'Document Request';
            $notification->description = 'New Document Requested By '.Auth::user()->name;
            $notification->create_date = time();
            $notification->create_by = Auth::user()->id;
            $notification->creator_name = Auth::user()->name;
            $notification->creator_image = Auth::user()->photo;
            $notification->user_id = $agentData->id;
            $notification->is_admin = 1;
            $notification->application_id = $application->id;
            $notification->slug = 'application-create/'.$application->id.'/step-2';
            $notification->save();
        }
        //make mail to student and agent

        $studentEmail = $application->email;

        $details = [
            'create_by'=>Auth::user(),
            'subject'=>$request->subject,
            'message'=>$request->message,
            'application_info'=>$application,
            'company'=>CompanySetting::where('id',1)->first(),
        ];
        if($agentData){
            $agentEmail = $agentData->email;
            Mail::to($agentEmail)->send(new requestDocumentMail($details));
        }
        //return $studentEmail.' '.$agentEmail;
        if($studentEmail){
            Mail::to($studentEmail)->send(new requestDocumentMail($details));
        }
        //event(new AgentEvent($agentData->id,$notification->description,url('application-create/'.$application->id.'/step-2')));

        Session::flash('success','Document Request Sent Successfully');
        return redirect('application-create/'.$application->id.'/step-2');
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
        $current_status = ApplicationStatus::where('id',$application->status)->first();
        $update_status = ApplicationStatus::where('id',$request->status)->first();
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
        //make mail
        if($update_status->id==14){
            $note = Meeting::where('application_id',$application->id)->orderBy('created_at','desc')->first();
            $details = [
                'application_info'=>$application,
                'company'=>CompanySetting::where('id',1)->first(),
                'meeting_date'=>$note->meeting_date_time,
                'meeting_time'=>$note->meeting_date_time,
                'create_user'=>User::where('id',$note->user_id)->first(),
            ];
            Mail::to($application->email)->send(new meetingNoteConfirm($details));
        }elseif($update_status->id==7){
            $follow = Followup::where('application_id',$application->id)->orderBy('created_at','desc')->first();
            $details = [
                'application_data'=>$application,
                'company'=>CompanySetting::where('id',1)->first(),
                'meeting_date'=>(!empty($follow->follow_up_date_time))?$follow->follow_up_date_time:'',
                'meeting_time'=>(!empty($follow->follow_up_date_time))?$follow->follow_up_date_time:'',
                'create_user'=>User::where('id',$follow->user_id)->first(),
            ];
            Mail::to($application->email)->send(new englishAssesmentMail($details));
        }else{
            $details = [
                'application_data'=>$application,
                'current_status'=>$current_status,
                'update_status'=>$update_status,
                'company'=>CompanySetting::where('id',1)->first(),
            ];
            Mail::to($application->email)->send(new applicationStatusUpdateMail($details));
        }

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
        $data['documents'] = MeetingDocument::where('meeting_id',$data['meeting_data']->id)->get();
        return view('application/meeting_details',$data);
    }
    //meeting video post
    public function meeting_video_post(Request $request){
        $meeting = Meeting::where('id',$request->meeting_id)->where('user_id',Auth::user()->id)->first();
        if(!$meeting){
            Session::flash('error','Meeting Data Not Found! Server Error!');
            return redirect()->back();
        }
        //upload video file upload
        $video = $request->video;
        if ($request->hasFile('video')) {
            if (File::exists(public_path($meeting->video))) {
                File::delete(public_path($meeting->video));
            }
            $ext = $video->getClientOriginalExtension();
            $doc_file_name = $video->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(111, 9999).'.'.$ext;
            $upload_path1 = 'backend/images/meeting/video_file/';
            Service::createDirectory($upload_path1);
            $request->file('video')->move(public_path('backend/images/meeting/video_file/'), $doc_file_name);
            $meeting->video = $upload_path1.$doc_file_name;
        }
        //meeting doc file upload
        $meeting_doc = $request->meeting_doc;
        if ($request->hasFile('meeting_doc')) {
            if (File::exists(public_path($meeting->meeting_doc))) {
                File::delete(public_path($meeting->meeting_doc));
            }
            $ext = $meeting_doc->getClientOriginalExtension();
            $doc_file_name = $meeting_doc->getClientOriginalName();
            $doc_file_name = 'UKMC-'.Service::get_random_str_number().'-'.Service::slug_create($doc_file_name).'.'.$ext;
            $upload_path1 = 'backend/images/meeting/meeting_doc/';
            Service::createDirectory($upload_path1);
            $request->file('meeting_doc')->move(public_path('backend/images/meeting/meeting_doc/'), $doc_file_name);
            $meeting->meeting_doc = $upload_path1.$doc_file_name;
        }
        if($request->video_link){
            $meeting->video_url = $request->video_link;
        }
        $meeting->save();
        Session::flash('success','Meeting Data Updated Successfully!');
        return redirect('meeting/'.$meeting->id.'/details');
    }
    //student portal
    public function student_portal(){
        $data['page_title'] = 'My Application';
        $data['application'] = true;
        $data['student_portal'] = true;
        $data['student_application'] = Application::where('create_by',Auth::user()->id)->orderBy('id','desc')->get();
        //AddNewLead::dispatch('Hello this is test');
        return view('application/student_portal',$data);
    }
    public function get_academic_data(Request $request){
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Application Data Not Found!'
            );
            return response()->json($data,200);
        }
        $application->is_academic = $request->level_of_education;
        $application->save();
        //save activity
        $description = '';
        if($application->is_academic==1){
            $description = 'Applicaton Status Change From <span class="badge-success">Non Academic</span> To <span class="badge-warning">Academic</span> By '.Auth::user()->name;
        }else{
            $description = 'Applicaton Status Change From <span class="badge-success">Academic</span> To <span class="badge-warning">Non Academic</span> By '.Auth::user()->name;
        }
        $notification = new Notification();
        $notification->title = 'Application Status Change';
        $notification->description = $description;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = url(Auth::user()->photo);
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->manager_id = 1;
        $notification->application_id = $application->id;
        $notification->slug = 'application/'.$application->id.'/processing';
        $notification->save();
        //make instant notification for super admin
        event(new AdminMsgEvent($notification->description,url('application/'.$application->id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$notification->description,
            'url'=>$notification->slug
        );
        return response()->json($data,200);
    }
    //application assign to user
    public function application_assign_to(Request $request){
        $request->validate([
            'assign_to_user_id'=>'required',
        ]);
        $getIds = $request->assign_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect('all-application');
        }
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->where('admission_officer_id',0)->first();
            if($getApp){
                $getApp->admission_officer_id = $request->assign_to_user_id;
                $getApp->manager_id = Auth::user()->id;
                $getApp->status = 2;
                $getApp->save();
            }
        }
        $count = count($array);
        //create notification
        $notification = new Notification();
        $notification->title = 'Assign Lead';
        $notification->description = $count.' New Application Assigned By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = url(Auth::user()->photo);
        $notification->user_id = $request->assign_to_user_id;
        $notification->is_admin = 1;
        $notification->manager_id = 0;
        $notification->application_id = 0;
        $notification->slug = 'my-application';
        $notification->save();
        //make instant messaging
        $url = url('my-application');
        event(new AddNewLead($notification->description,$url));
        Session::flash('success',$count.' Application Assigned Successfully!');
        return redirect('all-application');
    }
    //application assign to Manager
    public function application_assign_to_manager(Request $request){
        $request->validate([
            'assign_to_admission_manager_id'=>'required',
            'assign_to_manager_id'=>'required',
        ]);
        $getIds = $request->assign_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect('all-application');
        }
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->where('admission_officer_id',0)->first();
            if($getApp){
                $getApp->admission_officer_id = $request->assign_to_admission_manager_id;
                $getApp->manager_id = $request->assign_to_manager_id;
                $getApp->status = 2;
                $getApp->save();
            }
        }
        $count = count($array);
        //create notification
        $notification = new Notification();
        $notification->title = 'Assign Lead';
        $notification->description = $count.' New Application Assigned By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = url(Auth::user()->photo);
        $notification->user_id = $request->assign_to_admission_manager_id;
        $notification->is_admin = 1;
        $notification->manager_id = 1;
        $notification->application_id = 0;
        $notification->slug = 'my-application';
        $notification->save();
        //make instant messaging
        $url = url('my-application');
        event(new AddNewLead($notification->description,$url));
        Session::flash('success',$count.' Application Assigned Successfully!');
        return redirect('all-application');
    }
    //get admission officer by manager id
    public function get_admission_officer_by_manager($id=NULL){
        $officers = User::where('create_by',$id)->where('role','adminManager')->where('active',1)->get();
        $select = '';
        $select .= '<option value="" selected>Choose...</option>';
        foreach($officers as $officer){
            $select .= '<option value="'.$officer->id.'">'.$officer->name.'</option>';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
        );
        return response()->json($data,200);
    }
    //get my application
    public function my_applications(Request $request){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['my_application_list'] = true;
        $get_campus = $request->campus;
        $get_agent = $request->agent;
        $get_officer = $request->officer;
        $get_status = $request->status;
        $get_intake = $request->intake;
        $search = $request->q;
        $get_interview_status = $request->interview_status;
        $get_from_date = $request->from_date;
        $get_to_date = $request->to_date;
        //Session set data
        Session::put('get_campus',$get_campus);
        Session::put('get_agent',$get_agent);
        Session::put('get_officer',$get_officer);
        Session::put('get_status',$get_status);
        Session::put('get_intake',$get_intake);
        Session::put('search',$search);
        Session::put('get_interview_status',$get_interview_status);
        Session::put('get_from_date',$get_from_date);
        Session::put('get_to_date',$get_to_date);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['interviewer_list'] = User::where('role','interviewer')->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
        $data['interview_statuses'] = InterviewStatus::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();


        $data['application_list'] = Application::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->when($request->get('from_date') && $request->get('to_date'), function ($query) use ($request) {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        })
        ->when($get_campus, function ($query, $get_campus) {
            return $query->where('campus_id',$get_campus);
        })
        ->when($get_interview_status, function ($query, $get_interview_status) {
            return $query->where('interview_status',$get_interview_status);
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
        ->where('application_status_id',1)
        ->where('admission_officer_id',Auth::user()->id)
        ->orderBy('created_at','desc')
        ->paginate(50)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_agent,
            'officer' => $get_officer,
            'status' => $get_status,
            'intake' => $get_intake,
            'interview_status' => $get_interview_status,
            'from_date' => $get_from_date,
            'to_date' => $get_to_date,
        ]);
        $data['my_teams1'] = User::where('role','adminManager')->where('active',1)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();

        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');
        $data['get_interview_status'] = Session::get('get_interview_status');
        $data['get_from_date'] = Session::get('get_from_date');
        $data['get_to_date'] = Session::get('get_to_date');
        //$data['application_list'] = Application::where('application_status_id','!=',0)->orderBy('id','desc')->paginate(15);
        return view('application/my_application',$data);
    }
    public function my_assigned_applications(Request $request){
        $data['page_title'] = 'Application | All';
        $data['application'] = true;
        $data['my_assigned_application_list'] = true;
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
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('create_by',Auth::user()->id)->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
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
        ->where('application_status_id',1)
        ->where('manager_id',Auth::user()->id)
        ->orderBy('created_at','desc')
        ->paginate(50)
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

        //dd($data['application_list']);
        //$data['application_list'] = Application::where('application_status_id','!=',0)->orderBy('id','desc')->paginate(15);
        return view('application/my_assigned_application',$data);
    }
    //get my application
    public function interviewer_applications(Request $request){
        $data['page_title'] = 'Interviewer | Application';
        $data['application'] = true;
        $data['interviewer_application_list'] = true;
        $get_campus = $request->campus;
        $get_agent = $request->agent;
        $get_officer = $request->officer;
        $get_status = $request->status;
        $get_intake = $request->intake;
        $search = $request->q;
        $get_interview_status = $request->interview_status;
        $get_from_date = $request->from_date;
        $get_to_date = $request->to_date;
        //Session set data
        Session::put('get_campus',$get_campus);
        Session::put('get_agent',$get_agent);
        Session::put('get_officer',$get_officer);
        Session::put('get_status',$get_status);
        Session::put('get_intake',$get_intake);
        Session::put('search',$search);
        Session::put('get_interview_status',$get_interview_status);
        Session::put('get_from_date',$get_from_date);
        Session::put('get_to_date',$get_to_date);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['interviewer_list'] = User::where('role','interviewer')->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
        $data['interview_statuses'] = InterviewStatus::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();

        $data['application_list'] = Application::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->when($request->get('from_date') && $request->get('to_date'), function ($query) use ($request) {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        })
        ->when($get_campus, function ($query, $get_campus) {
            return $query->where('campus_id',$get_campus);
        })
        ->when($get_interview_status, function ($query, $get_interview_status) {
            return $query->where('interview_status',$get_interview_status);
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
        ->where('application_status_id',1)
        ->where('interviewer_id',Auth::user()->id)
        ->orderBy('created_at','desc')
        ->paginate(50)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_agent,
            'officer' => $get_officer,
            'status' => $get_status,
            'intake' => $get_intake,
            'interview_status' => $get_interview_status,
            'from_date' => $get_from_date,
            'to_date' => $get_to_date,
        ]);
        $data['my_teams'] = User::where('role','adminManager')->where('active',1)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');
        $data['get_interview_status'] = Session::get('get_interview_status');
        $data['get_from_date'] = Session::get('get_from_date');
        $data['get_to_date'] = Session::get('get_to_date');
        //$data['application_list'] = Application::where('application_status_id','!=',0)->orderBy('id','desc')->paginate(15);
        return view('application/interviewer/interviewer_application',$data);
    }
    public function reset_interviewer_application_search(){
        Session::put('get_campus','');
        Session::put('get_agent','');
        Session::put('get_officer','');
        Session::put('get_status','');
        Session::put('get_intake','');
        Session::put('search','');
        Session::put('get_interview_status','');
        Session::put('get_from_date','');
        Session::put('get_to_date','');
        return redirect('interviewer-applications');
    }
    //application assign to Interviewer
    public function application_assign_to_interviewer(Request $request){
        $request->validate([
            'assign_to_interviewer_id'=>'required',
        ]);
        $getIds = $request->assign_interviewer_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect('all-application');
        }
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->where('interviewer_id',0)->first();
            if($getApp){
                $getApp->interviewer_id = $request->assign_to_interviewer_id;
                $getApp->interview_status = 1;
                $getApp->save();
            }
        }
        $count = count($array);
        //create notification
        $notification = new Notification();
        $notification->title = 'Assign Interviewer Application';
        $notification->description = $count.' New Application Assigned By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = url(Auth::user()->photo);
        $notification->user_id = $request->assign_to_interviewer_id;
        $notification->is_admin = 1;
        $notification->manager_id = 0;
        $notification->application_id = 0;
        $notification->slug = 'interviewer-applications';
        $notification->save();
        //make instant messaging
        $url = url('interviewer-applications');
        event(new AddNewLead($notification->description,$url));
        Session::flash('success',$count.' Application Assigned Successfully!');
        return redirect('all-application');
    }
    //application status change
    public function interview_status_change(Request $request){
        $application = Application::where('id',$request->application_id)->first();
        if(!$application){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Application Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        if(!$request->status){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Application Status Not Found! Please Select!'
            );
            return response()->json($data,200);
        }
        $current_status = InterviewStatus::where('id',$application->interview_status)->first();
        $update_status = InterviewStatus::where('id',$request->status)->first();
        $application->interview_status = $request->status;
        $application->update_by = Auth::user()->id;
        $application->save();
        //make notification to admin
        $notification = new Notification();
        $notification->title = 'Interview Status Change';
        $notification->description = 'Interview Status Change From <span style="color:red;">'.$current_status->title.'</span> to <span style="color:green;">'.$update_status->title.'</span> By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->manager_id = 1;
        $notification->application_id = $application->id;
        $notification->slug = 'application/'.$application->id.'/processing';
        $notification->save();
        //make mail system
        $companyInfo = CompanySetting::where('id',1)->first();
        if($update_status->id==12){
            $details = [
                'application_data'=>$application,
                'current_status'=>$update_status->title,
                'company'=>$companyInfo,
            ];
            Mail::to($application->email)->send(new interviewResitMail($details));
        }
        elseif($update_status->id==14){
            $details = [
                'application_data'=>$application,
                'current_status'=>$update_status->title,
                'company'=>$companyInfo,
            ];
            Mail::to($application->email)->send(new interviewSuccessMail($details));
        }else{
            $details = [
                'application_data'=>$application,
                'current_status'=>$current_status,
                'update_status'=>$update_status,
                'company'=>$companyInfo,
            ];
            Mail::to($application->email)->send(new interviewStatusMail($details));
        }
        //make instant notification for super admin
        event(new AdminMsgEvent($notification->description,url('application/'.$application->id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$notification->description,
        );
        return response()->json($data,200);
    }
    public function make_application_note_by_agent(Request $request){
        $request->validate([
            'application_note'=>'required',
        ]);
        $application = Application::where('id',$request->note_application_id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found! Server Error!');
            return redirect('agent-applications');
        }
        $note = new Note();
        $note->application_id = $request->note_application_id;
        $note->note = $request->application_note;
        $note->user_id = Auth::user()->id;
        $note->save();
        //create notification
        $notification = new Notification();
        $notification->title = 'Create New Note By Agent';
        $notification->description = 'Create A New Note Of Application Assigned By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = url(Auth::user()->photo);
        $notification->user_id = 0;
        $notification->is_admin = 1;
        $notification->manager_id = 1;
        $notification->application_id = $request->note_application_id;
        $notification->slug = 'application/'.$request->note_application_id.'/processing';
        $notification->save();
        //make instant messaging
        $url = url('application/'.$request->note_application_id.'/processing');
        event(new AddNewLead($notification->description,$url));
        Session::put('get_application_id',$request->note_application_id);
        Session::flash('success','Application Note Created Successfully');
        return redirect('agent-applications');
    }
    //incomplete applications
    public function incomplete_applications(Request $request){
        $data['page_title'] = 'Agent | Incomplete Applications';
        $data['application'] = true;
        $data['incomplete_application_all'] = true;
        $get_campus = $request->campus;
        $get_agent = $request->agent;
        $get_officer = $request->officer;
        $get_status = $request->status;
        $get_intake = $request->intake;
        $search = $request->q;
        $get_interview_status = $request->interview_status;
        $get_from_date = $request->from_date;
        $get_to_date = $request->to_date;
        //Session set data
        Session::put('get_campus',$get_campus);
        Session::put('get_agent',$get_agent);
        Session::put('get_officer',$get_officer);
        Session::put('get_status',$get_status);
        Session::put('get_intake',$get_intake);
        Session::put('search',$search);
        Session::put('get_interview_status',$get_interview_status);
        Session::put('get_from_date',$get_from_date);
        Session::put('get_to_date',$get_to_date);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['interviewer_list'] = User::where('role','interviewer')->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
        $data['interview_statuses'] = InterviewStatus::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();
        $data['agent_applications'] = Application::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })

        ->when($request->get('from_date') && $request->get('to_date'), function ($query) use ($request) {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        })
        ->when($get_campus, function ($query, $get_campus) {
            return $query->where('campus_id',$get_campus);
        })
        ->when($get_interview_status, function ($query, $get_interview_status) {
            return $query->where('interview_status',$get_interview_status);
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
        ->where('company_id',Auth::user()->company_id)
        ->where('application_status_id',0)
        ->orderBy('created_at','desc')
        ->paginate(50)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_agent,
            'officer' => $get_officer,
            'status' => $get_status,
            'intake' => $get_intake,
            'interview_status' => $get_interview_status,
            'from_date' => $get_from_date,
            'to_date' => $get_to_date,
        ]);
        $data['my_teams'] = User::where('role','adminManager')->where('active',1)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();

        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');
        $data['get_interview_status'] = Session::get('get_interview_status');
        $data['get_from_date'] = Session::get('get_from_date');
        $data['get_to_date'] = Session::get('get_to_date');
        $data['get_application_id'] = Session::get('get_application_id');
        //$data['agent_applications'] = Application::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('application.agent.incomplete',$data);
    }
    public function reset_incomplete_applications(){
        Session::put('get_campus','');
        Session::put('get_status','');
        Session::put('get_intake','');
        Session::put('search','');
        Session::put('get_interview_status','');
        Session::put('get_from_date','');
        Session::put('get_to_date','');
        return redirect('incomplete-applications');
    }
    //meeting document upload
    public function meeting_document_upload(Request $request){
        $request->validate([
            'title'=>'required',
            'document'=>'required',
        ]);
        $meeting = new MeetingDocument();
        $meeting->meeting_id = $request->meeting_id;
        $meeting->title = $request->title;
        //meeting doc file upload
        $meeting_doc = $request->document;
        if ($request->hasFile('document')) {

            $ext = $meeting_doc->getClientOriginalExtension();
            $doc_file_name = $meeting_doc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/meeting/meeting_doc/';
            Service::createDirectory($upload_path1);
            $request->file('document')->move(public_path('backend/images/meeting/meeting_doc/'), $doc_file_name);
            $meeting->document = url($upload_path1.$doc_file_name);
        }
        $meeting->save();
        Session::flash('success','Meeting Note Saved Successfully!');
        return redirect('meeting/'.$meeting->meeting_id.'/details');
    }
    public function meeting_document_delete($id=NULL){
        $meeting = MeetingDocument::where('id',$id)->first();
        if(!$meeting){
            Session::flash('error','Meeting Document Not Found!');
            return redirect('all-application');
        }
        if (File::exists(public_path($meeting->document))) {
            File::delete(public_path($meeting->document));
        }
        $delete = MeetingDocument::where('id',$meeting->id)->delete();
        Session::flash('success','Meeting Document Deleted Successfully!');
        return redirect('meeting/'.$meeting->meeting_id.'/details');
    }
    //delete application
    public function delete_application($id=NULL){
        $application = Application::where('id',$id)->first();
        if(!$application){
            Session::flash('error','Application Data Not Found!');
            return redirect('all-application');
        }
        //delete application
        $application->application_status_id = 3;
        $application->save();
        Session::flash('warning','Application Data Deleted Successfully!');
        return redirect('all-application');
    }
    //delete document
    public function delete_application_document($id=NULL){
        $doc = ApplicationDocument::where('id',$id)->first();
        if(!$doc){
            Session::flash('error','Application Document Data Not Found! Internal Server Error!');
            return redirect('all-application');
        }
        if (File::exists(public_path($doc->doc))) {
            File::delete(public_path($doc->doc));
        }
        $delete = ApplicationDocument::where('id',$doc->id)->delete();
        Session::flash('warning','Application Document Data Deleted Successfully!');
        return redirect('application/'.$doc->application_id.'/processing');
    }
    //sop data post
    public function sop_data_post(Request $request){
        $request->validate([
            'sop_data'=>'required'
        ]);
        if($request->sop_id){
            $sop = ApplicationSop::where('id',$request->sop_id)->first();
        }else{
            $sop = new ApplicationSop();
        }
        $sop->sop_data = $request->sop_data;
        $sop->application_id = $request->sop_application_id;
        $sop->save();
        Session::flash('success','SOP Data Saved Successfully!');
        return redirect('application-create/'.$request->sop_application_id.'/step-2');
    }
    public function sop_plagiarism_check($id=NULL){
        $sop = ApplicationSop::where('id',$id)->first();
        if(!$sop){
            Session::flash('error','SOP Data Not Found! Internal Server Error!');
            return redirect('all-application');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.prepostseo.com/apis/checkPlag');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=b119cad90af540995ff287118c2d42e7&data=".$sop->sop_data);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $result_data = json_decode($result);
        $sop->total_queries = $result_data->totalQueries;
        $sop->plag_percent = $result_data->plagPercent;
        $sop->paraphrase_percent = $result_data->paraphrasePercent;
        $sop->unique_percent = $result_data->uniquePercent;
        $sop->total_plag_data = json_encode($result);
        $sop->save();
        Session::flash('success','Plagiarism Result Successfully Generated!');
        return redirect('application-create/'.$sop->application_id.'/step-2');
    }
    //for processing
    public function sop_plagiarism_check_from_processing($id=NULL){
        $sop = ApplicationSop::where('id',$id)->first();
        if(!$sop){
            Session::flash('error','SOP Data Not Found! Internal Server Error!');
            return redirect('all-application');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.prepostseo.com/apis/checkPlag');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=b119cad90af540995ff287118c2d42e7&data=".$sop->sop_data);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $result_data = json_decode($result);
        $sop->total_queries = $result_data->totalQueries;
        $sop->plag_percent = $result_data->plagPercent;
        $sop->paraphrase_percent = $result_data->paraphrasePercent;
        $sop->unique_percent = $result_data->uniquePercent;
        $sop->total_plag_data = json_encode($result);
        $sop->save();
        Session::flash('success','Plagiarism Result Successfully Generated!');
        return redirect('application/'.$sop->application_id.'/processing');
    }

}
