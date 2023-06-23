<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\CompanySetting;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Traits\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller{
    use Service;

    public function company_settings(){
        if(!Auth::check()){
            Session::flash('error','Login First! Then See Company Setting!');
            return redirect('login');
        }
        $data['page_title'] = 'Company / Settings';
        $data['settings'] = true;
        $data['company_settings'] = true;
        if(Auth::user()->role=='agent'){
            $data['company_data'] = CompanySetting::where('company_id',Auth::user()->company_id)->first();
        }else{
            $data['company_data'] = CompanySetting::where('id',1)->first();
        }
        $data['countries'] = Service::countries();
        return view('setting/company_setting',$data);
    }
    //company setting post
    public function company_setting_post(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First! Then See Company Setting!');
            return redirect('login');
        }
        if(Auth::user()->role=='admin'){
            $company = CompanySetting::where('id',1)->first();
            if(!$company){
                $company = new CompanySetting();
            }
        }
        if(Auth::user()->role=='agent'){
            $company = CompanySetting::where('company_id',Auth::user()->company_id)->first();
            if(!$company){
                $company = new CompanySetting();
            }
        }
        $company->company_name = $request->company_name;
        $company->address = $request->address;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->state = $request->state;
        $company->city = $request->city;
        $company->country = $request->country;
        $company->zip_code = $request->zip_code;
        //logo upload
        //update image if exists
        $company_logo = $request->company_logo;
        if ($request->hasFile('company_logo')) {
            if (File::exists(public_path('backend/images/company_logo/'.$company->company_logo))) {
                File::delete(public_path('backend/images/company_logo/'.$company->company_logo));
            }
            $extArr = array("jpg","png","jpeg");
            $ext = $company_logo->getClientOriginalExtension();
            if(in_array($ext, $extArr)){
                $filename = $company_logo->getClientOriginalName();
                $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
                $image_resize = Image::make($company_logo->getRealPath());
                $image_resize->resize(34, 34);
                $upload_path = 'backend/images/company_logo/';
                Service::createDirectory($upload_path);
                $image_resize->save(public_path('backend/images/company_logo/'.$filename));
                $company->company_logo = 'backend/images/company_logo/'.$filename;
            }else{
                Session::flash('error','Image Type Not Support! Only support jpg,png,jpeg');
                return redirect('company-settings');
            }
        }
        //update image if exists
        $favicon = $request->favicon;
        if ($request->hasFile('favicon')) {
            if (File::exists(public_path('backend/images/favicon/'.$company->favicon))) {
                File::delete(public_path('backend/images/favicon/'.$company->favicon));
            }
            $extArr = array("ico","png");
            $ext = $favicon->getClientOriginalExtension();
            if(in_array($ext, $extArr)){
                $filename = $favicon->getClientOriginalName();
                $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
                $image_resize = Image::make($favicon->getRealPath());
                $image_resize->resize(15, 15);
                $upload_path = 'backend/images/favicon/';
                Service::createDirectory($upload_path);
                $image_resize->save(public_path('backend/images/favicon/'.$filename));
                $company->favicon = 'backend/images/favicon/'.$filename;
            }else{
                Session::flash('error','Favicon Type Not Support! Only support .ico,.png');
                return redirect('company-settings');
            }
        }
        //update company banner image if exists
        $company_banner = $request->company_banner;
        if ($request->hasFile('company_banner')) {
            if (File::exists(public_path('backend/images/company_banner/'.$company->company_banner))) {
                File::delete(public_path('backend/images/company_banner/'.$company->company_banner));
            }
            $extArr = array("jpg","png","jpeg");
            $ext = $company_banner->getClientOriginalExtension();
            if(in_array($ext, $extArr)){
                $filename = $company_banner->getClientOriginalName();
                $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
                $image_resize = Image::make($company_banner->getRealPath());
                $image_resize->resize(800, 300);
                $upload_path = 'backend/images/company_banner/';
                Service::createDirectory($upload_path);
                $image_resize->save(public_path('backend/images/company_banner/'.$filename));
                $company->company_banner = 'backend/images/company_banner/'.$filename;
            }else{
                Session::flash('error','Image Type Not Support! Only support jpg,png,jpeg');
                return redirect('company-settings');
            }

        }
        $company->website = $request->website;
        $company->crm_website = $request->crm_website;
        $company->contact_us = $request->contact_us;
        $company->facebook = $request->facebook;
        $company->instagram = $request->instagram;
        $company->linkedin = $request->linkedin;
        $company->twitter = $request->twitter;
        $company->youtube = $request->youtube;
        $company->pinterest = $request->pinterest;
        $company->whatsapp = $request->whatsapp;
        $company->privacy_policy = $request->privacy_policy;
        $company->terms_and_condition = $request->terms_and_condition;
        if(Auth::user()->role=='agent'){
            $company->company_id = Auth::user()->company_id;
        }else{
            $company->company_id = 0;
        }
        $company->contact_person_name = $request->contact_person_name;
        $company->contact_person_phone = $request->contact_person_phone;
        $company->contact_person_email = $request->contact_person_email;
        $company->contact_person_alternative = $request->contact_person_alternative;

        $company->save();
        Session::flash('success','Company Data Saved Successfully!');
        return redirect('company-settings');
    }
    
}
