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
            var application_id = $('#application_id').val();
            var application_note = $('#application_note').val();
            $.post('#',
                {
                    application_id: application_id,
                    application_note: application_note,
                },

                function(data, status){
                    console.log(data);
                    console.log(status);
                    if(data['result']['key']===101){

                    }
                    if(data['result']['key']===200){

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
