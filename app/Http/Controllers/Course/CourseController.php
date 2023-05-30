<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Campus\Campus;
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
    public function all(){
        $data['page_title'] = 'Course | List';
        $data['course'] = true;
        $data['course_all'] = true;
        return view('course/all',$data);
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
