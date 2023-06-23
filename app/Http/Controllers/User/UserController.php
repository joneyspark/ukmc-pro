<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionManager\AdmissionManagerRequest;
use App\Http\Requests\AdmissionManager\EditAdmissionManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
Use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Teacher\EditTeacherRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use PharIo\Manifest\Url as ManifestUrl;
use App\Models\Setting\CompanySetting;
use App\Mail\forgotPasswordMail;
use App\Models\User;
use App\Traits\Service;
use App\Models\Campus\Campus;
use App\Models\Admission\AdmissionOfficer;
use Intervention\Image\Facades\Image;
use App\Models\Teacher\Teacher;
use App\Http\Requests\Teacher\TeacherCreateRequest;
use Illuminate\Support\Facades\File;

class UserController extends Controller{
    use Service;
    //
    public function user_list(Request $request){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'User Management';
        $data['usermanagement'] = true;
        $getUserId = Session::get('saved_user_id');
        $data['return_user_id'] = $getUserId;

        //work on search option
        $role = $request->get('role');
        $name = $request->get('name');
        Session::put('get_role',$role);
        Session::put('get_name',$name);
        //query
        $data['user_list_data'] = User::query()
        ->when($name, function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        ->when($role, function ($query, $role) {
            return $query->where('role', $role);
        })
        ->where('id','!=',Auth::user()->id)
        ->where('role','!=','agent')
        ->orderBy('id','desc')
        ->paginate(10)
        ->appends([
            'name' => $name,
            'role' => $role,
        ]);

        $data['get_role'] = Session::get('get_role');
        $data['get_name'] = Session::get('get_name');
        $data['role_list'] = Service::get_roles();

        Session::forget('saved_user_id');
        Session::put('current_url',URL::full());
        return view('users/list',$data);
    }
    public function reset_user_list(){
        Session::forget('saved_user_id');
        Session::forget('current_url');
        Session::forget('get_role');
        Session::forget('get_name');
        return redirect('user-list');
    }
    public function create_teacher(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'User | Create Teacher';
        $data['usermanagement'] = true;
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/create_teacher',$data);
    }
    public function create_admission_manager(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'User | Create Admission Manager';
        $data['usermanagement'] = true;
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/create_admiossion_manager',$data);
    }
    //create admission manager post data
    public function create_admission_manager_post_data(AdmissionManagerRequest $request){
        //first create user
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
        $user->role = 'adminManager';
        $user->email = $request->email;
        $user->phone = $request->officer_phone;
        $user->slug = Str::slug($request->name,'-');
        //photo upload
        $photo = $request->photo;
        if ($request->hasFile('photo')) {
            // if (File::exists(public_path('backend/images/company_logo/'.$company->company_logo))) {
            //     File::delete(public_path('backend/images/company_logo/'.$company->company_logo));
            // }
            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/admission_officer/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/admission_officer/'.$filename));
            $user->photo = 'backend/images/users/admission_officer/'.$filename;
        }
        $user->password = Hash::make($request->password);
        $user->save();
        //create admission officer now
        $officer = new AdmissionOfficer();
        $officer->campus_id = $request->campus_id;
        $officer->user_id = $user->id;
        $officer->officer_name = $request->officer_name;
        $officer->officer_phone = $request->officer_phone;
        $officer->officer_email = $request->officer_email;
        $officer->officer_alternative_contact = $request->officer_alternative_contact;
        $officer->officer_nid_or_passport = $request->officer_nid_or_passport;
        $officer->nationality = $request->nationality;
        $officer->country = $request->country;
        $officer->state = $request->state;
        $officer->city = $request->city;
        $officer->address = $request->address;
        $officer->save();
        Session::put('saved_user_id',$user->id);
        Session::flash('success','Admission Officer Created Successfully');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('user-list');
        }

    }
    //create teacher
    public function create_teacher_post_data(TeacherCreateRequest $request){
        //first create user
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
        $user->role = 'teacher';
        $user->email = $request->email;
        $user->phone = $request->teacher_phone;
        $user->slug = Str::slug($request->name,'-');
        //photo upload
        $photo = $request->photo;
        if ($request->hasFile('photo')) {
            // if (File::exists(public_path('backend/images/company_logo/'.$company->company_logo))) {
            //     File::delete(public_path('backend/images/company_logo/'.$company->company_logo));
            // }
            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/teacher/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/teacher/'.$filename));
            $user->photo = 'backend/images/users/teacher/'.$filename;
        }
        $user->password = Hash::make($request->password);
        $user->save();
        //create admission officer now
        $teacher = new Teacher();
        $teacher->campus_id = $request->campus_id;
        $teacher->user_id = $user->id;
        $teacher->teacher_name = $request->teacher_name;
        $teacher->teacher_phone = $request->teacher_phone;
        $teacher->teacher_email = $request->teacher_email;
        $teacher->teacher_alternative_contact = $request->teacher_alternative_contact;
        $teacher->teacher_nid_or_passport = $request->teacher_nid_or_passport;
        $teacher->nationality = $request->nationality;
        $teacher->country = $request->country;
        $teacher->state = $request->state;
        $teacher->city = $request->city;
        $teacher->address = $request->address;
        $teacher->save();
        Session::put('saved_user_id',$user->id);
        Session::flash('success','Successfully Saved Teacher Information!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('user-list');
        }
    }
    //user status change
    public function user_status_chnage(Request $request){
        $userData = User::where('id',$request->user_id)->first();
        if(!$userData){
            $data['result'] = array(
                'key'=>101,
                'val'=>'User Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($userData->active==1){
            $update = User::where('id',$userData->id)->update(['active'=>$request->active]);
            $msg = 'User Deactivated';
        }else{
            $update = User::where('id',$userData->id)->update(['active'=>$request->active]);
            $msg = 'User Activated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    //user role confirm
    public function user_role_confirm(Request $request){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $roll_name = $request->roll_name;
        if(!$roll_name){
            Session::flash('error','You don,t select any roll Name. Please Select When Pop Up!');
            if(Session::get('current_url')){
                return redirect(Session::get('current_url'));
            }else{
                return redirect('user-list');
            }
        }
        $getUserData = User::where('id',$request->user_id)->first();
        $getUserData->role = $roll_name;
        $getUserData->save();
        Session::put('saved_user_id',$getUserData->id);
        Session::flash('success','Successfully Changed The Current User Role!');
        if(Session::get('current_url')){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('user-list');
        }
    }
    //edit teacher
    public function edit_teacher($slug=NULL){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Then Update Teacher Information!');
            return redirect('login');
        }
        $data['teacher_data'] = User::with(['teacher'])->where('slug',$slug)->first();
        //dd($data['teacher_data']);
        if(!$data['teacher_data']){
            Session::flash('error','Teacher Data Not Found! Server Error!');
            if(Session::get('current_url')){
                return redirect(Session::get('current_url'));
            }else{
                return redirect('user-list');
            }
        }
        $data['page_title'] = 'User | Edit Teacher';
        $data['usermanagement'] = true;
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/edit_teacher',$data);
    }
    //teacher edit data post
    public function edit_teacher_data_post(EditTeacherRequest $request){
        //first create user
        $first_name = "";
        $last_name = "";
        $user = User::where('id',$request->user_id)->first();
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
        $user->phone = $request->teacher_phone;
        //photo upload
        $photo = $request->photo;
        if ($request->hasFile('photo')) {
            if (File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/teacher/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/teacher/'.$filename));
            $user->photo = 'backend/images/users/teacher/'.$filename;
        }
        $user->save();
        //create admission officer now
        $teacher = Teacher::where('user_id',$user->id)->first();
        $teacher->campus_id = $request->campus_id;
        $teacher->user_id = $user->id;
        $teacher->teacher_name = $request->teacher_name;
        $teacher->teacher_phone = $request->teacher_phone;
        $teacher->teacher_email = $request->teacher_email;
        $teacher->teacher_alternative_contact = $request->teacher_alternative_contact;
        $teacher->teacher_nid_or_passport = $request->teacher_nid_or_passport;
        $teacher->nationality = $request->nationality;
        $teacher->country = $request->country;
        $teacher->state = $request->state;
        $teacher->city = $request->city;
        $teacher->address = $request->address;
        $teacher->save();
        Session::put('saved_user_id',$user->id);
        Session::flash('success','Successfully Updated Teacher Information!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('user-list');
        }
    }
    //edit admission manager
    public function edit_admission_manager($slug=NULL){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Then Update Admission Officer Information!');
            return redirect('login');
        }
        $data['officer_data'] = User::with(['officer'])->where('slug',$slug)->first();
        //dd($data['teacher_data']);
        if(!$data['officer_data']){
            Session::flash('error','Admission Officer Data Not Found! Server Error!');
            if(Session::get('current_url')){
                return redirect(Session::get('current_url'));
            }else{
                return redirect('user-list');
            }
        }
        $data['page_title'] = 'User | Edit Admission Officer';
        $data['usermanagement'] = true;
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/edit_admission_manager',$data);
    }
    //officer edit data post
    public function edit_officer_data_post(EditAdmissionManagerRequest $request){
        //first create user
        $first_name = "";
        $last_name = "";
        $user = User::where('id',$request->user_id)->first();
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
        $user->phone = $request->officer_phone;
        //photo upload
        $photo = $request->photo;
        if ($request->hasFile('photo')) {
            if (File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/admission_officer/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/admission_officer/'.$filename));
            $user->photo = 'backend/images/users/admission_officer/'.$filename;
        }
        $user->save();
        //create admission officer now
        $officer = AdmissionOfficer::where('user_id',$user->id)->first();
        $officer->campus_id = $request->campus_id;
        $officer->user_id = $user->id;
        $officer->officer_name = $request->officer_name;
        $officer->officer_phone = $request->officer_phone;
        $officer->officer_email = $request->officer_email;
        $officer->officer_alternative_contact = $request->officer_alternative_contact;
        $officer->officer_nid_or_passport = $request->officer_nid_or_passport;
        $officer->nationality = $request->nationality;
        $officer->country = $request->country;
        $officer->state = $request->state;
        $officer->city = $request->city;
        $officer->address = $request->address;
        $officer->save();
        Session::put('saved_user_id',$user->id);
        Session::flash('success','Successfully Updated Admission Officer Information!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('user-list');
        }
    }
    public function profile_settings(){
        $data['page_title'] = 'Profile / Settings';
        $data['settings'] = true;
        $data['profile_settings'] = true;
        $data['my_data'] = User::where('id',Auth::user()->id)->first();
        return view('setting/profile_settings',$data);
    }

    public function edit_profile(){
        $data['page_title'] = 'Edit / Settings';
        $data['settings'] = true;
        $data['edit_profile'] = true;
        $data['countries'] = Service::countries();
        return view('setting/edit_profile',$data);
    }
    public function my_profile_update(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First Then Update Profile!');
            return redirect('login');
        }
        $user = User::where('id',Auth::user()->id)->first();
        $user->name = $request->name;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->address = $request->address;
        //photo upload
        $photo = $request->photo;
        if ($request->hasFile('photo')) {
            if (File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $ext = $photo->getClientOriginalExtension();
            $filename = $photo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($photo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/users/photo/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/photo/'.$filename));
            $user->photo = 'backend/images/users/photo/'.$filename;
        }
        $user->save();
        Session::flash('success','Profile Updated Successfully!');
        return redirect('profile-settings');
    }
}
