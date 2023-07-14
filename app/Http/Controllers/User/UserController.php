<?php

namespace App\Http\Controllers\User;

use App\Events\AddNewLead;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionManager\AdmissionManagerRequest;
use App\Http\Requests\AdmissionManager\EditAdmissionManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
Use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Login\LoginRequest;
use App\Http\Requests\Manager\CreateManagerRequest;
use App\Http\Requests\Manager\EditManagerRequest;
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
use App\Models\Agent\Company;
use App\Models\Application\Application;
use App\Models\Application\ApplicationStatus;
use App\Models\Application\InterviewStatus;
use App\Models\Interviewer\Interviewer;
use App\Models\Notification\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class UserController extends Controller{
    use Service;
    //
    public function user_list(Request $request){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Then See User List!');
            return redirect('login');
        }
        $data['page_title'] = 'User Management';
        $data['usermanagement'] = true;
        $getUserId = Session::get('saved_user_id');
        $data['return_user_id'] = $getUserId;
        $data['interviewer_list'] = User::where('role','interviewer')->where('active',1)->get();
        $data['manager_list'] = User::where('role','manager')->where('active',1)->get();
        $data['officer_list'] = User::where('role','adminManager')->where('active',1)->get();
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
        ->where('role','!=','student')
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
    //confirm transfer to interviewer application
    public function confirm_transfer_application_to_interviewer(Request $request){
        $request->validate([
            'assign_to_interviewer_user_id'=>'required',
        ]);
        $assign_from = User::where('id',$request->interviewer_user_id)->first();
        if(!$assign_from){
            Session::flash('error','Assign From User Data Not Found! Server Error!');
            return redirect('user-list');
        }
        $getApplication = Application::where('interviewer_id',$request->interviewer_user_id)->get();
        if(count($getApplication) > 0){
            foreach($getApplication as $row){
                $application = Application::where('id',$row->id)->first();
                $application->interviewer_id = $request->assign_to_interviewer_user_id;
                $application->save();
            }
        }else{
            Session::flash('error','This User Don,t have any assigned application!');
            return redirect('user-list');
        }
        $assign_to_user = User::where('id',$request->assign_to_interviewer_user_id)->first();
        //create notification
        $notification = new Notification();
        $notification->title = 'Application Transfer To Other Interviewer';
        $notification->description = count($getApplication).' Application Transfer From '.$assign_from->name.' to '.$assign_to_user->name.' by '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->manager_id = 1;
        $notification->application_id = 0;
        $notification->slug = 'all-application';
        $notification->save();
        //make instant messaging
        $message = count($getApplication).' Application Transfer From '.$assign_from->name.' to '.$assign_to_user->name.' by '.Auth::user()->name;
        $url = url('all-application');
        event(new AddNewLead($message,$url));
        Session::put('saved_user_id',$assign_to_user->id);
        Session::flash('success',count($getApplication).' Application Transfer From '.$assign_from->name. ' to '.$assign_to_user->name.' by '.Auth::user()->name);
        return redirect('user-list');
    }
    //transfer application to admission officer
    public function confirm_transfer_application_to_admission_officer(Request $request){
        $request->validate([
            'manager_id'=>'required',
            'admission_officer_id'=>'required',
        ]);
        //return $request->all();
        $fromOfficer = User::where('id',$request->from_admission_officer_id)->first();
        if(!$fromOfficer){
            Session::flash('error','From Admission Officer Data Not Found! Internal Server Error');
            return redirect('user-list');
        }
        $getApplication = Application::where('admission_officer_id',$fromOfficer->id)->get();
        if(count($getApplication) > 0){
            foreach($getApplication as $row){
                $application = Application::where('id',$row->id)->first();
                $application->admission_officer_id = $request->admission_officer_id;
                $application->manager_id = $request->manager_id;
                $application->save();
            }
        }else{
            Session::flash('error','This User Don,t have any assigning Application!');
            return redirect('user-list');
        }
        $assign_to_user = User::where('id',$request->admission_officer_id)->first();
        //create notification
        $notification = new Notification();
        $notification->title = 'Application Transfer From '.$fromOfficer->name.' To Other Admission Officer';
        $notification->description = count($getApplication).' Application Transfer From '.$fromOfficer->name.' to '.$assign_to_user->name.' by '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->manager_id = 1;
        $notification->application_id = 0;
        $notification->slug = 'all-application';
        $notification->save();
        //make instant messaging
        $message = count($getApplication).' Application Transfer From '.$fromOfficer->name.' to '.$assign_to_user->name.' by '.Auth::user()->name;
        $url = url('all-application');
        event(new AddNewLead($message,$url));
        Session::put('saved_user_id',$assign_to_user->id);
        Session::flash('success',count($getApplication).' Application Transfer From '.$fromOfficer->name.' to '.$assign_to_user->name.' by '.Auth::user()->name);
        return redirect('user-list');
    }
    public function get_admission_officer_by_manager($manager_id=NULL){
        $officers = User::where('role','adminManager')->where('active',1)->get();
        $select = '';
        $select .= '<option value="">Select Admission Manager</option>';
        foreach($officers as $row){
            $select .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$select
        );
        return response()->json($data,200);
    }
    public function student_list(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First! Then See Student List!');
            return redirect('login');
        }
        $data['page_title'] = 'Student List';
        $data['studentmanagement'] = true;
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
        ->where('role','student')
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
        return view('users/student_list',$data);
    }
    public function reset_student_list(){
        Session::forget('saved_user_id');
        Session::forget('current_url');
        Session::forget('get_name');
        return redirect('student-list');
    }
    public function my_team_list(){
        if(!Auth::check() && Auth::user()->role != 'manager'){
            Session::flash('error','Login First! Then See User List!');
            return redirect('login');
        }
        $data['page_title'] = 'User Management';
        $data['usermanagement1'] = true;
        $getUserId = Session::get('saved_user_id');
        $data['return_user_id'] = $getUserId;
        $data['role_list'] = Service::get_roles();

        //query
        $data['user_list_data'] = User::query()
        ->where('role','adminManager')
        ->where('active',1)
        ->orderBy('id','desc')
        ->paginate(10);

        Session::forget('saved_user_id');
        Session::put('current_url',URL::full());
        return view('users/my_team_list',$data);
    }
    public function reset_user_list(){
        Session::forget('saved_user_id');
        Session::forget('current_url');
        Session::forget('get_role');
        Session::forget('get_name');
        return redirect('user-list');
    }
    public function get_assign_to_user($id=NULL){
        $users = User::where('create_by',Auth::user()->id)->where('role','adminManager')->where('id','!=',$id)->get();
        $select = '';
        if(count($users) > 0){
            $select .= '<option value="">Select User</option>';
            foreach($users as $row){
                $select .= '<option value="'.$row->id.'">'.$row->name.'</option>';
            }
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$select
        );
        return response()->json($data,200);
    }
    public function transfer_assign_to_user(Request $request){
        $request->validate([
            'assign_to_user_id'=>'required',
        ]);
        $assign_to = User::where('id',$request->assign_to_user_id)->first();
        if(!$assign_to){
            Session::flash('error','Assign To User Data Not Found! Server Error!');
            return redirect('my-team-list');
        }
        $getApplication = Application::where('admission_officer_id',$request->assign_user_id)->get();
        if(count($getApplication) > 0){
            foreach($getApplication as $row){
                $application = Application::where('id',$row->id)->first();
                $application->admission_officer_id = $request->assign_to_user_id;
                $application->manager_id = Auth::user()->id;
                $application->save();
            }
        }else{
            Session::flash('error','This User Don,t have any assigned application!');
            return redirect('my-team-list');
        }
        //create notification
        $notification = new Notification();
        $notification->title = 'Application Transfer To Other User';
        $notification->description = count($getApplication).' Application Transfer to '.$assign_to->name.' by '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->manager_id = 1;
        $notification->application_id = 0;
        $notification->slug = 'all-application';
        $notification->save();
        //make instant messaging
        $message = count($getApplication).' Application Transfer to '.$assign_to->name.' by '.Auth::user()->name;
        $url = url('all-application');
        event(new AddNewLead($message,$url));
        Session::flash('success',count($getApplication).' Application Transfer to '.$assign_to->name.' by '.Auth::user()->name);
        return redirect('my-team-list');
    }
    public function create_manager(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'User | Create Manager';
        $data['usermanagement'] = true;
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/create_manager',$data);
    }
    public function create_manager_post_data(CreateManagerRequest $request){
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
        $user->role = 'manager';
        $user->email = $request->email;
        $user->phone = $request->officer_phone;
        //$user->slug = Str::slug($request->name,'-');
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
            $upload_path = 'backend/images/users/admission_manager/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/admission_manager/'.$filename));
            $user->photo = 'backend/images/users/admission_manager/'.$filename;
        }
        $user->password = Hash::make($request->password);
        $user->save();
        //create admission officer now
        $officer = new AdmissionOfficer();
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

    public function create_admission_manager(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'User | Create Admission Manager';
        $data['usermanagement'] = true;
        $data['managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/create_admiossion_manager',$data);
    }
    public function create_admission_manager_by_manager(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        $data['page_title'] = 'User | Create Admission Manager';
        $data['usermanagement'] = true;
        $data['managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/create_admiossion_manager_by_manager',$data);
    }
    public function create_admission_manager_by_manager_post(Request $request){
        $request->validate([
            'officer_name' => 'required',
            'officer_phone' => 'required',
            'officer_email' => 'required',
            'officer_alternative_contact' => 'required',
            //'officer_nid_or_passport' => 'required',
            //'nationality' => 'required',
            //'country' => 'required',
            //'state' => 'required',
            //'city' => 'required',
            //'address' => 'required',
            'photo' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ]);
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
        $user->create_by = Auth::user()->id;
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
            return redirect('my-team-list');
        }
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
        $user->create_by = Auth::user()->id;
        //$user->slug = Str::slug($request->name,'-');
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
    public function edit_admission_manager_by_manager($slug=NULL){
        if(!Auth::check() && Auth::user()->role != 'manager'){
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
        $data['managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/edit_admission_manager_by_manager',$data);
    }
    public function edit_admission_manager_by_manager_post(Request $request){
        $request->validate([
            'officer_name' => 'required',
            'officer_phone' => 'required',
            'officer_email' => 'required',
            'officer_alternative_contact' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);
        //first create user
        $first_name = "";
        $last_name = "";
        $user = User::where('id',$request->user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
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
        $user->create_by = Auth::user()->id;
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
            $upload_path = 'backend/images/users/admission_manager/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/admission_manager/'.$filename));
            $user->photo = 'backend/images/users/admission_manager/'.$filename;
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
        Session::flash('success','Successfully Updated Admission Manager Information!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('my-team-list');
        }
    }
    //edit manager data
    //edit admission manager
    public function edit_manager($slug=NULL){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Then Update Admission Manager Information!');
            return redirect('login');
        }
        $data['officer_data'] = User::with(['officer'])->where('slug',$slug)->first();
        //dd($data['teacher_data']);
        if(!$data['officer_data']){
            Session::flash('error','Admission Manager Data Not Found! Server Error!');
            if(Session::get('current_url')){
                return redirect(Session::get('current_url'));
            }else{
                return redirect('user-list');
            }
        }
        $data['page_title'] = 'User | Edit Admission Manager';
        $data['usermanagement'] = true;
        //$data['managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/edit_manager',$data);
    }
    //edit manager data post
    public function edit_manager_data_post(Request $request){
        $request->validate([
            'officer_name' => 'required',
            'officer_phone' => 'required',
            'officer_email' => 'required',
            'officer_alternative_contact' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);
        //first create user
        $first_name = "";
        $last_name = "";
        $user = User::where('id',$request->user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
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
        //$user->create_by = $request->manager_id;
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
            $upload_path = 'backend/images/users/admission_manager/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/admission_manager/'.$filename));
            $user->photo = 'backend/images/users/admission_manager/'.$filename;
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
        Session::flash('success','Successfully Updated Admission Manager Information!');
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
    //create teacher function
    public function create_teacher(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Login First! Create Interviewer!');
            return redirect('login');
        }
        $data['page_title'] = 'User | Create Teacher';
        $data['usermanagement'] = true;
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/create_teacher',$data);
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
        //$user->slug = Str::slug($request->name,'-');
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
        $data['managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/edit_admission_manager',$data);
    }
    //officer edit data post
    public function edit_officer_data_post(Request $request){
        $request->validate([
            'officer_name' => 'required',
            'officer_phone' => 'required',
            'officer_email' => 'required',
            'officer_alternative_contact' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);
        //first create user
        $first_name = "";
        $last_name = "";
        $user = User::where('id',$request->user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
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
        $user->create_by = Auth::user()->id;
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
    //interviewer function
    public function create_interviewer(){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Interviewer!');
            return redirect('login');
        }
        $data['page_title'] = 'User | Create Interviewer';
        $data['usermanagement'] = true;
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/interviewer/create_interviewer',$data);
    }
    public function create_interviewer_data_post(Request $request){
        $request->validate([
            'interviewer_name' => 'required',
            'interviewer_phone' => 'required',
            'interviewer_email' => 'required',
            'interviewer_alternative_contact' => 'required',
            'photo' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ]);
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
        $user->role = 'interviewer';
        $user->email = $request->email;
        $user->phone = $request->interviewer_phone;
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
            $upload_path = 'backend/images/users/interviewer/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/interviewer/'.$filename));
            $user->photo = 'backend/images/users/interviewer/'.$filename;
        }
        $user->password = Hash::make($request->password);
        $user->save();
        //create admission officer now
        $interviewer = new Interviewer();
        $interviewer->user_id = $user->id;
        $interviewer->interviewer_name = $request->interviewer_name;
        $interviewer->interviewer_phone = $request->interviewer_phone;
        $interviewer->interviewer_email = $request->interviewer_email;
        $interviewer->interviewer_alternative_contact = $request->interviewer_alternative_contact;
        $interviewer->interviewer_nid_or_passport = $request->interviewer_nid_or_passport;
        $interviewer->nationality = $request->nationality;
        $interviewer->country = $request->country;
        $interviewer->state = $request->state;
        $interviewer->city = $request->city;
        $interviewer->address = $request->address;
        $interviewer->save();
        Session::put('saved_user_id',$user->id);
        Session::flash('success','Successfully Saved Interviewer Information!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('user-list');
        }
    }
    public function edit_interviewer($slug=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Then Update Interviewer Information!');
            return redirect('login');
        }
        $data['officer_data'] = User::with(['interviewer'])->where('slug',$slug)->first();
        //dd($data['teacher_data']);
        if(!$data['officer_data']){
            Session::flash('error','Interviewer Data Not Found! Server Error!');
            if(Session::get('current_url')){
                return redirect(Session::get('current_url'));
            }else{
                return redirect('user-list');
            }
        }
        $data['page_title'] = 'User | Edit Interviewer';
        $data['usermanagement'] = true;
        //$data['managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('users/interviewer/edit_interviewer',$data);
    }
    public function edit_interviewer_data_post(Request $request){
        $request->validate([
            'interviewer_name' => 'required',
            'interviewer_phone' => 'required',
            'interviewer_email' => 'required',
            'interviewer_alternative_contact' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
        ]);
        //first create user
        $first_name = "";
        $last_name = "";
        $user = User::where('id',$request->user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
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
        //$user->create_by = Auth::user()->id;
        $user->phone = $request->interviewer_phone;
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
            $upload_path = 'backend/images/users/interviewer/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/users/interviewer/'.$filename));
            $user->photo = 'backend/images/users/interviewer/'.$filename;
        }
        $user->save();
        //create admission officer now
        $interviewer = Interviewer::where('user_id',$user->id)->first();
        $interviewer->user_id = $user->id;
        $interviewer->interviewer_name = $request->interviewer_name;
        $interviewer->interviewer_phone = $request->interviewer_phone;
        $interviewer->interviewer_email = $request->interviewer_email;
        $interviewer->interviewer_alternative_contact = $request->interviewer_alternative_contact;
        $interviewer->interviewer_nid_or_passport = $request->interviewer_nid_or_passport;
        $interviewer->nationality = $request->nationality;
        $interviewer->country = $request->country;
        $interviewer->state = $request->state;
        $interviewer->city = $request->city;
        $interviewer->address = $request->address;
        $interviewer->save();
        Session::put('saved_user_id',$user->id);
        Session::flash('success','Successfully Updated Interviewer Information!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('user-list');
        }
    }
    //get application by interviewer
    public function get_interviewer_application(Request $request,$id=NULL){
        $data['page_title'] = 'Interviewer Application';
        $data['usermanagement'] = true;
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
        Session::put('interviewer_id',$id);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['interviewer_list'] = User::where('role','interviewer')->where('id','!=',$id)->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
        $data['interview_statuses'] = InterviewStatus::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();
        $data['interviewer_id'] = $id;

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
        ->where('interviewer_id',$id)
        ->orderBy('created_at','desc')
        ->paginate(15)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_campus,
            'officer' => $get_campus,
            'status' => $get_campus,
            'intake' => $get_campus,
        ]);

        $data['my_teams'] = User::where('role','adminManager')->where('create_by',Auth::user()->id)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();

        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');

        return view('users/interviewer/interviewer_applications',$data);
    }
    //application assign to Interviewer
    public function application_assign_to_other_interviewer(Request $request){
        $request->validate([
            'assign_to_interviewer_id'=>'required',
        ]);
        $getIds = $request->assign_interviewer_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect('get-interviewer-application/'.$request->current_assign_id);
        }
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->first();
            if($getApp){
                $getApp->interviewer_id = $request->assign_to_interviewer_id;
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
        return redirect('get-interviewer-application/'.$request->current_assign_id);
    }
    public function reset_interviewer_application_search_list(){
        Session::put('get_campus','');
        Session::put('get_agent','');
        Session::put('get_officer','');
        Session::put('get_status','');
        Session::put('get_intake','');
        Session::put('search','');
        $id = Session::get('interviewer_id');
        return redirect('get-interviewer-application/'.$id);
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
    //get application by admission officer
    public function get_admission_officer_application(Request $request,$id=NULL){
        $data['page_title'] = 'Admission Officer Application';
        $data['usermanagement1'] = true;
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
        Session::put('admission_officer_id',$id);

        $data['campuses'] = Campus::where('active',1)->get();
        $data['agents'] = Company::where('status',1)->get();
        $data['officers'] = User::where('role','adminManager')->where('active',1)->get();
        $data['interviewer_list'] = User::where('role','interviewer')->where('id','!=',$id)->where('active',1)->get();
        $data['statuses'] = ApplicationStatus::where('status',0)->get();
        $data['interview_statuses'] = InterviewStatus::where('status',0)->get();
        $data['intakes'] = $this->unique_intake_info();
        $data['admission_officer_id'] = $id;
        $data['interviewer_id'] = $id;

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
        ->where('admission_officer_id',$id)
        ->orderBy('created_at','desc')
        ->paginate(15)
        ->appends([
            'q' => $search,
            'campus' => $get_campus,
            'agent' => $get_campus,
            'officer' => $get_campus,
            'status' => $get_campus,
            'intake' => $get_campus,
        ]);

        $data['my_teams'] = User::where('role','adminManager')->where('active',1)->get();
        $data['admin_managers'] = User::where('role','manager')->where('active',1)->get();

        $data['get_campus'] = Session::get('get_campus');
        $data['get_agent'] = Session::get('get_agent');
        $data['get_officer'] = Session::get('get_officer');
        $data['get_status'] = Session::get('get_status');
        $data['get_intake'] = Session::get('get_intake');
        $data['search'] = Session::get('search');

        return view('users/officer/officer_applications',$data);
    }
    //application assign to admin officer by super admin
    //application assign to Manager
    public function application_assign_to_manager_by_admin(Request $request){
        $request->validate([
            'assign_to_admission_manager_id'=>'required',
            'assign_to_manager_id'=>'required',
        ]);
        $getIds = $request->assign_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect('get-admission-officer-application/'.$request->admission_officer_id);
        }
        $getAdmissionOfficer = User::where('id',$request->admission_officer_id)->first();
        $assignTo = User::where('id',$request->assign_to_admission_manager_id)->first();
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->first();
            if($getApp){
                $getApp->admission_officer_id = $request->assign_to_admission_manager_id;
                $getApp->manager_id = $request->assign_to_manager_id;
                $getApp->save();
            }
        }
        $count = count($array);
        //create notification
        $notification = new Notification();
        $notification->title = 'Transfer Lead';
        $notification->description = $count.' Application Transfer From '.$getAdmissionOfficer->name.' To '.$assignTo->name. ' By '.Auth::user()->name;
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
        //event(new AddNewLead($notification->description,$url));
        Session::flash('success',$notification->description);
        return redirect('get-admission-officer-application/'.$request->admission_officer_id);
    }
    //application assign to user
    public function application_assign_to_officer_by_manager(Request $request){
        $request->validate([
            'assign_to_user_id'=>'required',
        ]);
        $getIds = $request->assign_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect('all-application');
        }
        $fromOfficer = User::where('id',$request->admission_officer_id)->first();
        $toOfficer = User::where('id',$request->assign_to_user_id)->first();
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->first();
            if($getApp){
                $getApp->admission_officer_id = $request->assign_to_user_id;
                $getApp->manager_id = Auth::user()->id;
                $getApp->save();
            }
        }
        $count = count($array);
        //create notification
        $notification = new Notification();
        $notification->title = 'Assign Lead';
        $notification->description = $count.' Application Transfer From '.$fromOfficer->name.' To '.$toOfficer->name.' Assigned By '.Auth::user()->name;
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
        Session::flash('success',$notification->description);
        return redirect('get-admission-officer-application/'.$fromOfficer->id);
    }
    //application transfer to other application officer
    public function application_transfer_to_other_officer_by_officer(Request $request){
        $request->validate([
            'assign_to_user_id'=>'required',
        ]);
        $getIds = $request->assign_application_ids;
        if(!$getIds){
            Session::flash('error','Internal Server Error! Application Data Not Found!');
            return redirect('all-application');
        }
        $fromOfficer = User::where('id',$request->admission_officer_id)->first();
        $toOfficer = User::where('id',$request->assign_to_user_id)->first();
        $array = explode(",",$getIds);
        foreach($array as $row){
            $getApp = Application::where('id',$row)->first();
            if($getApp){
                $getApp->admission_officer_id = $request->assign_to_user_id;
                $getApp->save();
            }
        }
        $count = count($array);
        //create notification
        $notification = new Notification();
        $notification->title = 'Assign Lead';
        $notification->description = $count.' Application Transfer From '.$fromOfficer->name.' To '.$toOfficer->name.' Assigned By '.Auth::user()->name;
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
        Session::flash('success',$notification->description);
        return redirect('my-applications');
    }
}
