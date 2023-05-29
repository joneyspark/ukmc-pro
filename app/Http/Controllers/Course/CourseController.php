<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Traits\Service;
Use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;

class CourseController extends Controller{
    use Service;
    public function create(){
        $data['page_title'] = 'Course / Create';
        $data['course'] = true;
        $data['course_add'] = true;
        return view('course/create',$data);
    }
    public function all(){
        $data['page_title'] = 'Course / List';
        $data['course'] = true;
        $data['course_all'] = true;
        return view('course/all',$data);
    }
    public function archive(){
        $data['page_title'] = 'Archived / Course';
        $data['course'] = true;
        $data['course_archive'] = true;
        return view('course/archive',$data);
    }
    
    public function course_levels(){
        $data['page_title'] = 'Course | Levels';
        $data['course'] = true;
        $data['course_levels'] = true;
        return view('course/levels',$data);
    }
    public function course_details($slug=NULL){
        $data['page_title'] = 'Course | Details';
        $data['course'] = true;
        $data['course_all'] = true;
        return view('course/details',$data);
    }
}
