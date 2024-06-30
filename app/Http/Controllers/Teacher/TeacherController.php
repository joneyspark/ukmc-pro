<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Campus\Campus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Service;

class TeacherController extends Controller{
    use Service;
    public function teachers(){
        $data['page_title'] = 'Teacher | All';
        $data['attend'] = true;
        $data['teacher_list'] = true;
        return view('teacher.teacher',$data);
    }
    public function create_teacher(){
        $data['page_title'] = 'Teacher | Create';
        $data['managers'] = User::where('role','manager')->where('active',1)->get();
        $data['get_campuses'] = Campus::where('active',1)->get();
        $data['countries'] = Service::countries();
        return view('teacher.create_teacher',$data);
    }
    public function get_class_schedule_by_teacher($id=NULL){
        $data['page_title'] = 'Teacher | Calss Schedule List';
        $data['attend'] = true;
        $data['teacher_list'] = true;
        return view('teacher.teacher_class_schedule_list',$data);
    }
}
