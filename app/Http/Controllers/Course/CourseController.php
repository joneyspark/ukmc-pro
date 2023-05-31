<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseCreateRequest;
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
use App\Models\Course\CourseLevel;

class CourseController extends Controller{
    use Service;
    public function create(){
        $data['page_title'] = 'Course | Create';
        $data['course'] = true;
        $data['course_add'] = true;
        $data['campus_list'] = Campus::where('active',1)->orderBy('id','desc')->get();
        $data['categories'] = CourseCategories::where('status',0)->get();
        $data['course_levels'] = CourseLevel::where('status',0)->get();
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
        $data['page_title'] = 'Course | List';
        
        $data['return_course_id'] = Session::get('course_id');
        $data['campus_list'] = Campus::where('active',1)->get();
        $data['course'] = true;
        $data['course_all'] = true;
        Session::forget('course_id');
        $campus_name = $request->serach;
        if($request->ajax()){
            //meiisearch work here
            $data['courses'] = Course::query()
            ->when($request->status, function($q)use($request){
                $q->where('campus_id',$request->status);
            })
            ->orderBy('id','desc')
            ->paginate(1);
            return view('ajax.Course.list', $data);
        }
        $data['courses'] = Course::orderBy('id','desc')->paginate(1);
        return view('course.all',$data);
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
        return view('course/details',$data);
    }
}
