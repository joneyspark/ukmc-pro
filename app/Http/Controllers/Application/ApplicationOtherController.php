<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\AddNewLead;
use App\Events\AdminMsgEvent;
use App\Events\AgentEvent;
use App\Models\Notification\Notification;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\requestDocumentMail;
use App\Models\Application\Followup;
use App\Models\Application\Meeting;
use App\Models\Application\Note;

class ApplicationOtherController extends Controller
{
    public function get_notes($id=NULL){
        $select = '';
        $notes = Note::where('application_id',$id)->orderBy('id','desc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name.'</h6>';
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
        $note = new Note();
        $note->application_id = $request->application_id;
        $note->note = $request->application_note;
        $note->user_id = Auth::user()->id;
        $note->status = 0;
        $note->save();
        //make notification
        $notification = new Notification();
        $notification->title = 'Note Create';
        $notification->description = 'Make a New Note of Application By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->application_id = $request->application_id;
        $notification->slug = 'application/'.$request->application_id.'/processing';
        $notification->save();
        $select = '';
        $notes = Note::where('application_id',$request->application_id)->orderBy('id','desc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name.'</h6>';
                            $select .= '<p class="mg-b-0">'.$note->note.'</p>';
                            $select .= '<small class="text-left"> Created : '.date('F d Y H:i:s',strtotime($note->created_at)).'</small>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</p><hr>';
            }
        }
        //make instant notification for super admin
        event(new AdminMsgEvent($notification->description,url('application/'.$request->application_id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
            'application_id'=>$note->application_id
        );
        return response()->json($data,200);
    }
    //follow up
    public function get_followups($id=NULL){
        $select = '';
        $followup_notes = Followup::where('application_id',$id)->orderBy('id','desc')->get();
        if($followup_notes){
            foreach($followup_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name.'</h6>';
                            $select .= '<p class="mg-b-0">'.$note->follow_up.'</p>';
                            $select .= '<small class="text-left"> Followup Date : <span class="badge badge-warning">'.date('F d Y H:i:s',strtotime($note->follow_up_date_time)).'</span></small><br>';
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
    //follow up note post
    public function follow_up_note_post(Request $request){
        $note = new Followup();
        $note->application_id = $request->application_id;
        $note->follow_up = $request->application_followup_note;
        $note->follow_up_date_time = $request->application_followup_datetime;
        $note->user_id = Auth::user()->id;
        $note->save();
        //make notification
        $notification = new Notification();
        $notification->title = 'Followup Create';
        $notification->description = 'Make a New Followup Note of Application By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->application_id = $request->application_id;
        $notification->slug = 'application/'.$request->application_id.'/processing';
        $notification->save();
        $select = '';
        $followup_notes = Followup::where('application_id',$request->application_id)->orderBy('id','desc')->get();
        if($followup_notes){
            foreach($followup_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name.'</h6>';
                            $select .= '<p class="mg-b-0">'.$note->follow_up.'</p>';
                            $select .= '<small class="text-left"> Followup Date : <span class="badge badge-warning">'.date('F d Y H:i:s',strtotime($note->follow_up_date_time)).'</span></small><br>';
                            $select .= '<small class="text-left"> Created : '.date('F d Y H:i:s',strtotime($note->created_at)).'</small>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</p><hr>';
            }
        }
        //make instant notification for super admin
        event(new AdminMsgEvent($notification->description,url('application/'.$request->application_id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
            'application_id'=>$note->application_id
        );
        return response()->json($data,200);
    }
    //get meeting 
    public function get_meetings($id=NULL){
        $select = '';
        $meeting_notes = Meeting::where('application_id',$id)->orderBy('id','desc')->get();
        if($meeting_notes){
            foreach($meeting_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name.'</h6>';
                            $select .= '<p class="mg-b-0">'.$note->meeting_notes.'</p>';
                            $select .= '<small class="text-left"> Meeting Date : <span class="badge badge-warning">'.date('F d Y H:i:s',strtotime($note->meeting_date_time)).'</span></small><br>';
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
}
