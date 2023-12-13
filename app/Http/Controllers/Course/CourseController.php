<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseEditRequest;
use App\Models\Agent\Company;
use App\Models\Application\Application;
use App\Models\Application\ApplicationStatus;
use App\Models\Campus\Campus;
use App\Models\Course\Course;
use App\Models\Course\CourseAdditional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Traits\Service;
Use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use App\Models\Course\CourseCategories;
use App\Models\course\CourseIntake;
use App\Models\Course\CourseLevel;
use App\Models\User;
use  Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;
use MeiliSearch\Client;

class CourseController extends Controller{
    use Service;
    public function create(){
        $data['page_title'] = 'Course | Create';
        $data['course'] = true;
        $data['course_add'] = true;
        $data['campus_list'] = Campus::where('active',1)->orderBy('id','desc')->get();
        $data['categories1'] = CourseCategories::where('status',0)->get();
        $data['course_levels1'] = CourseLevel::where('status',0)->get();
        return view('course/create',$data);
    }
    public function store(CourseCreateRequest $request){
        $course = new Course();
        $course->campus_id = $request->campus_id;
        $course->course_name = $request->course_name;
        $course->category_id = $request->category_id;
        $course->course_level_id = $request->course_level_id;
        $course->course_duration = $request->course_duration;
        $course->course_fee = $request->course_fee;
        $course->international_course_fee = $request->international_course_fee;
        //$course->course_intake = $request->course_intake;
        $course_intake_str = '';
        $arr = json_decode($request->course_intake,true);
        if(is_array($arr)){
            foreach($arr as $row){
                $course_intake_str .= $row['value'].',';
            }
        }else{
            echo 'Not array';
        }
        $course->course_intake = $course_intake_str;
        $course->awarding_body = $request->awarding_body;
        $course->is_lang_mendatory = $request->is_lang_mendatory;
        $course->lang_requirements = $request->lang_requirements;
        $course->per_time_work_details = $request->per_time_work_details;
        $course->addtional_info_course = $request->addtional_info_course;
        //course prospectus
        $course_prospectus = $request->course_prospectus;
        if ($request->hasFile('course_prospectus')) {

            $ext = $course_prospectus->getClientOriginalExtension();
            $doc_file_name = $course_prospectus->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/course/course_prospectus/';
            Service::createDirectory($upload_path1);
            $request->file('course_prospectus')->move(public_path('backend/images/course/course_prospectus/'), $doc_file_name);
            $course->course_prospectus = $upload_path1.$doc_file_name;
        }
        //course module pdf
        $course_module = $request->course_module;
        if ($request->hasFile('course_module')) {

            $ext = $course_module->getClientOriginalExtension();
            $doc_file_name = $course_module->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/course/course_module/';
            Service::createDirectory($upload_path1);
            $request->file('course_module')->move(public_path('backend/images/course/course_module/'), $doc_file_name);
            $course->course_module = $upload_path1.$doc_file_name;
        }
        //slug create
        $url_modify = Service::slug_create($request->course_name);
        $checkSlug = Course::where('slug', 'LIKE', '%' . $url_modify . '%')->count();
        if ($checkSlug > 0) {
            $new_number = $checkSlug + 1;
            $new_slug = $url_modify . '-' . $new_number;
            $course->slug = $new_slug;
        } else {
            $course->slug = $url_modify;
        }
        $course->create_by = Auth::user()->id;
        $course->save();
        //additional data saved
        $additionals = $request->course_additionals;
        if($additionals){
            foreach($additionals as $row){
                $additional = new CourseAdditional();
                $additional->course_id = $course->id;
                $additional->additional = $row;
                $additional->save();
            }
        }
        Session::put('course_id',$course->id);
        Session::flash('success','Course Data Saved Successfully!');
        return redirect('all-course');
    }
    public function all(Request $request){
        //$c = Course::search('K')->paginate(2);
        //dd($c);
        $data['page_title'] = 'Course | List';
        $data['return_course_id'] = Session::get('course_id');
        $data['campus_list'] = Campus::where('active', 1)->get();
        $data['course'] = true;
        $data['course_all'] = true;
        Session::forget('course_id');
        $query = $request->course_name;
        $campus_id = $request->campus_id;
        Session::put('get_campus_id', $campus_id);
        Session::put('get_course_name', $query);
        $client = new Client('http://localhost:7700');
        $indexName = 'courses';
        $index = $client->index($indexName);
        $currentSettings = $index->getSettings();
        $sortableAttributes = $currentSettings['sortableAttributes'];

        if (!in_array('id', $sortableAttributes)) {
            $sortableAttributes[] = 'id';
            $settings['sortableAttributes'] = $sortableAttributes;

            $index->updateSettings($settings);
        }
        $newSettings = [
            'filterableAttributes' => array_merge($currentSettings['filterableAttributes'], ['campus_id'])
        ];

        $index->updateSettings($newSettings);
        $courseSearch = Course::search($query, function ($ms, $q, $options) use ($request, $query, $campus_id) {
            $filter = [];
            if ($campus_id) {
                $filter[] = 'campus_id = ' . $campus_id;
            }
            $options['filter'] = $filter;
            $options['sort'] = ['id:desc'];
            return $ms->search($q, $options);
        });
        $data['courses'] = $courseSearch
        ->paginate(5)
        ->appends([
            'course_name' => $query,
            'campus_id' => $campus_id,
        ]);
        $data['get_campus_id'] = Session::get('get_campus_id');
        $data['get_course_name'] = Session::get('get_course_name');
        Session::put('current_url',URL::full());
        return view('course.all', $data);
    }
    //edit course
    public function edit($slug=NULL){
        $data['page_title'] = 'Course | Edit';

        $data['campus_list'] = Campus::where('active', 1)->get();
        $data['categories'] = CourseCategories::where('status',0)->get();
        $data['course_levels'] = CourseLevel::where('status',0)->get();
        $data['course_data'] = Course::where('slug',$slug)->first();
        $data['course'] = true;
        $data['course_all'] = true;
        $data['additionals'] = CourseAdditional::where('course_id',$data['course_data']->id)->get();
        return view('course.edit',$data);
    }
    //course edit data post
    public function edit_post(CourseEditRequest $request){
        $course = Course::where('slug',$request->slug)->first();
        if(!$course){
            Session::flash('error','Course Data Not Found!');
            return redirect('all-course');
        }
        $course->campus_id = $request->campus_id;
        $course->course_name = $request->course_name;
        $course->category_id = $request->category_id;
        $course->course_level_id = $request->course_level_id;
        $course->course_duration = $request->course_duration;
        $course->course_fee = $request->course_fee;
        $course->international_course_fee = $request->international_course_fee;
        //$course->course_intake = $request->course_intake;
        $course_intake_str = '';
        $arr = json_decode($request->course_intake,true);
        if(is_array($arr)){
            foreach($arr as $row){
                $course_intake_str .= $row['value'].',';
            }
        }else{
            echo 'Not array';
        }
        $course->course_intake = $course_intake_str;
        $course->awarding_body = $request->awarding_body;
        $course->is_lang_mendatory = $request->is_lang_mendatory;
        $course->lang_requirements = $request->lang_requirements;
        $course->per_time_work_details = $request->per_time_work_details;
        $course->addtional_info_course = $request->addtional_info_course;
        //course prospectus
        $course_prospectus = $request->course_prospectus;
        if ($request->hasFile('course_prospectus')) {
            if (File::exists(public_path($course->course_prospectus))) {
                File::delete(public_path($course->course_prospectus));
            }
            $ext = $course_prospectus->getClientOriginalExtension();
            $doc_file_name = $course_prospectus->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/course/course_prospectus/';
            Service::createDirectory($upload_path1);
            $request->file('course_prospectus')->move(public_path('backend/images/course/course_prospectus/'), $doc_file_name);
            $course->course_prospectus = $upload_path1.$doc_file_name;
        }
        //course module pdf
        $course_module = $request->course_module;
        if ($request->hasFile('course_module')) {
            if (File::exists(public_path($course->course_module))) {
                File::delete(public_path($course->course_module));
            }
            $ext = $course_module->getClientOriginalExtension();
            $doc_file_name = $course_module->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/course/course_module/';
            Service::createDirectory($upload_path1);
            $request->file('course_module')->move(public_path('backend/images/course/course_module/'), $doc_file_name);
            $course->course_module = $upload_path1.$doc_file_name;
        }
        $course->update_by = Auth::user()->id;
        $course->save();
        //additional data saved
        $additionals = $request->course_additionals;
        if($additionals){
            $getPrevios = CourseAdditional::where('course_id',$course->id)->get();
            if($getPrevios){
                foreach($getPrevios as $row){
                    $del = CourseAdditional::where('id',$row->id)->delete();
                }
            }
            foreach($additionals as $row){
                $additional = new CourseAdditional();
                $additional->course_id = $course->id;
                $additional->additional = $row;
                $additional->save();
            }
        }
        Session::put('course_id',$course->id);
        Session::flash('success','Course Data Updated Successfully!');
        if(!empty(Session::get('current_url'))){
            return redirect(Session::get('current_url'));
        }else{
            return redirect('all-course');
        }
    }
    //reset course list
    public function reset_course_list(){
        Session::forget('get_campus_id');
        Session::forget('get_course_name');
        Session::forget('course_id');
        return redirect('all-course');
    }
    //user status change
    public function course_status_chnage(Request $request){
        $courseData = Course::where('id',$request->course_id)->first();
        if(!$courseData){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Course Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($courseData->status==1){
            $courseData->status = 0;
            $courseData->save();
            $msg = 'Course Deactivated';
        }else{
            $courseData->status = 1;
            $courseData->save();
            $msg = 'Course Activated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    public function archive(){
        $data['page_title'] = 'Archived | Course';
        $data['course'] = true;
        $data['course_archive'] = true;
        return view('course/archive',$data);
    }
    public function course_details($slug=NULL){
        $data['page_title'] = 'Course | Details';
        $data['course'] = true;
        $data['course_all'] = true;
        $data['course_data'] = Course::where('slug',$slug)->first();
        return view('course/details',$data);
    }
    public function course_intake($id=NULL,$edit=NULL,$intake_id=NULL){
        $data['page_title'] = 'Course | Intake';
        $data['course'] = true;
        if($intake_id){
            $data['intake_data'] = CourseIntake::where('id',$id)->first();
        }
        $data['course_id'] = $id;
        $data['intakes'] = CourseIntake::where('course_id',$id)->orderBy('id','desc')->paginate(15);
        return view('course/intake',$data);
    }
    public function course_intake_post(Request $request){
        $request->validate([
            'title'=>'required',
            'intake_date'=>'required',
        ]);
        if($request->intake_id){
            $intake = CourseIntake::where('id',$request->intake_id)->first();
        }else{
            $intake = new CourseIntake();
        }
        $intake->title = $request->title;
        $intake->course_id = $request->course_id;
        $intake->intake_date = $request->intake_date;
        $intake->description = $request->description;
        $intake->save();
        Session::flash('success','Intake Data Updated');
        return redirect('course/intake/'.$intake->course_id);
    }
    public function course_subject(){
        $data['page_title'] = 'Course | Subject';
        $data['course'] = true;
        return view('course/subject',$data);
    }
    public function subject_schedule(){
        $data['page_title'] = 'Subject | Schedule';
        $data['course'] = true;
        return view('course/subject/schedule',$data);
    }
    public function attendance(){
        $data['page_title'] = 'Subject | Attendance';
        $data['course'] = true;
        return view('course/subject/attendence',$data);
    }
    public function attendance_report(Request $request){
        $data['page_title'] = 'Attendance | Report';
        $data['course'] = true;
        $data['course_attendance'] = true;
        return view('course/subject/report',$data);
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
    //intake status chnage
    public function change_intake_status(Request $request){
        $intakeData = CourseIntake::where('id',$request->intake_id)->first();
        if(!$intakeData){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Intake Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($intakeData->status==1){
            $intakeData->status = 0;
            $intakeData->save();
            $msg = 'Intake Activated';
        }else{
            $intakeData->status = 1;
            $intakeData->save();
            $msg = 'Intake Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
}
