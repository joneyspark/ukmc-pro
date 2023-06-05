<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\AddNewLead;
use App\Models\Agent\Company;
use App\Models\Campus\Campus;
use Carbon\Carbon;
use App\Traits\Service;

class ApplicationController extends Controller{
    use Service;
    public function create(){
        
        $data['page_title'] = 'Application | Create';
        $data['application'] = true;
        $data['application_add'] = true;
        $data['a_company_data'] = Company::where('status',1)->get();
        $data['a_campuses_data'] = Campus::where('active',1)->get();
        $data['intakes'] = Service::get_intake_with_next_year();
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_1',$data);
    }
    public function create_step_2(){
        $data['page_title'] = 'Application | Create | Step 2';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_2',$data);
    }
    public function create_step_3(){
        $data['page_title'] = 'Application | Create | Step 3';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_3',$data);
    }
    public function create_step_4(){
        $data['page_title'] = 'Application | Create | Step 4';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_4',$data);
    }
    public function create_step_5(){
        $data['page_title'] = 'Application | Create | Step 5';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_5',$data);
    }
    public function create_step_6(){
        $data['page_title'] = 'Application | Create | Step 6';
        $data['application'] = true;
        $data['application_add'] = true;
        //AddNewLead::dispatch('Hello this is test');
        return view('application/create_step_6',$data);
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
