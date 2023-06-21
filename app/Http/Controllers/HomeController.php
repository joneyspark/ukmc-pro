<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Notification\Notification;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
        $data['page_title'] = 'Dashboard';
        $data['dashboard'] = true;
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

}
