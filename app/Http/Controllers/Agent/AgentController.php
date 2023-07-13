<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentCreateRequest;
use App\Http\Requests\Agent\AgentEditRequest;
use App\Http\Requests\Agent\CreateEmpAgentByAdminRequest;
use App\Http\Requests\Agent\EditEmpAgentRequest;
use App\Models\Agent\Agent;
use App\Models\Agent\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Traits\Service;
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
        if(Auth::user()->role != 'admin'){
            Session::flash('error','Login as Super Admin Then Create Campus!');
            return redirect('login');
        }
        $data['company_id'] = Session::get('company_id');
        $company_name = $request->get('company_name');
        Session::put('company_name',$company_name);

        $data['companies'] = Company::query()
        ->when($company_name, function ($query, $company_name) {
            return $query->where('company_name', 'like', '%' . $company_name . '%');
        })
        ->withCount('users')
        ->orderBy('id','desc')
        ->paginate(10)
        ->appends([
            'company_name' => $company_name,
        ]);
        $data['get_company_name'] = Session::get('company_name');
        Session::put('current_url',URL::full());
        Session::forget('company_id');
        $data['page_title'] = 'Agents | List';
        $data['agent'] = true;
        return view('agent/all',$data);
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
    public function create_agent(){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        //check as super admin
        if(Auth::user()->role != 'admin'){
            Session::flash('error','Login as Super Admin Then Create Campus!');
            return redirect('login');
        }
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
        if(Auth::user()->role != 'admin'){
            Session::flash('error','Login as Super Admin Then Create Campus!');
            return redirect('login');
        }
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
        $data['agent_data'] = User::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
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
}
