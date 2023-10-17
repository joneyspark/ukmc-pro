<?php

namespace App\Http\Controllers;

use App\Models\Application\Application;
use Illuminate\Http\Request;
use App\Traits\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Notification\Notification;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HomeController extends Controller{
    use Service;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        if(!Auth::check()){
            Session::flash('error','Login First! Then See Dashboard!');
            return redirect('login');
        }
        $dataAgent = array();
        $direct = array();

        $currentMonth = Carbon::now();
        $currentMonthFormat = Carbon::now()->format('F');
        $previousMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $previousMonth = Carbon::now()->subMonths($i)->format('M');
            $previousMonths[] = $previousMonth;
        }
        for ($i = 1; $i <= 12; $i++) {
            $startDate = $currentMonth->copy()->subMonths($i)->startOfMonth();
            $endDate = $currentMonth->copy()->subMonths($i)->endOfMonth();

            $count = Application::where('application_type',1)->whereBetween('created_at', [$startDate, $endDate])->count();
            $count1 = Application::where('application_type',3)->whereBetween('created_at', [$startDate, $endDate])->count();

            $dataAgent[] = $count;
            $direct[] = $count1;
        }
        $month_array = array_reverse($previousMonths);
        $month_string = '';
        foreach($month_array as $key=>$row){
            if(end($month_array)==$row){
                $month_string .= "'".$row."'";
            }else{
                $month_string .= "'".$row."'".',';
            }
        }
        //loop
        $agent_atring = '';
        foreach($dataAgent as $row){
            if($row==0){
                $row = $row + 1;
            }
            if(end($dataAgent)==$row){
                $agent_atring .= $row;
            }else{
                $agent_atring .= $row.',';
            }
        }
        $direct_atring = '';
        foreach($direct as $row){
            if($row==0){
                $row = $row + 1;
            }
            if(end($direct)==$row){
                $direct_atring .= $row;
            }else{
                $direct_atring .= $row.',';
            }
        }
        $data['month_string'] = $month_string;
        $data['agent_atring'] = $agent_atring;
        $data['direct_atring'] = $direct_atring;

        $data['page_title'] = 'Dashboard';
        $data['dashboard'] = true;
        $data['applications_list'] = Application::where('application_status_id',1)->orderBy('created_at','desc')->take(5)->get();
        $data['activities'] = Notification::orderBy('id','desc')->take(5)->get();
        $data['application_count'] = Application::where('application_status_id',1)->where('created_at', '>=', $startDate)->count();
        $data['application_enrolled_count'] = Application::where('application_status_id',1)->where('created_at', '>=', $startDate)->where('status',11)->count();
        $data['total_application'] = Application::where('application_status_id',1)->count();
        $data['total_interviewed_passed'] = Application::where('application_status_id',1)->where('status',4)->count();
        $data['total_enrolled'] = Application::where('application_status_id',1)->where('status',11)->count();
        $data['total_ongoing'] = Application::where('application_status_id',1)->where('status',2)->count();
        $data['processing_data'] = $data['total_enrolled'].','.$data['total_ongoing'].','.$data['total_interviewed_passed'];
        return view('dashboard/index',$data);
    }

    public function login(){
        $data['page_title'] = 'User | Login';
        return view('authpanel/login',$data);
    }
    //student login
    public function student_login(){
        $data['page_title'] = 'Student | Login';
        return view('authpanel/student_login',$data);
    }
    //student register
    public function student_register(){
        $data['page_title'] = 'Student | Login';
        return view('authpanel/student_register',$data);
    }
    //student register post
    public function student_register_post(Request $request){
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
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
        $user->role = 'student';
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->slug = Str::slug($request->name,'-');
        $user->password = Hash::make($request->password);
        $user->save();
        Session::flash('success','Successfully Registered');
        return redirect('student-register');
    }
    //get notification
    public function get_notification_count(){
        $count = Notification::where('is_view',0)->where('user_id',Auth::user()->id)->count();
        $data['result'] = array(
            'key'=>200,
            'val'=>$count
        );
        return response()->json($data,200);
    }
    //get my notification
    public function get_my_notification(){
        $notify = Notification::where('user_id',Auth::user()->id)->orderBy('id','desc')->take(15)->get();
        $select = '';
        if($notify){
            foreach($notify as $key=>$row){
                if($row->is_view==0){
                    $select .= '<div class="tr-bg dropdown-item">';
                }else{
                    $select .= '<div class="dropdown-item">';
                }
                $select .= '<div class="media server-log">';
                    $select .= '<img src="'.asset($row->creator_image).'" class="img-fluid me-2" alt="avatar">';
                    $select .= '<div class="media-body">';
                        $select .= '<div class="data-info">';
                            $select .= '<h6 class="">'.$row->creator_name.'</h6>';
                            $select .= '<a href="'.url($row->slug).'"><p>'.$row->description.'</p></a>';
                            $select .= '<p class="">'.Service::timeLeft($row->create_date).'</p>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</div>';
            $select .= '</div>';
            }
            //update notification first
            $update = Notification::where('user_id',Auth::user()->id)->update(['is_view'=>1]);
            $data['result'] = array(
                'key'=>200,
                'val'=>$select
            );
            return response()->json($data,200);
        }
    }
    //all my notification
    public function get_all_my_notification(){
        if(!Auth::check()){
            Session::flash('error','Login First Then See Notification List!');
            return redirect('login');
        }
        $data['page_title'] = 'Archive Campus | List';
        $data['settings'] = true;
        $data['my_notifications'] = true;
        $data['all_data'] = Notification::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(15);
        return view('home/notification',$data);
    }
    //all my notification
    public function show_all_activity(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First Then See Notification List!');
            return redirect('login');
        }
        $data['page_title'] = 'Archive Campus | List';
        $data['page_title'] = 'Show All Activity';
        $data['settings'] = true;
        $data['show_activities'] = true;
        //start filtering

        $get_role = $request->role;
        $get_user_id = $request->user_id;
        $get_from_date = $request->from_date;
        $get_to_date = $request->to_date;
        $get_application_id = $request->application_id;

        Session::put('get_role',$get_role);
        Session::put('get_user_id',$get_user_id);
        Session::put('get_from_date',$get_from_date);
        Session::put('get_to_date',$get_to_date);
        Session::put('get_application_id',$get_application_id);

        $data['all_data'] = Notification::query()
        ->when($request->get('from_date') && $request->get('to_date'), function ($query) use ($request) {
            $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $toDate = date('Y-m-d 23:59:59', strtotime($request->to_date));
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        })
        ->when($get_user_id, function ($query, $get_user_id) {
            return $query->where('create_by',$get_user_id);
        })
        ->when($get_application_id, function ($query, $get_application_id) {
            return $query->where('application_id',$get_application_id);
        })
        ->orderBy('created_at','desc')
        ->paginate(15)
        ->appends([
            'role'=>$get_role,
            'user_id' => $get_user_id,
            'from_date' => $get_from_date,
            'to_date' => $get_to_date,
            'application_id' => $get_application_id,
        ]);
        $data['get_role'] = Session::get('get_role');
        $data['get_user_id'] = Session::get('get_user_id');
        $data['get_from_date'] = Session::get('get_from_date');
        $data['get_to_date'] = Session::get('get_to_date');
        $data['get_application_id'] = Session::get('get_application_id');
        $data['user_role'] = Service::get_admin_roles();
        if($get_role){
            $data['user_list'] = User::where('role',$get_role)->get();
        }else{
            $data['user_list'] = User::where('role','!=','agent')->where('role','!=','student')->get();
        }
        return view('dashboard/all_activity',$data);
    }
    public function get_user_by_role($role=NULL){
        $users = User::where('role',$role)->get();
        $select = '';
        $select .= '<option value="">Select Role</option>';
        foreach($users as $user){
            $select .= '<option value="'.$user->id.'">'.$user->name.'</option>';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$select
        );
        return response()->json($data,200);
    }
    public function reset_user_activity_list(){
        Session::put('get_role','');
        Session::put('get_user_id','');
        Session::put('get_from_date','');
        Session::put('get_to_date','');
        return redirect('show-all-activity');
    }
    public function random_check(){
        $dd = Service::get_random_str_number();
        return $dd;
    }

}
