<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Models\Task\Task;
use Illuminate\Http\Request;
use App\Traits\Service;
use App\Models\User;
use Illuminate\Support\Facades\Session;
Use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use App\Events\TaskEvent;
use App\Events\AddNewLead;
use App\Http\Requests\Task\TaskEditRequest;
use App\Models\Notification\Notification;

class TaskController extends Controller{
    use Service;

    public function create(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Don,t have any permission to Create Task!');
            return redirect('task-list');
        }
        $data['page_title'] = 'Task | Create';
        $data['task'] = true;
        $data['task_add'] = true;
        $data['priorities'] = Service::priority();
        $data['users'] = User::where('role','!=','agent')->where('role','!=','admin')->where('active',1)->get();
        return view('task/create',$data);
    }
    public function store(TaskCreateRequest $request){
        $task = new Task();
        $task->assign_by = Auth::user()->id;
        $task->assign_to = $request->assign_to;
        $task->task_name = $request->task_name;
        $task->priority = $request->priority;
        $task->task_details = $request->task_details;
        //slug create
        $url_modify = Service::slug_create($request->task_name);
        $checkSlug = Task::where('slug', 'LIKE', '%' . $url_modify . '%')->count();
        if ($checkSlug > 0) {
            $new_number = $checkSlug + 1;
            $new_slug = $url_modify . '-' . $new_number;
            $task->slug = $new_slug;
        } else {
            $task->slug = $url_modify;
        }
        $task->deadline = $request->deadline;

        $doc = $request->doc;
        if ($request->hasFile('doc')) {
            $ext = $doc->getClientOriginalExtension();
            $doc_file_name = $doc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 999).'.'.$ext;
            $upload_path1 = 'backend/images/task/doc/';
            Service::createDirectory($upload_path1);
            $request->file('doc')->move(public_path('backend/images/task/doc/'), $doc_file_name);
            $task->doc = $upload_path1.$doc_file_name;
        }
        $task->save();
        $getAssignToUser = User::where('id',$task->assign_to)->first();
        //make instant messaging
        $message = 'New Task Create By '.Auth::user()->name.' For You';
        $url = url('task/details/'.$task->slug);
        event(new TaskEvent($getAssignToUser->id,$message,$url));
        //create notification and activity
        $notification = new Notification();
        $notification->title = $task->task_name;
        $notification->description = 'New Task Create For You!';
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = $getAssignToUser->id;
        $notification->slug = $url;
        $notification->save();
        Session::put('task_id',$task->id);
        Session::flash('success','Task Created Successfully!');
        return redirect('task-list');
    }
    public function all(){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Don,t have any permission to Create Task!');
            return redirect('task-list');
        }
        $data['page_title'] = 'Task | All';
        $data['task'] = true;
        $data['task_all'] = true;
        $data['get_task_id'] = Session::get('task_id');
        $data['tasks'] = Task::orderBy('id','desc')->paginate(10);
        Session::forget('task_id');
        return view('task/all',$data);
    }
    public function edit($slug=NULL){
        if(!Auth::check() && Auth::user()->role != 'admin'){
            Session::flash('error','Don,t have any permission to Create Task!');
            return redirect('task-list');
        }
        $data['page_title'] = 'Task | Edit';
        $data['task'] = true;
        $data['task_all'] = true;
        $data['users'] = User::where('role','!=','agent')->where('role','!=','admin')->where('active',1)->get();
        $data['priorities'] = Service::priority();
        $data['task_data'] = Task::where('slug',$slug)->first();
        return view('task/edit',$data);
    }
    public function edit_post(TaskEditRequest $request){
        $task = Task::where('id',$request->task_id)->first();
        if(!$task){
            Session::flash('error','Task Data Not Found!');
            return redirect('task-list');
        }
        $task->assign_by = Auth::user()->id;
        $task->assign_to = $request->assign_to;
        $task->task_name = $request->task_name;
        $task->priority = $request->priority;
        $task->task_details = $request->task_details;
        $task->deadline = $request->deadline;
        $doc = $request->doc;
        if ($request->hasFile('doc')){
            if (File::exists(public_path($task->doc))) {
                File::delete(public_path($task->doc));
            }
            $ext = $doc->getClientOriginalExtension();
            $doc_file_name = $doc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 999).'.'.$ext;
            $upload_path1 = 'backend/images/task/doc/';
            Service::createDirectory($upload_path1);
            $request->file('doc')->move(public_path('backend/images/task/doc/'), $doc_file_name);
            $task->doc = $upload_path1.$doc_file_name;
        }
        $task->save();
        $getAssignToUser = User::where('id',$task->assign_to)->first();
        //make instant messaging
        $message = 'Task Update By '.Auth::user()->name.' For You';
        $url = url('task/details/'.$task->slug);
        event(new TaskEvent($getAssignToUser->id,$message,$url));
        //create notification and activity
        $notification = new Notification();
        $notification->title = $task->task_name;
        $notification->description = 'Task Update For You!';
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = $getAssignToUser->id;
        $notification->slug = $url;
        $notification->save();
        Session::put('task_id',$task->id);
        Session::flash('success','Task Updated Successfully!');
        return redirect('task-list');
    }
    public function details($slug=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First Then See This Task!');
            return redirect('task-list');
        }
        $data['page_title'] = 'Task | Details';
        $data['task'] = true;
        $data['task_all'] = true;
        $data['users'] = User::where('role','!=','agent')->where('role','!=','admin')->where('active',1)->get();
        $data['priorities'] = Service::priority();
        $data['task_status'] = Service::task_status();
        $data['task_data'] = Task::where('slug',$slug)->first();
        //update view
        if(Auth::user()->id==$data['task_data']->assign_to){
            $updateView = Task::where('id',$data['task_data']->id)->update(['is_view'=>1]);
        }
        $data['coments'] = json_decode($data['task_data']->coments);
        return view('task/task_details',$data);
    }
    //task comment
    public function task_commment(Request $request){
        $request->validate([
            'coment' => 'required',
        ]);
        $task = Task::where('id',$request->task_id)->first();
        if(!$task){
            Session::flash('error','Task Data Not Found! Server Error');
            return redirect('task-list');
        }
        if(!empty($task->coments)){
            $get_task_arr = json_decode($task->coments);
            $id = count($get_task_arr) + 1;
            //make comment array
            $taskComent[] = array(
                'id'=>$id,
                'name'=>Auth::user()->name,
                'photo'=>Auth::user()->photo,
                'create_date'=>time(),
                'coment'=>$request->coment,
            );
            $merge = array_merge($get_task_arr,$taskComent);
            $coment = json_encode($merge);
            //update data
            $update = Task::where('id',$task->id)->update(['coments'=>$coment]);
            Session::flash('success','Coment Added');
            return redirect('task/details/'.$task->slug);
        }else{
            $taskComent[] = array(
                'id'=> 1,
                'name'=>Auth::user()->name,
                'photo'=>Auth::user()->photo,
                'create_date'=>time(),
                'coment'=>$request->coment,
            );
            $coment = json_encode($taskComent);
            $update = Task::where('id',$task->id)->update(['coments'=>$coment]);
            Session::flash('success','Coment Added');
            return redirect('task/details/'.$task->slug);
        }
    }
    //status change
    public function task_status_chnage(Request $request){
        $task = Task::where('id',$request->task_id)->first();
        if(!$task){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Task Data Not Found!'
            );
            return response()->json($data,200);
        }
        $current_status = ($task->status == 0) ? "Pending" : (($task->status == 1) ? "Ongoing" : (($task->status == 2) ? "Progress" : (($task->status == 3) ? "Complete" : (($task->status == 4) ? "Cancel" : "Not Found"))));
        $status = $request->status;
        $message = ($status == 0) ? "Pending" : (($status == 1) ? "Ongoing" : (($status == 2) ? "Progress" : (($status == 3) ? "Complete" : (($status == 4) ? "Cancel" : "Not Found"))));
        $update = Task::where('id',$task->id)->update(['status'=>$status]);
        //make instant notification
        $url = url('task/details/'.$task->slug);
        $notify_msg = 'Task status change from <span style="color:red;">'.$current_status.'</span> to <span style="color:green;">'.$message.'</span>';
        event(new TaskEvent($task->assign_by,$notify_msg,$url));
        //notification create
        //create notification and activity
        $notification = new Notification();
        $notification->title = $task->task_name;
        $notification->description = $notify_msg;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = $task->assign_by;
        $notification->slug = $url;
        $notification->save();
        //end notification
        $data['result'] = array(
            'key'=>200,
            'val'=>$notify_msg
        );
        return response()->json($data,200);
    }
    public function my_tasks(){
        $data['page_title'] = 'Task | My Task';
        $data['task'] = true;
        $data['task_my'] = true;
        $data['tasks'] = Task::orderBy('id','desc')->where('assign_to',Auth::user()->id)->paginate(10);
        return view('task/mytask',$data);
    }
}
