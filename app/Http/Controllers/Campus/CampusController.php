<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campus\CampusEditRequest;
use Illuminate\Http\Request;
use App\Models\Campus\Campus;
use App\Models\Campus\CampusContactPerson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Models\Setting\CompanySetting;
use App\Mail\forgotPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Traits\Service;
use App\Http\Requests\Campus\CampusRequest;
use App\Models\University\University;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class CampusController extends Controller{
    use Service;

    public function create(){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        //print_r(Auth::user());
        //check as super admin
        // if(Auth::user()->role !== 'admin' || Auth::user()->role !== 'adminManager'){
        //     Session::flash('error','Login as Super Admin Then Create Campus!');
        //     return redirect('login');
        // }
        $data['page_title'] = 'Campus | Create';
        $data['campus'] = true;
        $data['campus_add'] = true;
        $data['countries'] = Service::countries();
        $data['list_of_university'] = University::where('status',0)->get();
        return view('campus/create',$data);
    }
    public function store(CampusRequest $request){
        $campus = new Campus();
        $campus->country = $request->country;
        $campus->campus_name = $request->campus_name;
        $campus->university_id = $request->university_id;
        //slug create
        $campus->slug = Str::slug($campus->campus_name, '-');
        $campus->website = $request->website;
        $campus->monthly_living_cost = $request->monthly_living_cost;
        $campus->funds_requirements_for_visa = $request->funds_requirements_for_visa;
        $campus->application_fee = $request->application_fee;
        $campus->currency = $request->currency;
        $campus->is_lang_mendatory = $request->is_lang_mendatory;
        $campus->lang_requirements = $request->lang_requirements;
        $campus->institute_benifits = $request->institute_benifits;
        $campus->per_time_work_details = $request->per_time_work_details;
        $campus->scholarship_policy = $request->scholarship_policy;
        $campus->institute_important_notes = $request->institute_important_notes;
        //upload logo
        //update image if exists
        $campus_logo = $request->institute_logo;
        if ($request->hasFile('institute_logo')) {
            // if (File::exists(public_path('backend/images/company_logo/'.$company->company_logo))) {
            //     File::delete(public_path('backend/images/company_logo/'.$company->company_logo));
            // }
            $ext = $campus_logo->getClientOriginalExtension();
            $filename = $campus_logo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($campus_logo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/campus/campus_logo/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/campus/campus_logo/'.$filename));
            $campus->institute_logo = 'backend/images/campus/campus_logo/'.$filename;
        }
        //Institute Prospectus
        $institute_prospectus = $request->institute_prospectus;
        if ($request->hasFile('institute_prospectus')) {
            $ext = $institute_prospectus->getClientOriginalExtension();
            $doc_file_name = $institute_prospectus->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/campus/campus_prospectus/';
            Service::createDirectory($upload_path1);
            $request->file('institute_prospectus')->move(public_path('backend/images/campus/campus_prospectus/'), $doc_file_name);
            $campus->institute_prospectus = $upload_path1.$doc_file_name;
        }
        //Institute Course Pdf
        $institute_course_pdf = $request->institute_course_pdf;
        if ($request->hasFile('institute_course_pdf')) {
            $ext = $institute_course_pdf->getClientOriginalExtension();
            $doc_file_name = $institute_course_pdf->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/campus/institute_course_pdf/';
            Service::createDirectory($upload_path1);
            $request->file('institute_course_pdf')->move(public_path('backend/images/campus/institute_course_pdf/'), $doc_file_name);
            $campus->institute_course_pdf = $upload_path1.$doc_file_name;
        }
        $campus->save();
        //save company contact person
        $names = $request->input('name');
        $emails = $request->input('email');
        $phones = $request->input('phone');
        $alternative_phones = $request->input('alternate_phone');
        if(!empty($names)){
            foreach($names as $key=>$name){
                if(!empty($name) && !empty($emails[$key]) && !empty($phones[$key]) && !empty($alternative_phones[$key])){
                    $contact = new CampusContactPerson();
                    $contact->campus_id = $campus->id;
                    $contact->name = $name;
                    $contact->email = $emails[$key];
                    $contact->phone = $phones[$key];
                    $contact->alternate_phone = $alternative_phones[$key];
                    $contact->save();
                }

            }
        }
        Session::put('campus_id',$campus->id);
        Session::flash('success','Campus Data Saved Successfully!');
        return redirect('all-campus');

    }
    //edit campus
    public function edit($slug=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Campus!');
            return redirect('login');
        }
        //check as super admin
        // if(Auth::user()->role != 'admin' || Auth::user()->role != 'adminManager'){
        //     Session::flash('error','Login as Super Admin Then Create Campus!');
        //     return redirect('login');
        // }
        if(!$slug){
            Session::flash('error','Campus Url Not Found! Server Error');
            return redirect('all-campus');
        }
        $getCampus = Campus::where('slug',$slug)->first();
        if(!$getCampus){
            Session::flash('warning','Campus data Not Found! Server Error');
            return redirect('all-campus');
        }
        $data['page_title'] = 'Campus | Edit';
        $data['campus'] = true;
        $data['campus_all'] = true;
        $data['campus'] = $getCampus;
        $data['countries'] = Service::countries();
        $data['list_of_university'] = University::where('status',0)->get();
        $data['campus_contact_persons'] = CampusContactPerson::where('campus_id',$getCampus->id)->get();
        return view('campus/edit',$data);
    }
    //edit data post
    public function edit_data_post(CampusEditRequest $request){
        $campus = Campus::where('id',$request->campus_id)->first();
        if(!$campus){
            Session::flash('warning','Campus data Not Found! Server Error');
            return redirect('all-campus');
        }
        $campus->country = $request->country;
        $campus->university_id = $request->university_id;
        $campus->campus_name = $request->campus_name;
        $campus->website = $request->website;
        $campus->monthly_living_cost = $request->monthly_living_cost;
        $campus->funds_requirements_for_visa = $request->funds_requirements_for_visa;
        $campus->application_fee = $request->application_fee;
        $campus->currency = $request->currency;
        $campus->is_lang_mendatory = $request->is_lang_mendatory;
        $campus->lang_requirements = $request->lang_requirements;
        $campus->institute_benifits = $request->institute_benifits;
        $campus->per_time_work_details = $request->per_time_work_details;
        $campus->scholarship_policy = $request->scholarship_policy;
        $campus->institute_important_notes = $request->institute_important_notes;
        //upload logo
        //update image if exists
        $campus_logo = $request->institute_logo;
        if ($request->hasFile('institute_logo')) {
            if (File::exists(public_path($campus->institute_logo))) {
                File::delete(public_path($campus->institute_logo));
            }
            $ext = $campus_logo->getClientOriginalExtension();
            $filename = $campus_logo->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(1100, 99999).'.'.$ext;
            $image_resize = Image::make($campus_logo->getRealPath());
            $image_resize->resize(200, 200);
            $upload_path = 'backend/images/campus/campus_logo/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/campus/campus_logo/'.$filename));
            $campus->institute_logo = 'backend/images/campus/campus_logo/'.$filename;
        }
        //Institute Prospectus
        $institute_prospectus = $request->institute_prospectus;
        if ($request->hasFile('institute_prospectus')) {
            if (File::exists(public_path($campus->institute_prospectus))) {
                File::delete(public_path($campus->institute_prospectus));
            }
            $ext = $institute_prospectus->getClientOriginalExtension();
            $doc_file_name = $institute_prospectus->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/campus/campus_prospectus/';
            Service::createDirectory($upload_path1);
            $request->file('institute_prospectus')->move(public_path('backend/images/campus/campus_prospectus/'), $doc_file_name);
            $campus->institute_prospectus = $upload_path1.$doc_file_name;
        }
        //Institute Course Pdf
        $institute_course_pdf = $request->institute_course_pdf;
        if ($request->hasFile('institute_course_pdf')) {
            if (File::exists(public_path($campus->institute_course_pdf))) {
                File::delete(public_path($campus->institute_course_pdf));
            }
            $ext = $institute_course_pdf->getClientOriginalExtension();
            $doc_file_name = $institute_course_pdf->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/campus/institute_course_pdf/';
            Service::createDirectory($upload_path1);
            $request->file('institute_course_pdf')->move(public_path('backend/images/campus/institute_course_pdf/'), $doc_file_name);
            $campus->institute_course_pdf = $upload_path1.$doc_file_name;
        }
        $campus->save();
        //delete company contact list first
        $getPersons = CampusContactPerson::where('campus_id',$campus->id)->get();
        if($getPersons){
            foreach($getPersons as $row){
                $delete = CampusContactPerson::where('id',$row->id)->delete();
            }
        }
        //save company contact person
        $names = $request->input('name');
        $emails = $request->input('email');
        $phones = $request->input('phone');
        $alternative_phones = $request->input('alternate_phone');
        if(!empty($names)){
            foreach($names as $key=>$name){
                if(!empty($name) && !empty($emails[$key]) && !empty($phones[$key]) && !empty($alternative_phones[$key])){
                    $contact = new CampusContactPerson();
                    $contact->campus_id = $campus->id;
                    $contact->name = $name;
                    $contact->email = $emails[$key];
                    $contact->phone = $phones[$key];
                    $contact->alternate_phone = $alternative_phones[$key];
                    $contact->save();
                }

            }
        }
        Session::put('campus_id',$campus->id);
        Session::flash('success','Campus Data Successfully Updated!');
        return redirect('all-campus');
    }
    public function view_campus($slug=NULL){
        $data['page_title'] = 'Campus | Details';
        $data['campus'] = true;
        $data['campus_all'] = true;
        $data['campus_data'] = Campus::where('slug',$slug)->first();
        if(!$data['campus_data']){
            Session::flash('warning','Campus Data Not Found! Server Error!');
            return redirect('all-campus');
        }
        $data['campus_contact_persons'] = CampusContactPerson::where('campus_id',$data['campus_data']->id)->get();
        return view('campus/details',$data);
    }
    public function all(){
        $data['page_title'] = 'Campus | List';
        $data['campus'] = true;
        $data['campus_all'] = true;
        $data['campuses'] = Campus::where('active',1)->orderBy('id','desc')->paginate(9);
        $data['campus_id'] = Session::get('campus_id');
        return view('campus/all',$data);
    }
    public function archive(){
        $data['page_title'] = 'Archive Campus | List';
        $data['campus'] = true;
        $data['campus_archive'] = true;
        $data['campuses'] = Campus::where('active',0)->orderBy('id','desc')->paginate(9);
        $data['campus_id'] = Session::get('campus_id');
        return view('campus/archive',$data);
    }
    public function change_status(Request $request){
        $campusData = Campus::where('id',$request->campus_id)->first();
        if(!$campusData){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Campus Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        if($campusData->active==1){
            $update = Campus::where('id',$campusData->id)->update(['active'=>$request->active]);
        }else{
            $update = Campus::where('id',$campusData->id)->update(['active'=>$request->active]);
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>'Status Changed Successfully!'
        );
        return response()->json($data,200);
    }
    public function delete_campus($id=NULL){
        $campusData = Campus::where('id',$id)->first();
        if(!$campusData){
            Session::flash('warning','Campus Not Found! Server Error!');
            return redirect('all-campus');
        }
        $update = Campus::where('id',$campusData->id)->update(['active'=>0]);
        Session::put('campus_id',$campusData->id);
        Session::flash('success','Campus Archived Successfully!');
        return redirect('all-campus');
    }
    //university
    public function universities($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Create Course Level!');
            return redirect('login');
        }
        //check as super admin
        if(Auth::user()->role != 'admin'){
            Session::flash('error','Login as Super Admin Then Create Course Level!');
            return redirect('login');
        }
        $data['return_university_id'] = Session::get('university_id');
        $data['page_title'] = 'University | Create';
        $data['campus'] = true;
        $data['university'] = true;
        $data['university_list'] = University::orderBy('id','desc')->paginate(15);
        if($id){
            $data['university_data'] = University::where('id',$id)->first();
        }
        Session::forget('university_id');
        return view('campus/university',$data);
    }
    //university data post 
    public function university_store(Request $request){
        $request->validate([
            'title' => 'required',
        ]);
        $universityId = $request->university_id;
        if($universityId){
            $universityData = University::where('id',$universityId)->first();
        }else{
            $universityData = new University();
        }
        $universityData->title = $request->title;
        $universityData->save();
        Session::put('university_id',$universityData->id);
        Session::flash('success',(!empty($universityId))?'University Data Upadted!':'University Data Saved!');
        return redirect('universities');
    }
    public function university_status_change(Request $request){
        $university = University::where('id',$request->university_id)->first();
        if(!$university){
            $data['result'] = array(
                'key'=>101,
                'val'=>'University Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($university->status==1){
            $update = University::where('id',$university->id)->update(['status'=>$request->status]);
            $msg = 'University Activated';
        }else{
            $update = University::where('id',$university->id)->update(['status'=>$request->status]);
            $msg = 'University Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    
}
