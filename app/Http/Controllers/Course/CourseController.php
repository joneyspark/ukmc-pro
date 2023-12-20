<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseEditRequest;
use App\Models\Agent\Company;
use App\Models\Application\Application;
use App\Models\Application\ApplicationStatus;
use App\Models\Campus\Campus;
use App\Models\Course\AttendenceConfirmation;
use App\Models\Course\ClassSchedule;
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
use App\Models\Course\CourseSubject;
use App\Models\User;
use  Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;
use MeiliSearch\Client;
use Illuminate\Support\Str;

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
            $data['intake_data'] = CourseIntake::where('id',$intake_id)->first();
        }
        $data['intakes_data'] = Service::get_intake_with_next_year();
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
    public function course_subject($id=NULL,$edit=NULL,$subject_id=NULL){
        $data['page_title'] = 'Course | Subject';
        $data['intake_id'] = $id;
        $data['subject_id'] = $subject_id;
        if($subject_id){
            $data['subject_data'] = CourseSubject::where('id',$subject_id)->first();
        }
        $data['subjects'] = CourseSubject::where('course_intake_id',$id)->orderBy('id','desc')->paginate(15);
        $data['course'] = true;
        return view('course/subject',$data);
    }
    public function course_subject_data_post(Request $request){
        $request->validate([
            'title'=>'required',
            'duration'=>'required',
        ]);
        $get_intake = CourseIntake::where('id',$request->intake_id)->first();
        if($request->subject_id){
            $subject = CourseSubject::where('id',$request->subject_id)->first();
        }else{
            $subject = new CourseSubject();
        }
        $subject->course_id = $get_intake->course_id;
        $subject->course_intake_id = $get_intake->id;
        $subject->title = $request->title;
        $subject->description = $request->description;
        $subject->duration = $request->duration;
        $subject->save();
        Session::flash('success','Subject Data Updated');
        return redirect('course/subject/'.$get_intake->id);
    }
    public function subject_intake_status_change(Request $request){
        $subjectData = CourseSubject::where('id',$request->subject_id)->first();
        if(!$subjectData){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Course Subject Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($subjectData->status==1){
            $subjectData->status = 0;
            $subjectData->save();
            $msg = 'Subject Activated';
        }else{
            $subjectData->status = 1;
            $subjectData->save();
            $msg = 'Subject Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    public function subject_schedule($id=NULL,$edit=NULL,$schedule_id=NULL){
        $data['page_title'] = 'Subject | Schedule';
        $data['course'] = true;
        if($id){
            $data['course_subject'] = CourseSubject::where('id',$id)->first();
            $data['course_intake'] = CourseIntake::where('id',$data['course_subject']->course_intake_id)->first();
        }
        if(!empty($schedule_id)){
            $data['schedule_data'] = ClassSchedule::where('id',$schedule_id)->first();
        }
        $data['main_subject_id'] = $id;
        $data['schedule_list'] = ClassSchedule::where('subject_id',$id)->orderBy('id','desc')->paginate(15);
        return view('course/subject/schedule',$data);
    }
    //subject schedule data store
    public function subject_schedule_data_post(Request $request){
        $request->validate([
            'title'=>'required',
            'schedule_date'=>'required',
            'time_from'=>'required',
            'time_to'=>'required',
        ]);
        if($request->schedule_id){
            $schedule = ClassSchedule::where('id',$request->schedule_id)->first();
        }else{
            $schedule = new ClassSchedule();
        }
        $schedule->course_id = $request->course_id;
        $schedule->intake_id = $request->intake_id;
        $schedule->subject_id = $request->subject_id;
        $schedule->intake_date = $request->intake_date;
        $schedule->title = $request->title;
        $schedule->schedule_date = $request->schedule_date;
        $schedule->time_from = $request->time_from;
        $schedule->time_to = $request->time_to;
        if(!$request->schedule_id){
            $slug = Str::slug($request->title,'-');
            $schedule->slug = $slug.Service::randomString();
        }
        $schedule->save();
        Session::flash('success','Class Schedule Data Updated');
        return redirect('subject/class-schedule/'.$schedule->subject_id);
    }
    public function schedule_status_change(Request $request){
        $scheduleData = ClassSchedule::where('id',$request->schedule_id)->first();
        if(!$scheduleData){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Subject Schedule Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($scheduleData->is_done==1){
            $scheduleData->is_done = 0;
            $scheduleData->save();
            $msg = 'Schedule Revert Again';
        }else{
            $scheduleData->is_done = 1;
            $scheduleData->save();
            $msg = 'Schedule Complete';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    //schedule details
    public function schedule_details($id=NULL){
        $data['page_title'] = 'Subject | Schedule Details';
        $data['course'] = true;
        $data['app_data'] = Application::where('id',1)->first();
        $data['details'] = ClassSchedule::with(['course','subject'])->where('id',$id)->first();
        //dd($data['details']);
        return view('course/subject/schedule_details',$data);
    }
    public function attendence_details($id=NULL){
        $data['page_title'] = 'Subject | Attendence Conformation Page';
        $data['course'] = true;
        $data['details'] = ClassSchedule::with(['course','subject'])->where('slug',$id)->first();
        //dd($data['details']);
        return view('course/subject/attendence_details',$data);
    }
    public function attendence_confirmation(Request $request){
        $request->validate([
            'application_id'=>'required',
        ]);
        if(Session::get('check_attend')=='12345678'){
            Session::flash('warning','You Already Attented Of this Of This Class Schedule! If you have some attending issue then call to administrator!');
            return redirect()->back();
        }
        $get_app_data = Application::where('id',$request->application_id)->first();
        if(!$get_app_data){
            Session::flash('error','Application Data Not Found');
            return redirect()->back();
        }
        $checkSchedule = ClassSchedule::where('id',$request->class_schedule_id)->first();
        if(!$checkSchedule){
            Session::flash('error','Schedule Data Not Found! Server Error!');
            return redirect()->back();
        }
        if($get_app_data->intake != $checkSchedule->intake_date){
            Session::flash('error','You Don,t Have Any Permission To Make Attendence Of this Course Schedule');
            return redirect()->back();
        }
        $checkAttendence = AttendenceConfirmation::where('class_schedule_id',$request->class_schedule_id)->where('application_id',$request->application_id)->first();
        if($checkAttendence){
            Session::flash('error','You Already Attented Of this Of This Class Schedule! If you want to change then call to administrator!');
            return redirect()->back();
        }
        $attendence = new AttendenceConfirmation();
        $attendence->class_schedule_id = $checkSchedule->id;
        $attendence->application_id = $get_app_data->id;
        $attendence->course_id = $checkSchedule->course_id;
        $attendence->intake_id = $checkSchedule->intake_id;
        $attendence->subject_id = $checkSchedule->subject_id;
        $attendence->intake_date = $checkSchedule->intake_date;
        $attendence->application_status = 1;
        $attendence->status = 0;
        $attendence->save();
        Session::put('check_attend','12345678');
        Session::flash('success','Attendence Complete!');
        return redirect()->back();
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
    //get intake list
    public function get_intake_list($intake_id=NULL){
        $get_intake_info = CourseIntake::where('id',$intake_id)->first();
        if(!$get_intake_info){
            $data['result'] = array(
                'key'=>101,
                'val'=>$intake_id
            );
            return response()->json($data,200);
        }
        $select = '';
        $list = CourseIntake::where('id','!=',$intake_id)->where('course_id',$get_intake_info->course_id)->orderBy('id','desc')->get();
        $select .= '<option value="" selected>Choose...</option>';
        foreach($list as $row){
            $select .= '<option value="'.$row->id.'" selected>'.$row->title.'</option>';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$select
        );
        return response()->json($data,200);
    }
    public function transfer_subject_from_another_intake(Request $request){
        $request->validate([
            'another_intake'=>'required',
        ]);
        $current_intake = CourseIntake::where('id',$request->current_intake)->first();
        if(!$current_intake){
            Session::flash('error','Current Course Intake Not Found');
            return redirect('all-course');
        }
        $course_subjects = CourseSubject::where('course_intake_id',$request->another_intake)->where('status',0)->get();
        if(!$course_subjects){
            Session::flash('error','Course Subject Not Found Of This Intake!');
            return redirect('course/subject/'.$current_intake->id);
        }
        foreach($course_subjects as $row){
            $subject = new CourseSubject();
            $subject->course_id = $current_intake->course_id;
            $subject->course_intake_id = $current_intake->id;
            $subject->title = $row->title;
            $subject->description = $row->description;
            $subject->duration = $row->duration;
            $subject->save();
        }
        Session::flash('error','Successfully Transfered Subject To Current Intake');
        return redirect('course/subject/'.$current_intake->id);
    }
}
