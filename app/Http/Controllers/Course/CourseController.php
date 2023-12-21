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
use App\Models\Course\AttendNote;
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
use App\Models\Course\CourseIntake;
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
        $course_name = $request->course_name;
        $campus_id = $request->campus_id;
        Session::put('get_campus_id', $campus_id);
        Session::put('get_course_name', $course_name);

        $data['courses'] = Course::query()
        ->when($course_name, function ($query, $course_name) {
            return $query->where('course_name', 'like', '%' . $course_name . '%');
        })
        ->when($campus_id, function ($query, $campus_id) {
            return $query->where('campus_id',$campus_id);
        })
        ->orderBy('id','desc')
        ->paginate(15)
        ->appends([
            'course_name' => $course_name,
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
    public function attendance($id=NULL){
        $data['page_title'] = 'Subject | Attendance';
        $data['course'] = true;
        $getSchedule = ClassSchedule::where('id',$id)->first();
        if(!$getSchedule){
            Session::flash('error','Schedule Data Not Found!');
            return redirect()->back();
        }
        $data['schedule_id'] = $id;
        $data['applicants'] = Application::with(['applicant_attendence'])->where('course_id',$getSchedule->course_id)->where('intake',$getSchedule->intake_date)->where('status',11)->paginate(50);
        //dd($data['applicants']);
        return view('course/subject/attendence',$data);
    }
    public function present_call(Request $request){
        $request->validate([
            'application_id'=>'required',
            'schedule_id'=>'required',
        ]);

        $get_app_data = Application::where('id',$request->application_id)->first();
        if(!$get_app_data){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Application Data Not Found! Server Error'
            );
            return response()->json($data,200);
        }
        $checkSchedule = ClassSchedule::where('id',$request->schedule_id)->first();
        if(!$checkSchedule){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Schedule Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        if($get_app_data->intake != $checkSchedule->intake_date){
            $data['result'] = array(
                'key'=>101,
                'val'=>'This Student Not Enrolled In This Intake!'
            );
            return response()->json($data,200);
        }
        $attendence = AttendenceConfirmation::where('class_schedule_id',$request->schedule_id)->where('application_id',$request->application_id)->first();
        if($attendence){
            $attendence->application_status = 1;
            $attendence->save();
        }else{
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
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>'Attndence Complete!'
        );
        return response()->json($data,200);
    }
    public function absent_call(Request $request){
        $request->validate([
            'application_id'=>'required',
            'schedule_id'=>'required',
        ]);

        $get_app_data = Application::where('id',$request->application_id)->first();
        if(!$get_app_data){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Application Data Not Found! Server Error'
            );
            return response()->json($data,200);
        }
        $checkSchedule = ClassSchedule::where('id',$request->schedule_id)->first();
        if(!$checkSchedule){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Schedule Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        if($get_app_data->intake != $checkSchedule->intake_date){
            $data['result'] = array(
                'key'=>101,
                'val'=>'This Student Not Enrolled In This Intake!'
            );
            return response()->json($data,200);
        }
        $attendence = AttendenceConfirmation::where('class_schedule_id',$request->schedule_id)->where('application_id',$request->application_id)->first();
        if($attendence){
            $attendence->application_status = 2;
            $attendence->save();
        }else{
            $attendence = new AttendenceConfirmation();
            $attendence->class_schedule_id = $checkSchedule->id;
            $attendence->application_id = $get_app_data->id;
            $attendence->course_id = $checkSchedule->course_id;
            $attendence->intake_id = $checkSchedule->intake_id;
            $attendence->subject_id = $checkSchedule->subject_id;
            $attendence->intake_date = $checkSchedule->intake_date;
            $attendence->application_status = 2;
            $attendence->status = 0;
            $attendence->save();
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>'Absent!'
        );
        return response()->json($data,200);
    }
    public function leave_call(Request $request){
        $request->validate([
            'application_id'=>'required',
            'schedule_id'=>'required',
        ]);

        $get_app_data = Application::where('id',$request->application_id)->first();
        if(!$get_app_data){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Application Data Not Found! Server Error'
            );
            return response()->json($data,200);
        }
        $checkSchedule = ClassSchedule::where('id',$request->schedule_id)->first();
        if(!$checkSchedule){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Schedule Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        if($get_app_data->intake != $checkSchedule->intake_date){
            $data['result'] = array(
                'key'=>101,
                'val'=>'This Student Not Enrolled In This Intake!'
            );
            return response()->json($data,200);
        }
        $attendence = AttendenceConfirmation::where('class_schedule_id',$request->schedule_id)->where('application_id',$request->application_id)->first();
        if($attendence){
            $attendence->application_status = 3;
            $attendence->save();
        }else{
            $attendence = new AttendenceConfirmation();
            $attendence->class_schedule_id = $checkSchedule->id;
            $attendence->application_id = $get_app_data->id;
            $attendence->course_id = $checkSchedule->course_id;
            $attendence->intake_id = $checkSchedule->intake_id;
            $attendence->subject_id = $checkSchedule->subject_id;
            $attendence->intake_date = $checkSchedule->intake_date;
            $attendence->application_status = 3;
            $attendence->status = 0;
            $attendence->save();
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>'Leave of Absence!'
        );
        return response()->json($data,200);
    }
    public function get_notes($id=NULL){
        $select = '';
        $notes = AttendNote::where('application_id',$id)->orderBy('id','asc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                            $select .= '</div>';
                            $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->role=='interviewer' || Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager'){
                                $select .= '<a onclick="deleteMainNote1('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
                            $select .= '<p class="mg-b-0">'.$note->note.'</p>';
                            $select .= '<small class="text-left"> Created : '.date('F d Y H:i:s',strtotime($note->created_at)).'</small>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</p><hr>';
            }
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
            'application_id'=>$id
        );
        return response()->json($data,200);
    }
    public function application_note_post(Request $request){
        $note = new AttendNote();
        $note->application_id = $request->note_application_id;
        $note->note = $request->application_note;
        $note->user_id = Auth::user()->id;
        $note->status = 0;
        $note->save();
        //make notification

        $select = '';
        $notes = AttendNote::where('application_id',$request->note_application_id)->orderBy('id','asc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                            $select .= '</div>';
                            $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->role=='interviewer' || Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager'){
                                $select .= '<a onclick="deleteMainNote1('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
                            $select .= '<p class="mg-b-0">'.$note->note.'</p>';
                            $select .= '<small class="text-left"> Created : '.date('F d Y H:i:s',strtotime($note->created_at)).'</small>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</p><hr>';
            }
        }
        //make instant notification for super admin
        //event(new AdminMsgEvent($notification->description,url('application/'.$request->application_id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
            'application_id'=>$note->application_id
        );
        return response()->json($data,200);
    }
    public function main_note_delete($id=NULL){
        $main_note = AttendNote::where('id',$id)->first();
        if(!$main_note){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Note Data Not Found'
            );
            return response()->json($data,200);
        }
        $delete = AttendNote::where('id',$main_note->id)->delete();

        //make notification

        $select = '';
        $notes = AttendNote::where('application_id',$main_note->application_id)->orderBy('id','asc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->role=='interviewer' || Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager'){
                                $select .= '<a onclick="deleteMainNote1('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
                            $select .= '<p class="mg-b-0">'.$note->note.'</p>';
                            $select .= '<small class="text-left"> Created : '.date('F d Y H:i:s',strtotime($note->created_at)).'</small>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</p><hr>';
            }
        }
        //make instant notification for super admin
        //event(new AdminMsgEvent($notification->description,url('application/'.$main_note->application_id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
        );
        return response()->json($data,200);
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
