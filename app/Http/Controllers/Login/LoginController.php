<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
Use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Login\LoginRequest;
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

class LoginController extends Controller
{
    public function user_login(LoginRequest $request){
        if($request->has('remember_me')){
            Session::put('user_email',$request->input('email'));
            Session::put('user_password',$request->input('password'));
            Session::put('rememberMe',$request->input('remember_me'));
        }else{
            Session::forget('user_email');
            Session::forget('user_password');
            Session::forget('rememberMe');
        }
        try{
            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
                if(Auth::user()->active==1){
                    if(Auth::user()->role=='student'){
                        return redirect('student-portal');
                    }
                    if(Auth::user()->role=='agent'){
                        return redirect('agent-applications');
                    }
                    if(Auth::user()->role=='subAgent'){
                        return redirect('sub-agent-applications');
                    }
                    return redirect('/');
                }else{
                    Auth::logout();
                    Session::flash('warning', 'Opps! You don,t have any permission to login this system!');
                    return Redirect::back();
                }
            }
            else {
                Session::flash('error', 'Email and Password Not Matched!');
                return Redirect::back();
            }
        } catch(\Exception $e){
            Session::flash('error', 'Oh Someting went wrong in server! '.$e->getMessage());
            return Redirect::back();
        }
    }
    //signout
    public function sign_out(){
        Auth::logout();
        Session::flash('success', 'Logout Successfully!');
        return redirect('login');
    }
    //reset password
    public function reset_password(){
        $data['page_title'] = 'User | Reset Password';
        return view('authpanel/reset_password',$data);
    }
    //reset password post
    public function reset_password_post(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

          $details = [
            'create_link' => url('reset-password-form/'.$token),
            'settings' => CompanySetting::where('id',1)->first(),
            //'password' => $make_password,
        ];
        //mail send
        Mail::to($request->email)->send(new forgotPasswordMail($details));
        Session::flash('success','We have e-mailed your password reset link!');
        return redirect('reset-password');
    }
    //reset password form
    public function reset_password_form($token){
        $data['page_title'] = 'User | Reset Password Form';
        $data['token'] = $token;
        return view('authpanel/reset_password_form',$data);
    }
    //reset password form post
    public function reset_password_form_post(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where([
                              'email' => $request->email,
                              'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('login')->with('success', 'Your password has been changed!');
    }

}
