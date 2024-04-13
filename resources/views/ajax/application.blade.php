<script>
    function get_application_notes(id){
        if(id===null){
            return false;
        }
        $.get('{{ URL::to('application-get-notes') }}/'+id,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#note-data').html(data['result']['val']);
                $('#note_application_id').val(data['result']['application_id']);
            }
        });
    }
    function get_application_followups(id){
        if(id===null){
            return false;
        }
        $.get('{{ URL::to('application-get-followups') }}/'+id,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#followupnote-data').html(data['result']['val']);
                $('#followup_application_id').val(data['result']['application_id']);
            }
        });
    }
    //meetings note
    function get_application_meetings(id){
        if(id===null){
            return false;
        }
        $.get('{{ URL::to('application-get-meetings') }}/'+id,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#meetingnote-data').html(data['result']['val']);
                $('#meeting_application_id').val(data['result']['application_id']);
            }
        });
    }
    function deleteMeetingNote(id){
        if (confirm('Are you sure to delete this Meeting Data?')) {
            $.get('{{ URL::to('meeting-note-remove') }}/'+id,function(data,status){
                if(data['result']['key']===101){
                    alert(data['result']['val']);
                }
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#meetingnote-data').html(data['result']['val']);
                }
            });
        }
    }
    function deleteFollowupNote(id){
        if(confirm('Are You Sure To Delete Followup Data')){
            $.get('{{ URL::to('follow-up-note-remove') }}/'+id,function(data,status){
                if(data['result']['key']===101){
                    alert(data['result']['val']);
                }
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#followupnote-data').html(data['result']['val']);
                }
            });
        }
    }
    function deleteMainNote(id){
        if(confirm('Are You Sure To Delete Note Data')){
            $.get('{{ URL::to('main-note-remove') }}/'+id,function(data,status){
                if(data['result']['key']===101){
                    alert(data['result']['val']);
                }
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#note-data').html(data['result']['val']);
                }
            });
        }
    }
    function isMeetingComplete(id){
        if(confirm('Are You Sure To Change Meeting Status')){
            $.get('{{ URL::to('meeting-status-change') }}/'+id,function(data,status){
                if(data['result']['key']===101){
                    alert(data['result']['val']);
                }
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#meetingnote-data').html(data['result']['val']);
                    iziToast.show({
                        title: 'Success:',
                        message: data['result']['message'],
                        position: 'topRight',
                        timeout: 8000,
                        color: 'green',
                        balloon: true,
                        close: true,
                        progressBarColor: 'yellow',
                    });
                }
            });
        }
    }
    function isFollowupComplete(id){
        if(confirm('Are You Sure To Change Followup Status')){
            $.get('{{ URL::to('followup-status-change') }}/'+id,function(data,status){
                if(data['result']['key']===101){
                    alert(data['result']['val']);
                }
                if(data['result']['key']===200){
                    console.log(data['result']['val']);
                    $('#followupnote-data').html(data['result']['val']);
                    iziToast.show({
                        title: 'Success:',
                        message: data['result']['message'],
                        position: 'topRight',
                        timeout: 8000,
                        color: 'green',
                        balloon: true,
                        close: true,
                        progressBarColor: 'yellow',
                    });
                }
            });
        }
    }

</script>
<script>
    $(document).ready(function() {
        $('#note-formid').validate({
            rules: {
                application_note: {
                    required: true
                },
            },
            messages: {
                application_note: {
                    required: "Note Field Is Required!"
                },
            },
            submitHandler: function(form) {
            $('#btn-note-submit').prop('disabled', true);
            var application_id = $('#note_application_id').val();
            var application_note = $('#application_note').val();
            var is_view = $('#is_view').val();
            $.post('{{ URL::to('application-note-post') }}',
                {
                    application_id: application_id,
                    application_note: application_note,
                    is_view: is_view,
                },
                function(data, status){
                    console.log(data);
                    console.log(status);
                    if(data['result']['key']===200){
                        iziToast.show({
                            title: 'Success:',
                            message: 'Successfully Create a New Note!',
                            position: 'topRight',
                            timeout: 8000,
                            color: 'green',
                            balloon: true,
                            close: true,
                            progressBarColor: 'yellow',
                        });
                        $('#btn-note-submit').prop('disabled', false);
                        $('#note-data').html(data['result']['val']);
                        $('#application_note').val("");
                        $('#note_application_id').val(data['result']['application_id']);
                    }
                }).fail(function(xhr, status, error) {
                    // Error callback...
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                });
                return false;
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#followup-form').validate({
            rules: {
                application_followup: {
                    required: true
                },
                followup_date: {
                    required: true
                },
            },
            messages: {
                application_followup: {
                    required: "Followup Note Field Is Required!"
                },
                followup_date: {
                    required: "Followup Date Field Is Required!"
                },
            },
            submitHandler: function(form) {
            $('#btn-followup-submit').prop('disabled', true);
            var application_id = $('#followup_application_id').val();
            var application_followup_note = $('#application_followup').val();
            var application_followup_datetime = $('#followup_date').val();
            $.post('{{ URL::to('follow-up-note-post') }}',
                {
                    application_id: application_id,
                    application_followup_note: application_followup_note,
                    application_followup_datetime: application_followup_datetime,
                },
                function(data, status){
                    console.log(data);
                    console.log(status);
                    if(data['result']['key']===200){
                        iziToast.show({
                            title: 'Success:',
                            message: 'Successfully Create a New Follow Note!',
                            position: 'topRight',
                            timeout: 8000,
                            color: 'green',
                            balloon: true,
                            close: true,
                            progressBarColor: 'yellow',
                        });
                        $('#btn-followup-submit').prop('disabled', false);
                        $('#followupnote-data').html(data['result']['val']);
                        $('#application_followup').val("");
                        $('#followup_date').val("");
                        $('#followup_application_id').val(data['result']['application_id']);
                    }
                }).fail(function(xhr, status, error) {
                    // Error callback...
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
  $('#meeting-form').validate({
    rules: {
      application_meeting: {
        required: true
      },
      meeting_date: {
        required: true
      },
    },
    messages: {
      application_meeting: {
        required: "Meeting Note Field Is Required!"
      },
      meeting_date: {
        required: "Meeting Date Field Is Required!"
      },
    },
    submitHandler: function(form) {
      $('#btn-meeting-submit').prop('disabled', true);
      var formData = new FormData();
      var url = $('#meeting_url').val();
      var application_id = $('#meeting_application_id').val();
      var application_meeting = $('#application_meeting').val();
      var meeting_date = $('#meeting_date').val();
      var meeting_doc = $('#meeting_doc')[0].files[0];

      formData.append('application_id', application_id);
      formData.append('application_meeting', application_meeting);
      formData.append('meeting_date', meeting_date);
      formData.append('meeting_doc', meeting_doc);

      $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, status) {
          console.log(data);
          console.log(status);
          if (data['result']['key'] === 200) {
            iziToast.show({
              title: 'Success:',
              message: 'Successfully Create a New Meeting Of Application!',
              position: 'topRight',
              timeout: 8000,
              color: 'green',
              balloon: true,
              close: true,
              progressBarColor: 'yellow',
            });
            $('#btn-meeting-submit').prop('disabled', false);
            $('#meetingnote-data').html(data['result']['val']);
            $('#application_meeting').val("");
            $('#meeting_date').val("");
            $('#meeting_doc').val("");
            $('#meeting_application_id').val(data['result']['application_id']);
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          console.log(status);
          console.log(error);
        }
      });
    }
  });
});

function get_application_notes_by_agent(id){
    if(id===null){
        return false;
    }
    $.get('{{ URL::to('get-notes-by-agent') }}/'+id,function(data,status){
        if(data['result']['key']===200){
            console.log(data);
            $('#note-data').html(data['result']['val']);
            $('#note_application_id').val(data['result']['application_id']);
        }
    });
}

</script>
<script>
    function get_notification_data(id){
        var getId = id;
        $.get('{{ URL::to('get-notification-data-for-activity-list') }}/'+getId,function(data,status){
            if(data['result']['key']===200){
                console.log(data['result']['val']);
                $('#change-field-data').html(data['result']['val']);
            }
            if(data['result']['key']===101){
                console.log(data['result']['val']);
            }
        });
    }

    $(document).ready(function() {
        $('#eligible-form').validate({
            rules: {
            officer_name: {
                required: true
            },
            crn: {
                required: true
            },
            is_eligible: {
                required: true
            },
            eligible_notes: {
                required: true
            },
            },
            messages: {
            officer_name: {
                required: "Officer Name Field Is Required!"
            },
            crn: {
                required: "CRN Field Is Required!"
            },
            is_eligible: {
                required: "Please Select Eligible!"
            },
            eligible_notes: {
                required: "Eligible Notes Field Is Required!"
            },
            },
            submitHandler: function(form) {
            $('#btn-eligible-submit').prop('disabled', true);
            var formData = new FormData();
            var url = $('#eligible_url').val();
            var application_id = $('#eligible_application_id').val();
            var eligible_id = $('#eligible_id').val();
            var officer_name = $('#officer_name').val();
            var crn = $('#crn').val();
            var is_eligible = $('#is_eligible').val();
            var eligible_notes = $('#eligible_notes').val();


            formData.append('application_id', application_id);
            formData.append('eligible_id', eligible_id);
            formData.append('officer_name', officer_name);
            formData.append('crn', crn);
            formData.append('is_eligible', is_eligible);
            formData.append('notes', eligible_notes);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data, status) {
                console.log(data);
                console.log(status);
                if (data['result']['key'] === 200) {
                    iziToast.show({
                    title: 'Success:',
                    message: data['result']['val'],
                    position: 'topRight',
                    timeout: 8000,
                    color: 'green',
                    balloon: true,
                    close: true,
                    progressBarColor: 'yellow',
                    });
                    $('#btn-eligible-submit').prop('disabled', false);
                    $('#eligible_application_id').val(data['result']['application_id']);
                    $('#eligible_id').val(data['result']['eligible_id']);
                }
                },
                error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.log(error);
                }
            });
            }
        });
    });
</script>
