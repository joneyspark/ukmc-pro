<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\AddNewLead;
use App\Events\AdminMsgEvent;
use App\Events\AgentEvent;
use App\Mail\Application\meetingNoteConfirm;
use App\Mail\Interview\interviewCancelMail;
use App\Models\Notification\Notification;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\requestDocumentMail;
use App\Models\Application\Application;
use App\Models\Application\ApplicationStatus;
use App\Models\Application\Followup;
use App\Models\Application\InterviewStatus;
use App\Models\Application\Meeting;
use App\Models\Application\Note;
use App\Models\Setting\CompanySetting;

class ApplicationOtherController extends Controller
{
    public function get_notes($id=NULL){
        $select = '';
        $notes = Note::where('application_id',$id)->orderBy('id','asc')->get();
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
        $followup_notes = Followup::where('application_id',$id)->orderBy('id','asc')->get();
        if($followup_notes){
            foreach($followup_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteFollowupNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_follow_up_done==1){
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
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
        $followup_notes = Followup::where('application_id',$request->application_id)->orderBy('id','asc')->get();
        if($followup_notes){
            foreach($followup_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteFollowupNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_follow_up_done==1){
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
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
        $meeting_notes = Meeting::where('application_id',$id)->orderBy('id','asc')->get();
        if($meeting_notes){
            foreach($meeting_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMeetingNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_meeting_done==1){
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Success" aria-label="Success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Pending" aria-label="Pending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
                            }
                            $select .= '<a href="'.url('meeting/'.$note->id.'/details').'" style="float:right; margin-right:5px;" class="badge badge-pill bg-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
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
        //meeting doc file upload
        $meeting_doc = $request->meeting_doc;
        if ($request->hasFile('meeting_doc')) {

            $ext = $meeting_doc->getClientOriginalExtension();
            $doc_file_name = $meeting_doc->getClientOriginalName();
            $doc_file_name = Service::slug_create($doc_file_name).rand(11, 99).'.'.$ext;
            $upload_path1 = 'backend/images/meeting/meeting_doc/';
            Service::createDirectory($upload_path1);
            $request->file('meeting_doc')->move(public_path('backend/images/meeting/meeting_doc/'), $doc_file_name);
            $note->meeting_doc = $upload_path1.$doc_file_name;
        }
        $note->user_id = Auth::user()->id;
        $note->save();
        $application_info = Application::where('id',$request->application_id)->first();
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
        $meeting_notes = Meeting::where('application_id',$request->application_id)->orderBy('id','asc')->get();
        if($meeting_notes){
            foreach($meeting_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMeetingNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_meeting_done==1){
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Success" aria-label="Success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Pending" aria-label="Pending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
                            }
                            $select .= '<a href="'.url('meeting/'.$note->id.'/details').'" style="float:right; margin-right:5px;" class="badge badge-pill bg-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
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
        $meeting_notes = Meeting::where('application_id',$meeting->application_id)->orderBy('id','asc')->get();
        if($meeting_notes){
            foreach($meeting_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMeetingNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_meeting_done==1){
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Success" aria-label="Success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Pending" aria-label="Pending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
                            }
                            $select .= '<a href="'.url('meeting/'.$note->id.'/details').'" style="float:right; margin-right:5px;" class="badge badge-pill bg-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
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
        //make mail for cancel meeting
        $application_data = Application::where('id',$meeting->application_id)->first();
        $details = [
            'application_data'=>$application_data,
            'company'=>CompanySetting::where('id',1)->first(),
            'meeting_info'=>$meeting,
        ];
        Mail::to($application_data->email)->send(new interviewCancelMail($details));
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
        $followup_notes = Followup::where('application_id',$followup->application_id)->orderBy('id','asc')->get();
        if($followup_notes){
            foreach($followup_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteFollowupNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_follow_up_done==1){
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
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
        $notification->title = 'Followup Remove';
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
    //meeting status chnage
    public function meeting_status_change($id=NULL){
        $meeting = Meeting::where('id',$id)->first();
        if(!$meeting){
            $data['result'] = array(
                'key'=>200,
                'val'=>'This is Another User Meeting Info. You Don,t Have Any Permission To Chnage Status!',
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($meeting->is_meeting_done==1){
            $update = Meeting::where('id',$meeting->id)->update(['is_meeting_done'=>0]);
            $msg = 'Meeting Restore of Application by '.Auth::user()->name;
        }else{
            $update = Meeting::where('id',$meeting->id)->update(['is_meeting_done'=>1]);
            $msg = 'Meeting Complete of Application by '.Auth::user()->name;
        }
        $select = '';
        $meeting_notes = Meeting::where('application_id',$meeting->application_id)->orderBy('id','asc')->get();
        if($meeting_notes){
            foreach($meeting_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteMeetingNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_meeting_done==1){
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Success" aria-label="Success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isMeetingComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Pending" aria-label="Pending"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
                            }
                            $select .= '<a href="'.url('meeting/'.$note->id.'/details').'" style="float:right; margin-right:5px;" class="badge badge-pill bg-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
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
        $notification->title = 'Meeting Status Change';
        $notification->description = $msg;
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
            'message'=>$msg,
        );
        return response()->json($data,200);
    }
    //followup status chnage
    public function followup_status_change($id=NULL){
        $followup = Followup::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$followup){
            $data['result'] = array(
                'key'=>200,
                'val'=>'Followup Data Not Found!',
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($followup->is_follow_up_done==1){
            $update = Followup::where('id',$followup->id)->update(['is_follow_up_done'=>0]);
            $msg = 'Followup Restore of Application by '.Auth::user()->name;
        }else{
            $update = Followup::where('id',$followup->id)->update(['is_follow_up_done'=>1]);
            $msg = 'Followup Complete of Application by '.Auth::user()->name;
        }
        $select = '';
        $followup_notes = Followup::where('application_id',$followup->application_id)->orderBy('id','asc')->get();
        if($followup_notes){
            foreach($followup_notes as $note){
                $select .= '<p class="modal-text">';
                    $select .= '<div class="custom-media-margin media custom-media-img">';
                        $select .= '<div class="mr-2">';
                            $select .= '<img alt="avatar" src="'.url($note->user->photo).'" class="img-fluid rounded-circle" style="width: 50px; margin-right: 5px;">';
                        $select .= '</div>';
                        $select .= '<div class="media-body">';
                            $select .= '<h6 class="tx-inverse">'.$note->user->name;
                            if(Auth::user()->id==$note->user_id){
                                $select .= '<a onclick="deleteFollowupNote('.$note->id.')" style="float:right; color:#b30b39;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                            }
                            if($note->is_follow_up_done==1){
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#1f6b08; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></a>';
                            }else{
                                $select .= '<a onclick="isFollowupComplete('.$note->id.')" style="float:right; color:#ada310; margin-right:5px;" href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></a>';
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
        $notification->title = 'Followup Status Change';
        $notification->description = $msg;
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
            'message'=>$msg,
        );
        return response()->json($data,200);
    }
    //direct meeting status chage
    public function direct_meeting_status_change($id=NULL){
        $meeting = Meeting::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$meeting){
            Session::flash('error','Meeting Data Not Found!');
            return redirect()->back();
        }
        $msg = '';
        if($meeting->is_meeting_done==0){
            $update = Meeting::where('id',$meeting->id)->update(['is_meeting_done'=>1]);
            Session::flash('success','Meeting Successfully Confirmed!');
            return redirect()->back();
        }else{
            Session::flash('error','Already Confirmed This Meeting!');
            return redirect()->back();
        }
    }
    //direct meeting status chage
    public function direct_followup_status_change($id=NULL){
        $followup = Followup::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$followup){
            Session::flash('error','Followup Data Not Found!');
            return redirect('interview-list');
        }
        if($followup->is_follow_up_done==0){
            $update = Followup::where('id',$followup->id)->update(['is_follow_up_done'=>1]);
            Session::flash('success','Followup Successfully Confirmed!');
            return redirect('interview-list');
        }else{
            Session::flash('error','Already Confirmed This Followup!');
            return redirect('interview-list');
        }
    }
    //application status
    public function all_application_status($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Then Create Status!');
            return redirect('login');
        }
        $data['return_application_status_id'] = Session::get('application_status_id');
        $data['page_title'] = 'Application | Status';
        $data['application'] = true;
        $data['application_status'] = true;
        $data['get_application_status'] = ApplicationStatus::orderBy('id','desc')->get();
        if($id){
            $data['applicatoin_status_data'] = ApplicationStatus::where('id',$id)->first();
        }
        Session::forget('application_status_id');
        return view('application/status/application_status',$data);
    }
    public function application_status_store(Request $request){
        $request->validate([
            'title' => 'required',
        ]);
        $ApplicationId = $request->application_status_id;
        if($ApplicationId){
            $ApplicationStatus = ApplicationStatus::where('id',$ApplicationId)->first();
        }else{
            $ApplicationStatus = new ApplicationStatus();
        }
        $ApplicationStatus->title = $request->title;
        $ApplicationStatus->save();
        Session::put('application_status_id',$ApplicationStatus->id);
        Session::flash('success',(!empty($ApplicationId))?'Application Status Upadted!':'Application Status Saved!');
        return redirect('all-application-status');
    }
    public function application_main_status_change(Request $request){
        $application_status = ApplicationStatus::where('id',$request->application_status_id)->first();
        if(!$application_status){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Applicaton Status Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($application_status->status==1){
            $update = ApplicationStatus::where('id',$application_status->id)->update(['status'=>$request->status]);
            $msg = 'Applicaton Status Activated';
        }else{
            $update = ApplicationStatus::where('id',$application_status->id)->update(['status'=>$request->status]);
            $msg = 'Applicaton Status Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    //interview status
    public function all_interview_status($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First! Then Create Interview Status!');
            return redirect('login');
        }
        $data['return_interview_status_id'] = Session::get('interview_status_id');
        $data['page_title'] = 'Application | Interview Status';
        $data['application'] = true;
        $data['application_interview_status'] = true;
        $data['get_interview_status'] = InterviewStatus::orderBy('id','desc')->get();
        if($id){
            $data['interview_status_data'] = InterviewStatus::where('id',$id)->first();
        }
        Session::forget('interview_status_id');
        return view('application/status/interview_status',$data);
    }
    //interview status store
    public function interview_status_store(Request $request){
        $request->validate([
            'title' => 'required',
        ]);
        $ApplicationId = $request->interview_status_id;
        if($ApplicationId){
            $ApplicationStatus = InterviewStatus::where('id',$ApplicationId)->first();
        }else{
            $ApplicationStatus = new InterviewStatus();
        }
        $ApplicationStatus->title = $request->title;
        $ApplicationStatus->save();
        Session::put('interview_status_id',$ApplicationStatus->id);
        Session::flash('success',(!empty($ApplicationId))?'Interview Status Upadted!':'Interview Status Saved!');
        return redirect('all-interview-status');
    }
    public function interview_main_status_change(Request $request){
        $application_status = InterviewStatus::where('id',$request->interview_status_id)->first();
        if(!$application_status){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Interview Status Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($application_status->status==1){
            $update = InterviewStatus::where('id',$application_status->id)->update(['status'=>$request->status]);
            $msg = 'Interview Status Activated';
        }else{
            $update = InterviewStatus::where('id',$application_status->id)->update(['status'=>$request->status]);
            $msg = 'Interview Status Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }

}
