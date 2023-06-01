<script>
    $(document).ready(function() {
  const fetch_data = (page, status, search_term) => {
    if (status === undefined) {
      status = "";
    }
    if (search_term === undefined) {
      search_term = "";
    }
    $.ajax({
      url: "{{ URL::to('all-course') }}",
      data:{
        page: page,
        status: status,
        search_term: search_term
      },
      success: function(data) {
        $('#tabledata').html(data);
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText); // Handle any errors
        console.log(error); // Handle any errors
      }
    });
  }

  $(document).on('keyup', '#search', function() {
    var status = $('#status').val();
    var search_term = $('#search').val();
    var page = 1; // Reset page to 1 when searching
    $('#hidden_page').val(page);
    fetch_data(page, status, search_term);
  });

  $(document).on('change', '#status', function() {
    var status = $('#status').val();
    var search_term = $('#search').val();
    var page = 1; // Reset page to 1 when changing status
    $('#hidden_page').val(page);
    fetch_data(page, status, search_term);
  });

  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    //$('#hidden_page').val(page);
    var status = $('#status').val();
    var search_term = $('#search').val();
    fetch_data(page, status, search_term);
  });

});
</script>
