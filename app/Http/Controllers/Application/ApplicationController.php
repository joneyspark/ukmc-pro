<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\AddNewLead;

class ApplicationController extends Controller
{
    public function create(){
        $data['page_title'] = 'Application / Create';
        $data['application'] = true;
        $data['application_add'] = true;
        AddNewLead::dispatch('Hello this is test');
        return view('application/create',$data);
    }
    public function all(){
        $data['page_title'] = 'Application / All';
        $data['application'] = true;
        $data['application_all'] = true;
        return view('application/all',$data);
    }
    public function ongoing(){
        $data['page_title'] = 'Application / Ongoing';
        $data['application'] = true;
        $data['application_ongoing'] = true;
        return view('application/ongoing',$data);
    }
    public function enrolled(){
        $data['page_title'] = 'Application / Enrolled';
        $data['application'] = true;
        $data['application_enrolled'] = true;
        return view('application/enrolled',$data);
    }
    public function archive_students(){
        $data['page_title'] = 'Archived / Students';
        $data['application'] = true;
        $data['application_archived'] = true;
        return view('application/archived',$data);
    }
    public function application_details(){
        $data['page_title'] = 'Application | Details';
        $data['application'] = true;
        $data['application_all'] = true;
        return view('application/details',$data);
    }
}
