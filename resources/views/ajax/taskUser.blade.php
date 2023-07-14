@if(Auth::check())
@if(Auth::user()->role=='teacher' || Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='interviewer')
<script>
    var userId = {{ Auth::user()->id }};

    // Enable Pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('ef4fd77f0ef3365b974c', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('task.'+userId);
    channel.bind('tasknotice', function(data) {
        //alert(JSON.stringify(data));
        iziToast.show({
            title: 'Task:',
            message: data.message+' <a style="color:blue;" href="'+data.url+'">View Task</a>',
            position: 'bottomRight',
            timeout: 8000,
            color: 'green',
            balloon: true,
            close: true,
            progressBarColor: 'yellow',
        });

        this.get_notifications();
    });
</script>
@endif

@if(Auth::user()->role=='agent')
<script>
    var userId = {{ Auth::user()->id }};
    Pusher.logToConsole = true;
    var pusher = new Pusher('ef4fd77f0ef3365b974c', {
        cluster: 'ap2'
    });
    var channel = pusher.subscribe('agent.'+userId);
    channel.bind('agentnotice', function(data) {
        //alert(JSON.stringify(data));
        iziToast.show({
            title: 'Agent Notification:',
            message: data.message+' <a style="color:blue;" href="'+data.url+'">View Details</a>',
            position: 'bottomRight',
            timeout: 8000,
            color: 'green',
            balloon: true,
            close: true,
            progressBarColor: 'yellow',
        });
        this.get_notifications();
    });
</script>

@endif
@endif

