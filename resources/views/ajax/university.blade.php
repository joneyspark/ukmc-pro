<script type="text/javascript">
    $(document).ready(function() {
        //e.preventDefault();
        var maxele = 15;
        var count = 1;
        let addbutton = document.getElementById("addAttributeButton");
        addbutton.addEventListener("click", function() {
        let attributes_boxes = document.getElementById("select-wrapper");
        let clone = attributes_boxes.firstElementChild.cloneNode(true);
        if(count < maxele){
            count++;
            attributes_boxes.appendChild(clone);
        }

        });
        $("#select-wrapper").on("click",".remove-attribute-element", function(e){
            e.preventDefault();

            if(count > 1){
                $(this).parents("#element-wrapper").remove();
                count--;
            }

        });
    });
</script>
<script>
    //var count = 1;
    $(document).on("click", ".remove-attribute-element", function(e) {
        e.preventDefault();
        var $wrapper = $(this).closest(".element-wrapper");
        if ($wrapper.siblings().length > 0) {
            $wrapper.remove();
        }

    });
</script>
@if(Auth::check())
@if(Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='interviewer')
<script>
    Pusher.logToConsole = true;
    var pusher = new Pusher('ef4fd77f0ef3365b974c', {
    cluster: 'ap2'
    });
    var channel = pusher.subscribe('AdminMessage');
    channel.bind('adminmsg', function(data) {
        //alert(JSON.stringify(data));
        iziToast.show({
            title: 'Hey',
            message: data.message+' <a style="color:blue;" href="'+data.url+'">View</a>',
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

