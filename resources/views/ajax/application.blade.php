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
            $.post('{{ URL::to('application-note-post') }}',
                {
                    application_id: application_id,
                    application_note: application_note,
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
