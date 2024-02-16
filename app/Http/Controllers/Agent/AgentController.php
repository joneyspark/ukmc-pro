<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentCreateRequest;
use App\Http\Requests\Agent\AgentEditRequest;
use App\Http\Requests\Agent\CreateEmpAgentByAdminRequest;
use App\Http\Requests\Agent\EditEmpAgentRequest;
use App\Mail\agent\agentConfirmationMail;
use App\Mail\agent\agentRequest;
use App\Mail\agent\newAgentRequest;
use App\Models\Agent\Agent;
use App\Models\Agent\Company;
use App\Models\Agent\CompanyDirector;
use App\Models\Agent\CompanyDocument;
use App\Models\Agent\CompanyReference;
use App\Models\Application\Application;
use App\Models\Application\ApplicationStatus;
use App\Models\Application\InterviewStatus;
use App\Models\Campus\Campus;
use App\Models\Setting\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Traits\Service;
use Illuminate\Support\Facades\Mail;
Use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use PharIo\Manifest\Url as ManifestUrl;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class AgentController extends Controller{
    use Service;

    public function agents(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        //check as super admin
        // if(Auth::user()->role != 'admin'){
        //     Session::flash('error','Login as Super Admin Then Create Campus!');
        //     return redirect('login');
        // }
        $data['company_id'] = Session::get('company_id');
        $company_name = $request->get('company_name');
        Session::put('company_name',$company_name);

        $data['companies'] = Company::query()
        ->when($company_name, function ($query, $company_name) {
            return $query->where('company_name', 'like', '%' . $company_name . '%');
        })
        ->withCount('users')
        ->orderBy('id','desc')
        ->where('status','!=',3)
        ->paginate(10)
        ->appends([
            'company_name' => $company_name,
        ]);
        $data['get_company_name'] = Session::get('company_name');
        $data['pending_agent_count'] = Company::where('status',3)->count();
        Session::put('current_url',URL::full());
        Session::forget('company_id');
        $data['page_title'] = 'Agents | List';
        $data['agent_menu'] = true;
        return view('agent/all',$data);
    }
    public function pending_agents(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        //check as super admin
        // if(Auth::user()->role != 'admin'){
        //     Session::flash('error','Login as Super Admin Then Create Campus!');
        //     return redirect('login');
        // }
        $data['company_id'] = Session::get('company_id');
        $company_name = $request->get('company_name');
        Session::put('company_name',$company_name);

        $data['companies'] = Company::query()
        ->when($company_name, function ($query, $company_name) {
            return $query->where('company_name', 'like', '%' . $company_name . '%');
        })
        ->withCount('users')
        ->orderBy('id','desc')
        ->where('status',3)
        ->paginate(10)
        ->appends([
            'company_name' => $company_name,
        ]);
        $data['get_company_name'] = Session::get('company_name');
        Session::put('current_url',URL::full());
        Session::forget('company_id');
        $data['page_title'] = 'Agents | List';
        $data['agent_menu'] = true;
        return view('agent/pending',$data);
    }
    public function reset_pending_company_list(){
        Session::forget('current_url');
        Session::forget('company_name');
        Session::forget('company_id');
        return redirect('pending-agents');
    }
    //edit pending agent function
    public function edit_pending_agent($id=NULL){
        $data['page_title'] = 'Agents | Edit Agent Data';
        $data['agent_menu'] = true;
        $data['company_data'] = Company::where('id',$id)->first();
        $data['countries'] = Service::countries();
        return view('agent/edit_pending_agent',$data);
    }
    public function reset_company_list(){
        Session::forget('current_url');
        Session::forget('company_name');
        Session::forget('company_id');
        return redirect('agents');
    }
    //edit company data
    public function edit_company($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'Company | Edit';
        $data['agent'] = true;
        $data['company_data'] = Company::where('id',$id)->first();
        $data['countries'] = Service::countries();
        return view('agent/edit',$data);
    }
    public function request_agent_application_data_post(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ]);
        $getCompany = Company::where('id',$request->company_id)->first();
        if(!$getCompany){
            Session::flash('error','Internal Server Error! Company Data Not Found');
            return redirect('pending-agents');
        }
        $first_name = "";
        $last_name = "";
        $user = new User();
        $user->name = $request->name;
        if($user->name){
            $array = explode(" ",$user->name);
            foreach($array as $key=>$row){
                if($key==0){
                    $first_name = $row;
                }
                if(!empty($row) && $key != 0){
                    $last_name .= $row.' ';
                }
            }
        }
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->role = 'agent';
        $user->email = $request->email;
        $user->phone = $getCompany->company_phone;
        //slug create
        $url_modify = Service::slug_create($request->name);
        $checkSlug = User::where('slug', 'LIKE', '%' . $url_modify . '%')->count();
        if ($checkSlug > 0) {
            $new_number = $checkSlug + 1;
            $new_slug = $url_modify . '-' . $new_number;
            $user->slug = $new_slug;
        } else {
            $user->slug = $url_modify;
        }

        $user->password = Hash::make($request->password);
        $user->company_id = $getCompany->id;
        $user->is_admin = 1;
        $user->active = 1;
        $user->save();
        //create agent information
        $agent = new Agent();
        $agent->user_id = $user->id;
        $agent->agent_name = $getCompany->company_name;
        $agent->agent_phone = $getCompany->company_phone;
        $agent->agent_email = $getCompany->company_email;
        $agent->alternative_person_contact = $getCompany->company_director->key_contact_number;
        $agent->nid_or_passport = $getCompany->company_director->passport_number;
        $agent->nationality = $getCompany->company_director->nationality;
        $agent->agent_country = $getCompany->country;
        $agent->agent_state = $getCompany->state;
        $agent->agent_city = $getCompany->city;
        $agent->agent_zip_code = $getCompany->zip_code;
        $agent->agent_address = $getCompany->address;
        $agent->save();
        //email create
        $details = [
            'agent_name'=>$user->name,
            'agent_email'=>$user->email,
            'agent_password'=>$request->password,
            'company'=>CompanySetting::where('id',1)->first(),
        ];
        //update company
        $update = Company::where('id',$getCompany->id)->update(['status'=>1]);
        Mail::to($user->email)->send(new agentConfirmationMail($details));
        Session::flash('success','Successfully Added A New Agent Company');
        return redirect('agents');
    }
    public function create_agent(){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        //check as super admin
        // if(Auth::user()->role != 'admin'){
        //     Session::flash('error','Login as Super Admin Then Create Campus!');
        //     return redirect('login');
        // }
        $data['page_title'] = 'Agents | Create Agent';
        $data['agent'] = true;
        $data['countries'] = Service::countries();
        return view('agent/create_agent',$data);
    }
    public function agent_details(){
        $data['page_title'] = 'Agents | Details';
        $data['agent'] = true;
        return view('agent/details',$data);
    }
    //create agent post
    public function create_agent_post_data(AgentCreateRequest $request){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        //check as super admin
        // if(Auth::user()->role != 'admin'){
        //     Session::flash('error','Login as Super Admin Then Create Campus!');
        //     return redirect('login');
        // }
        $company = new Company();
        $company->company_name = $request->input('company_name');
        $company->company_registration_number = $request->input('company_registration_number');
        $company->company_establish_date = $request->input('company_establish_date');
        //upload trade license doc here
        $company_doc = $request->company_trade_license;
        if ($request->hasFile('company_trade_license')) {

            $ext = $company_doc->getClientOriginalExtension();
            $doc_file_name = $company_doc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/company_trade_license/';
            Service::createDirectory($upload_path1);
            $request->file('company_trade_license')->move(public_path('backend/images/company/company_trade_license/'), $doc_file_name);
            $company->company_trade_license = $upload_path1.$doc_file_name;
        }

        $company->company_trade_license_number = $request->input('company_trade_license_number');
        $company->company_email = $request->input('company_email');
        $company->company_phone = $request->input('company_phone');
        $company->country = $request->input('country');
        $company->state = $request->input('state');
        $company->city = $request->input('city');
        $company->zip_code = $request->input('zip_code');
        $company->address = $request->input('address');
        //upload company logo
        $company_logo = $request->company_logo;
        if ($request->hasFile('company_logo')) {

            $ext = $company_logo->getClientOriginalExtension();
            $filename = $company_logo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($company_logo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/company/company_logo/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/company/company_logo/'.$filename));
            $company->company_logo = 'backend/images/company/company_logo/'.$filename;
        }
        $company->agreement_title = $request->input('agreement_title');
        //upload agreement doc here
        $agreement_doc_file = $request->agreement_doc_file;
        if ($request->hasFile('agreement_doc_file')) {

            $ext = $agreement_doc_file->getClientOriginalExtension();
            $doc_file_name = $agreement_doc_file->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/agreement_doc_file/';
            Service::createDirectory($upload_path1);
            $request->file('agreement_doc_file')->move(public_path('backend/images/company/agreement_doc_file/'), $doc_file_name);
            $company->agreement_doc_file = $upload_path1.$doc_file_name;
        }
        $company->agreement_expire_date = $request->input('agreement_expire_date');
        $company->save();
        //create user now
        if($company->id){
            $first_name = "";
            $last_name = "";
            $user = new User();
            $user->name = $request->name;
            if($user->name){
                $array = explode(" ",$user->name);
                foreach($array as $key=>$row){
                    if($key==0){
                        $first_name = $row;
                    }
                    if(!empty($row) && $key != 0){
                        $last_name .= $row.' ';
                    }
                }
            }
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->role = 'agent';
            $user->email = $request->email;
            $user->phone = $request->agent_phone;
            //slug create
            $url_modify = Service::slug_create($request->name);
            $checkSlug = User::where('slug', 'LIKE', '%' . $url_modify . '%')->count();
            if ($checkSlug > 0) {
                $new_number = $checkSlug + 1;
                $new_slug = $url_modify . '-' . $new_number;
                $user->slug = $new_slug;
            } else {
                $user->slug = $url_modify;
            }
            $photo = $request->image;
            if ($request->hasFile('image')) {

                $ext = $photo->getClientOriginalExtension();
                $filename = $photo->getClientOriginalName();
                $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
                $image_resize = Image::make($photo->getRealPath());
                $image_resize->resize(200, 200);
                $upload_path = 'backend/images/users/agent/';
                Service::createDirectory($upload_path);
                $image_resize->save(public_path('backend/images/users/agent/'.$filename));
                $user->photo = 'backend/images/users/agent/'.$filename;
            }
            $user->password = Hash::make($request->password);
            $user->company_id = $company->id;
            $user->is_admin = 1;
            $user->save();
            //create agent information
            $agent = new Agent();
            $agent->user_id = $user->id;
            $agent->agent_name = $request->agent_name;
            $agent->agent_phone = $request->agent_phone;
            $agent->agent_email = $request->agent_email;
            $agent->alternative_person_contact = $request->alternative_person_contact;
            $agent->nid_or_passport = $request->nid_or_passport;
            $agent->nationality = $request->nationality;
            $agent->agent_country = $request->agent_country;
            $agent->agent_state = $request->agent_state;
            $agent->agent_city = $request->agent_city;
            $agent->agent_zip_code = $request->agent_zip_code;
            $agent->agent_address = $request->agent_address;
            $agent->save();
        }
        Session::put('company_id',$company->id);
        Session::flash('success','New Agent Created Successfully!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('agents');
        }
    }
    //edit data post
    public function company_edit_data_post(AgentEditRequest $request){
        $company = Company::where('id',$request->company_id)->first();
        $company->company_name = $request->input('company_name');
        $company->company_registration_number = $request->input('company_registration_number');
        $company->company_establish_date = $request->input('company_establish_date');
        //upload trade license doc here
        $company_doc = $request->company_trade_license;
        if ($request->hasFile('company_trade_license')) {
            if (File::exists(public_path($company->company_trade_license))) {
                File::delete(public_path($company->company_trade_license));
            }
            $ext = $company_doc->getClientOriginalExtension();
            $doc_file_name = $company_doc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/company_trade_license/';
            Service::createDirectory($upload_path1);
            $request->file('company_trade_license')->move(public_path('backend/images/company/company_trade_license/'), $doc_file_name);
            $company->company_trade_license = $upload_path1.$doc_file_name;
        }

        $company->company_trade_license_number = $request->input('company_trade_license_number');
        $company->company_email = $request->input('company_email');
        $company->company_phone = $request->input('company_phone');
        $company->country = $request->input('country');
        $company->state = $request->input('state');
        $company->city = $request->input('city');
        $company->zip_code = $request->input('zip_code');
        $company->address = $request->input('address');
        //upload company logo
        $company_logo = $request->company_logo;
        if ($request->hasFile('company_logo')) {
            if (File::exists(public_path($company->company_logo))) {
                File::delete(public_path($company->company_logo));
            }
            $ext = $company_logo->getClientOriginalExtension();
            $filename = $company_logo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($company_logo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/company/company_logo/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/company/company_logo/'.$filename));
            $company->company_logo = 'backend/images/company/company_logo/'.$filename;
        }
        $company->agreement_title = $request->input('agreement_title');
        //upload agreement doc here
        $agreement_doc_file = $request->agreement_doc_file;
        if ($request->hasFile('agreement_doc_file')) {
            if (File::exists(public_path($company->agreement_doc_file))) {
                File::delete(public_path($company->agreement_doc_file));
            }
            $ext = $agreement_doc_file->getClientOriginalExtension();
            $doc_file_name = $agreement_doc_file->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/agreement_doc_file/';
            Service::createDirectory($upload_path1);
            $request->file('agreement_doc_file')->move(public_path('backend/images/company/agreement_doc_file/'), $doc_file_name);
            $company->agreement_doc_file = $upload_path1.$doc_file_name;
        }
        $company->agreement_expire_date = $request->input('agreement_expire_date');
        $company->save();
        Session::put('company_id',$company->id);
        Session::flash('success','Agent Updated Successfully!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('agents');
        }
    }
    //status change
    public function company_status_change(Request $request){
        $companyData = Company::where('id',$request->company_id)->first();
        if(!$companyData){
            $data['result'] = array(
                'key'=>101,
                'val'=>'User Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($companyData->status==1){
            $update = Company::where('id',$companyData->id)->update(['status'=>$request->status]);
            if($companyData->users->count() > 0){
                foreach($companyData->users as $user){
                    $udateUser = User::where('id',$user->id)->update(['active'=>0]);
                }
            }
            $msg = 'Agent Company Deactivated';
        }else{
            $update = Company::where('id',$companyData->id)->update(['status'=>$request->status]);
            if($companyData->users->count() > 0){
                foreach($companyData->users as $user){
                    $udateUser = User::where('id',$user->id)->update(['active'=>1]);
                }
            }
            $msg = 'Agent Company Activated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    //get all companyee employee
    public function get_employees_by_company($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'Agents | Employee List';
        $data['agent_id'] = Session::get('agent_id');
        $data['company_data'] = Company::where('id',$id)->first();
        $data['agent_data'] = User::where('role','agent')->where('company_id',$data['company_data']->id)->orderBy('id','desc')->paginate(10);
        $data['agent'] = true;
        Session::forget('agent_id');
        Session::put('current_url',URL::full());
        return view('agent/agent_list',$data);
    }
    public function create_agent_by_super_admin($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'Agents | Create New Employee';
        $data['company_data'] = Company::where('id',$id)->first();
        $data['countries'] = Service::countries();
        $data['agent'] = true;
        return view('agent/create_sub_agent_by_admin',$data);
    }
    public function create_agent_by_super_admin_post(CreateEmpAgentByAdminRequest $request){
        $first_name = "";
        $last_name = "";
        $user = new User();
        $user->name = $request->name;
        if($user->name){
            $array = explode(" ",$user->name);
            foreach($array as $key=>$row){
                if($key==0){
                    $first_name = $row;
                }
                if(!empty($row) && $key != 0){
                    $last_name .= $row.' ';
                }
            }
        }
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->role = 'agent';
        $user->email = $request->email;
        $user->phone = $request->agent_phone;
        //slug create
        $url_modify = Service::slug_create($request->name);
        $checkSlug = User::where('slug', 'LIKE', '%' . $url_modify . '%')->count();
        if ($checkSlug > 0) {
            $new_number = $checkSlug + 1;
            $new_slug = $url_modify . '-' . $new_number;
            $user->slug = $new_slug;
        } else {
            $user->slug = $url_modify;
        }
        $photo = $request->image;
        if ($request->hasFile('image')) {

            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/agent/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/agent/'.$filename));
            $user->photo = 'backend/images/users/agent/'.$filename;
        }
        $user->password = Hash::make($request->password);
        $user->company_id = $request->company_id;
        $user->is_admin = 0;
        $user->save();
        //create agent information
        $agent = new Agent();
        $agent->user_id = $user->id;
        $agent->agent_name = $request->agent_name;
        $agent->agent_phone = $request->agent_phone;
        $agent->agent_email = $request->agent_email;
        $agent->alternative_person_contact = $request->alternative_person_contact;
        $agent->nid_or_passport = $request->nid_or_passport;
        $agent->nationality = $request->nationality;
        $agent->agent_country = $request->agent_country;
        $agent->agent_state = $request->agent_state;
        $agent->agent_city = $request->agent_city;
        $agent->agent_zip_code = $request->agent_zip_code;
        $agent->agent_address = $request->agent_address;
        $agent->save();
        Session::put('agent_id',$user->id);
        Session::flash('success','New Agent Employee Created Successfully!');
        return redirect('get-employees-by-company/'.$request->company_id.'/list');
    }
    //edit agent details
    public function edit_agent_by_super_admin($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'Agents | Edit Agent Employee';
        $data['agent_data'] = User::where('id',$id)->first();
        $data['company_data'] = Company::where('id',$data['agent_data']->company_id)->first();
        $data['countries'] = Service::countries();
        $data['agent'] = true;
        return view('agent/edit_agent_details',$data);
    }
    public function edit_agent_by_super_admin_post(Request $request){
        $request->validate([
            'agent_name' => 'required',
            'agent_phone' => 'required',
            'agent_email' => 'required',
            'nid_or_passport' => 'required',
            'nationality' => 'required',
            'agent_country' => 'required',
            'agent_state' => 'required',
            'agent_city' => 'required',
            'agent_zip_code' => 'required',
            'agent_address' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $user = User::where('id',$request->user_id)->first();
        $photo = $request->image;
        if($request->hasFile('image')) {
            if (File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/agent/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/agent/'.$filename));
            $user->photo = 'backend/images/users/agent/'.$filename;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        //create agent information
        $agent = Agent::where('user_id',$user->id)->first();
        $agent->user_id = $user->id;
        $agent->agent_name = $request->agent_name;
        $agent->agent_phone = $request->agent_phone;
        $agent->agent_email = $request->agent_email;
        $agent->alternative_person_contact = $request->alternative_person_contact;
        $agent->nid_or_passport = $request->nid_or_passport;
        $agent->nationality = $request->nationality;
        $agent->agent_country = $request->agent_country;
        $agent->agent_state = $request->agent_state;
        $agent->agent_city = $request->agent_city;
        $agent->agent_zip_code = $request->agent_zip_code;
        $agent->agent_address = $request->agent_address;
        $agent->save();
        Session::put('agent_id',$user->id);
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('get-employees-by-company/'.$user->company_id.'/list');
        }
    }
    //employee list by agent company
    public function get_employee_by_agent(){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['agent_id'] = Session::get('agent_id');
        $data['page_title'] = 'Agent | Employee List';
        $data['agent_user'] = true;
        $data['agent_user_list'] = true;
        $data['agent_data'] = User::withCount(['agent_applications'])->where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        $data['company_data'] = Company::where('id',Auth::user()->company_id)->first();
        $data['countries'] = Service::countries();
        $data['agent'] = true;
        Session::forget('agent_id');
        return view('agent/get_employee_by_agent',$data);
    }
    //create employee by agent
    public function create_employee_by_agent(){
        if(!Auth::check() && Auth::user()->is_admin != 1){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'Agents | Create New Employee';
        $data['agent_user'] = true;
        $data['agent_user_list'] = true;
        $data['company_data'] = Company::where('id',Auth::user()->company_id)->first();
        $data['countries'] = Service::countries();
        $data['agent'] = true;
        return view('agent/create_employee_by_agent',$data);
    }
    //create employee by agent
    public function create_sub_agent_by_agent(){
        if(!Auth::check() && Auth::user()->is_admin != 1){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'Agents | Create New Sub Agent';
        $data['agent_user'] = true;
        $data['agent_user_list'] = true;
        $data['company_data'] = Company::where('id',Auth::user()->company_id)->first();
        $data['countries'] = Service::countries();
        $data['agent'] = true;
        return view('agent/create_sub_agent_by_agent',$data);
    }
    //post agent employee data
    public function create_employee_by_agent_post(CreateEmpAgentByAdminRequest $request){
        $first_name = "";
        $last_name = "";
        $user = new User();
        $user->name = $request->name;
        if($user->name){
            $array = explode(" ",$user->name);
            foreach($array as $key=>$row){
                if($key==0){
                    $first_name = $row;
                }
                if(!empty($row) && $key != 0){
                    $last_name .= $row.' ';
                }
            }
        }
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->role = $request->user_role;
        $user->email = $request->email;
        $user->phone = $request->agent_phone;
        //slug create
        $url_modify = Service::slug_create($request->name);
        $checkSlug = User::where('slug', 'LIKE', '%' . $url_modify . '%')->count();
        if ($checkSlug > 0) {
            $new_number = $checkSlug + 1;
            $new_slug = $url_modify . '-' . $new_number;
            $user->slug = $new_slug;
        } else {
            $user->slug = $url_modify;
        }
        $photo = $request->image;
        if ($request->hasFile('image')) {

            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/agent/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/agent/'.$filename));
            $user->photo = 'backend/images/users/agent/'.$filename;
        }
        $user->password = Hash::make($request->password);
        $user->company_id = Auth::user()->company_id;
        $user->is_admin = 0;
        $user->save();
        //create agent information
        $agent = new Agent();
        $agent->user_id = $user->id;
        $agent->agent_name = $request->agent_name;
        $agent->agent_phone = $request->agent_phone;
        $agent->agent_email = $request->agent_email;
        $agent->alternative_person_contact = $request->alternative_person_contact;
        $agent->nid_or_passport = $request->nid_or_passport;
        $agent->nationality = $request->nationality;
        $agent->agent_country = $request->agent_country;
        $agent->agent_state = $request->agent_state;
        $agent->agent_city = $request->agent_city;
        $agent->agent_zip_code = $request->agent_zip_code;
        $agent->agent_address = $request->agent_address;
        $agent->save();
        Session::put('agent_id',$user->id);
        Session::flash('success','New Agent Employee Created Successfully!');
        return redirect('get-employee-by-agent');
    }

    //edit part
    public function edit_employee_by_agent($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'Agents | Edit Agent Employee';
        $data['agent_user'] = true;
        $data['agent_user_list'] = true;
        $data['agent_data'] = User::where('id',$id)->first();
        $data['company_data'] = Company::where('id',Auth::user()->company_id)->first();
        $data['countries'] = Service::countries();
        $data['agent'] = true;
        return view('agent/edit_employee_by_agent',$data);
    }
    public function edit_employee_by_agent_post(EditEmpAgentRequest $request){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $user = User::where('id',$request->user_id)->first();
        $photo = $request->image;
        if($request->hasFile('image')) {
            if (File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/agent/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/agent/'.$filename));
            $user->photo = 'backend/images/users/agent/'.$filename;
        }
        $user->save();
        //create agent information
        $agent = Agent::where('user_id',$user->id)->first();
        $agent->user_id = $user->id;
        $agent->agent_name = $request->agent_name;
        $agent->agent_phone = $request->agent_phone;
        $agent->agent_email = $request->agent_email;
        $agent->alternative_person_contact = $request->alternative_person_contact;
        $agent->nid_or_passport = $request->nid_or_passport;
        $agent->nationality = $request->nationality;
        $agent->agent_country = $request->agent_country;
        $agent->agent_state = $request->agent_state;
        $agent->agent_city = $request->agent_city;
        $agent->agent_zip_code = $request->agent_zip_code;
        $agent->agent_address = $request->agent_address;
        $agent->save();
        Session::put('agent_id',$user->id);
        Session::flash('success','Employee Data Upadted Successfully!');
        return redirect('get-employee-by-agent');
    }
    public function agent_application(){
        $data['page_title'] = 'Agent Application | Form';
        //$data['company_data'] = Company::where('id',$id)->first();
        $data['countries'] = Service::countries();
        return view('agent/application/agent_application',$data);
    }
    //agent application data post
    public function agent_application_data_post(Request $request){
        $request->validate([
            'company_name'=>'required',
            'company_registration_number'=>'required',
            'company_establish_date'=>'required',
            'company_trade_license_number'=>'required',
            'company_email'=>'required',
            'company_phone'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'zip_code'=>'required',
            'address'=>'required',
            'director_name'=>'required',
            'director_phone'=>'required',
            'director_email'=>'required',
            'passport_number'=>'required',
            'nationality'=>'required',
            'director_address'=>'required',
            'director_city'=>'required',
            'key_contact_name'=>'required',
            'key_contact_number'=>'required',
            'reference_company_name'=>'required',
            'referee_name'=>'required',
            'referee_job_title'=>'required',
            'referee_address'=>'required',
            'referee_phone'=>'required',
            'referee_contact_email'=>'required',
            // 'reference_company_name2'=>'required',
            // 'referee_name2'=>'required',
            // 'referee_job_title2'=>'required',
            // 'referee_address2'=>'required',
            // 'referee_phone2'=>'required',
            // 'referee_contact_email2'=>'required',
        ]);
        $company = new Company();
        $company->company_name = $request->input('company_name');
        $company->company_registration_number = $request->input('company_registration_number');
        $company->company_establish_date = $request->input('company_establish_date');
        $company->company_trade_license_number = $request->input('company_trade_license_number');
        $company->company_email = $request->input('company_email');
        $company->company_phone = $request->input('company_phone');
        $company->country = $request->input('country');
        $company->state = $request->input('state');
        $company->city = $request->input('city');
        $company->zip_code = $request->input('zip_code');
        $company->address = $request->input('address');
        $company->status = 3;
        $company->save();
        //save director Information
        $companyDirector = new CompanyDirector();
        $companyDirector->director_name = $request->director_name;
        $companyDirector->company_id = $company->id;
        $companyDirector->email = $request->director_email;
        $companyDirector->phone = $request->director_phone;
        $companyDirector->passport_number = $request->passport_number;
        $companyDirector->nationality = $request->nationality;
        $companyDirector->address = $request->director_address;
        $companyDirector->city = $request->director_city;
        $companyDirector->key_contact_name = $request->key_contact_name;
        $companyDirector->key_contact_number = $request->key_contact_number;
        $companyDirector->save();
        //reference 1 save
        $reference1 = new CompanyReference();
        $reference1->company_id = $company->id;
        $reference1->company_name = $request->reference_company_name;
        $reference1->referee_name = $request->referee_name;
        $reference1->referee_job_title = $request->referee_job_title;
        $reference1->address = $request->referee_address;
        $reference1->phone = $request->referee_phone;
        $reference1->contact_email_address = $request->referee_contact_email;
        $reference1->save();
        //reference 2 save
        $reference2 = new CompanyReference();
        $reference2->company_id = $company->id;
        $reference2->company_name = $request->reference_company_name2;
        $reference2->referee_name = $request->referee_name2;
        $reference2->referee_job_title = $request->referee_job_title2;
        $reference2->address = $request->referee_address2;
        $reference2->phone = $request->referee_phone2;
        $reference2->contact_email_address = $request->referee_contact_email2;
        $reference2->save();
        //Company Certification doc file upload
        $company_certification = $request->company_certificate;
        if ($request->hasFile('company_certificate')) {

            $ext = $company_certification->getClientOriginalExtension();
            $doc_file_name = $company_certification->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/company_certificate/';
            Service::createDirectory($upload_path1);
            $request->file('company_certificate')->move(public_path('backend/images/company/company_certificate/'), $doc_file_name);
            $company_certificate = new CompanyDocument();
            $company_certificate->company_id = $company->id;
            $company_certificate->title = $request->company_certification_of_incorporation;
            $company_certificate->document = $upload_path1.$doc_file_name;
            $company_certificate->save();
        }
        //Director ID and passport file upload
        $directorIdPassport = $request->director_id_passport;
        if ($request->hasFile('director_id_passport')) {

            $ext = $directorIdPassport->getClientOriginalExtension();
            $doc_file_name = $directorIdPassport->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/director_id_passport/';
            Service::createDirectory($upload_path1);
            $request->file('director_id_passport')->move(public_path('backend/images/company/director_id_passport/'), $doc_file_name);
            $directorIdPassportDoc = new CompanyDocument();
            $directorIdPassportDoc->company_id = $company->id;
            $directorIdPassportDoc->title = $request->director_id_or_passport;
            $directorIdPassportDoc->document = $upload_path1.$doc_file_name;
            $directorIdPassportDoc->save();
        }
        //Agent Bank Account Details
        $bankAccountDoc = $request->bank_account_details_photo;
        if ($request->hasFile('bank_account_details_photo')) {

            $ext = $bankAccountDoc->getClientOriginalExtension();
            $doc_file_name = $bankAccountDoc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/bank_account_details_photo/';
            Service::createDirectory($upload_path1);
            $request->file('bank_account_details_photo')->move(public_path('backend/images/company/bank_account_details_photo/'), $doc_file_name);
            $bankAccount = new CompanyDocument();
            $bankAccount->company_id = $company->id;
            $bankAccount->title = $request->bank_account_details;
            $bankAccount->document = $upload_path1.$doc_file_name;
            $bankAccount->save();
        }
        //Signed Agreement Details
        $signedAgreementDoc = $request->signed_agent_agreement_photo;
        if ($request->hasFile('signed_agent_agreement_photo')) {

            $ext = $signedAgreementDoc->getClientOriginalExtension();
            $doc_file_name = $signedAgreementDoc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/company/signed_agent_agreement_photo/';
            Service::createDirectory($upload_path1);
            $request->file('signed_agent_agreement_photo')->move(public_path('backend/images/company/signed_agent_agreement_photo/'), $doc_file_name);
            $signedAgreementDocFile = new CompanyDocument();
            $signedAgreementDocFile->company_id = $company->id;
            $signedAgreementDocFile->title = $request->signed_agent_agreement;
            $signedAgreementDocFile->document = $upload_path1.$doc_file_name;
            $signedAgreementDocFile->save();
        }
        //make mail system with cc
        $details = [
            'company_info'=> Company::where('id',$company->id)->first(),
            'company'=>CompanySetting::where('id',1)->first(),
        ];
        //Mail::to('aiub.tanvir@gmail.com')->send(new newAgentRequest($details));
        $ccRecipients = ['Zahid@ukmcglobal.com','recruitmentrelations@ukmcglobal.com'];

        //$ccRecipients = ['tanvir.nawaz66@outlook.com','Link.mamun@fmail.com'];
        //Mail::to('aiub.tanvir@gmail.com')->send(new agentRequest($ccRecipients,$details));
        //Mail::to('hr@ukmcglobal.com')->send(new agentRequest($ccRecipients,$details));
        Session::flash('success','Agent Request Sent Successfully!');
        return redirect('agent-request-confimation');

    }
    public function agent_request_confimation(){
        $data['page_title'] = 'Agent Request | Confirmation';
        return view('agent/application/thankyou',$data);
    }
    //tranfer application
    public function get_sub_agent_for_transfer_application($id=NULL){
        $select = '';
        $users = User::where('id','!=',$id)->where('role','subAgent')->where('company_id',Auth::user()->company_id)->get();
        foreach($users as $user){
            $select .= '<option value="'.$user->id.'">'.$user->name.'</option>';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$select
        );
        return response()->json($data);
    }
    public function transfer_application_to_other_sub_agent(Request $request){
        $get_from_id = $request->from_sub_agent_id;
        $assign_to_id = $request->assign_to_user_id;
        if(!$assign_to_id){
            Session::flash('error','Assign To Sub Agent Not Found!');
            return redirect('get-employee-by-agent');
        }
        $getApplications = Application::where('create_by',$get_from_id)->get();
        if(!$getApplications){
            Session::flash('error','This Sub Don,t have any application right now!');
            return redirect('get-employee-by-agent');
        }
        foreach($getApplications as $row){
            $update = Application::where('id',$row->id)->update(['create_by'=>$request->assign_to_user_id]);
        }
        Session::flash('success','Successfully Transfer All Applcation To This User!');
        return redirect('get-employee-by-agent');
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
    //get subagent appplications
    public function get_sub_agent_applications($id=NULL,Request $request){
        $userData = User::where('id',$id)->first();
        if(!$userData){
            Session::flash('error','Sub Agent Data Not Found!');
            return redirect()->back();
        }
        $data['page_title'] = 'Sub Agent | Applications';
        $data['application'] = true;
        $data['sub_agent_application'] = true;
        $get_campus = $request->campus;
        $get_officer = $request->officer;
        $get_status = $request->status;
        $get_intake = $request->intake;
        $search = $request->q;
        $get_interview_status = $request->interview_status;
        $get_from_date = $request->from_date;
        $get_to_date = $request->to_date;
        //Session set data
        Session::put('get_campus',$get_campus);
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
        ->where('create_by',$userData->id)
        ->orderBy('created_at','desc')
        ->paginate(15)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'officer' => $get_officer,
            'status' => $get_status,
            'intake' => $get_intake,
            'interview_status' => $get_interview_status,
            'from_date' => $get_from_date,
            'to_date' => $get_to_date,
        ]);
        $data['my_teams'] = User::where('role','subAgent')->where('company_id',Auth::user()->company_id)->where('active',1)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();

        $data['get_campus'] = Session::get('get_campus');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');
        $data['get_interview_status'] = Session::get('get_interview_status');
        $data['get_from_date'] = Session::get('get_from_date');
        $data['get_to_date'] = Session::get('get_to_date');
        $data['get_application_id'] = Session::get('get_application_id');
        $data['sub_agent_id'] = $userData->id;
        //$data['agent_applications'] = Application::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('agent.application.get_sub_agent_application',$data);
    }
    //application assign to other sub agent
    public function application_assign_to_other_sub_agent(Request $request){
        $request->validate([
            'assign_to_sub_agent_id'=>'required',
            'assign_application_ids'=>'required',
        ]);
        $getIds = $request->assign_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect()->back();
        }
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->first();
            if($getApp){
                $getApp->create_by = $request->assign_to_sub_agent_id;
                $getApp->save();
            }
        }
        $count = count($array);

        Session::flash('success',$count.' Application Assigned Successfully!');
        return redirect()->back();
    }
}
