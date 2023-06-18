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
        $notes = Note::where('application_id',$id)->orderBy('id','asc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="row col-md-12 mt-3 modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                            $select .= '</div>';
                            $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMainNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
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
        $notes = Note::where('application_id',$request->application_id)->orderBy('id','asc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="row col-md-10 mt-3 modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                            $select .= '</div>';
                            $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMainNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
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
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteFollowupNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
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
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteFollowupNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
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
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMeetingNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
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
    //meeting note post
    public function meeting_note_post(Request $request){
        $note = new Meeting();
        $note->application_id = $request->application_id;
        $note->meeting_notes = $request->application_meeting;
        $note->meeting_date_time = $request->meeting_date;
        $note->user_id = Auth::user()->id;
        $note->save();
        //make notification
        $notification = new Notification();
        $notification->title = 'Meeting Date Create';
        $notification->description = 'Make a Meeting of Application By '.Auth::user()->name;
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
        $meeting_notes = Meeting::where('application_id',$request->application_id)->orderBy('id','desc')->get();
        if($meeting_notes){
            foreach($meeting_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMeetingNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
                            $select .= '<p class="mg-b-0">'.$note->meeting_notes.'</p>';
                            $select .= '<small class="text-left"> Meeting Date : <span class="badge badge-warning">'.date('F d Y H:i:s',strtotime($note->meeting_date_time)).'</span></small><br>';
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
    //delete meeting data
    public function meeting_note_remove($id=NULL){
        $meeting = Meeting::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$meeting){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Meeting Data Not Found'
            );
            return response()->json($data,200);
        }
        $delete = Meeting::where('id',$meeting->id)->delete();

        $select = '';
        $meeting_notes = Meeting::where('application_id',$meeting->application_id)->orderBy('id','desc')->get();
        if($meeting_notes){
            foreach($meeting_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMeetingNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
                            $select .= '<p class="mg-b-0">'.$note->meeting_notes.'</p>';
                            $select .= '<small class="text-left"> Meeting Date : <span class="badge badge-warning">'.date('F d Y H:i:s',strtotime($note->meeting_date_time)).'</span></small><br>';
                            $select .= '<small class="text-left"> Created : '.date('F d Y H:i:s',strtotime($note->created_at)).'</small>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</p><hr>';
            }
        }
        //make notification
        $notification = new Notification();
        $notification->title = 'Meeting Canceled';
        $notification->description = 'Meeting Canceled of Application By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->application_id = $meeting->application_id;
        $notification->slug = 'application/'.$meeting->application_id.'/processing';
        $notification->save();
        //make instant notification for super admin
        event(new AdminMsgEvent($notification->description,url('application/'.$meeting->application_id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
            'delete'=>$delete
        );
        return response()->json($data,200);
    }
    //follow up note delete
    public function follow_up_note_delete($id=NULL){
        $followup = Followup::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$followup){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Follow up Data Not Found'
            );
            return response()->json($data,200);
        }
        $delete = Followup::where('id',$followup->id)->delete();

        $select = '';
        $followup_notes = Followup::where('application_id',$followup->application_id)->orderBy('id','desc')->get();
        if($followup_notes){
            foreach($followup_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.$note->user->photo.'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteFollowupNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            $select .= '</h6>';
                            $select .= '<p class="mg-b-0">'.$note->follow_up.'</p>';
                            $select .= '<small class="text-left"> Followup Date : <span class="badge badge-warning">'.date('F d Y H:i:s',strtotime($note->follow_up_date_time)).'</span></small><br>';
                            $select .= '<small class="text-left"> Created : '.date('F d Y H:i:s',strtotime($note->created_at)).'</small>';
                        $select .= '</div>';
                    $select .= '</div>';
                $select .= '</p><hr>';
            }
        }
        //make notification
        $notification = new Notification();
        $notification->title = 'Meeting Canceled';
        $notification->description = 'Followup Remove of Application By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->application_id = $followup->application_id;
        $notification->slug = 'application/'.$followup->application_id.'/processing';
        $notification->save();
        //make instant notification for super admin
        event(new AdminMsgEvent($notification->description,url('application/'.$followup->application_id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
        );
        return response()->json($data,200);
    }
    //note delete
    public function main_note_delete($id=NULL){
        $main_note = Note::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$main_note){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Note Data Not Found'
            );
            return response()->json($data,200);
        }
        $delete = Note::where('id',$main_note->id)->delete();

        //make notification
        $notification = new Notification();
        $notification->title = 'Note Delete';
        $notification->description = 'Note Delete of Application By '.Auth::user()->name;
        $notification->create_date = time();
        $notification->create_by = Auth::user()->id;
        $notification->creator_name = Auth::user()->name;
        $notification->creator_image = Auth::user()->photo;
        $notification->user_id = 1;
        $notification->is_admin = 1;
        $notification->application_id = $main_note->application_id;
        $notification->slug = 'application/'.$main_note->application_id.'/processing';
        $notification->save();
        $select = '';
        $notes = Note::where('application_id',$main_note->application_id)->orderBy('id','asc')->get();
        if($notes){
            foreach($notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMainNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
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
        event(new AdminMsgEvent($notification->description,url('application/'.$main_note->application_id.'/processing')));
        $data['result'] = array(
            'key'=>200,
            'val'=>$select,
        );
        return response()->json($data,200);
    }
    //create note on detail page
    public function note_create_of_application_details(Request $request){
        $request->validate([
            'note' => 'required',
        ]);
        $note = new Note();
        $note->application_id = $request->note_application_id;
        $note->note = $request->note;
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
        $notification->application_id = $request->note_application_id;
        $notification->slug = 'application/'.$request->note_application_id.'/processing';
        $notification->save();
        
        //make instant notification for super admin
        //event(new AdminMsgEvent($notification->description,url('application/'.$request->note_application_id.'/processing')));
        Session::flash('success','Note Create Successfully!');
        Session::flash('note_data_load','note-data');
        return redirect('application/'.$request->note_application_id.'/processing');
    }
}
