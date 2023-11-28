<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<link rel="canonical" href="https://www.fonts.com/font/monotype/century-gothic/story" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/css/bs-stepper.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css" integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

<div class="container my-3">
    <h5>Image Upload</h5>
    <div class="row">
        <div class="col-md-12">
            <form enctype="multipart/form-data" action="{{ URL::to('blog-upload-image') }}" method="post">
                @csrf
                <div class="col-md-6 mb-3">
                    <input class="form-control my-2" type="file" name="upload" />
                    <button class="btn btn-success my-2 px-4 fw-bold rounded-pill" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @forelse ($images as $key=>$image)
            <a onclick="getUrl({{ $image->id }})" href="javascript://"><img class="img-fluid" style="margin-top: 10px; max-width:300px;" id="image_id{{ $image->id }}" src="{{ asset($image->url) }}" /></a>&nbsp;
            @empty
                <h5>No Data Found</h5>
            @endforelse
            <div class="row text-center mt-4">
                <div class="col-12 text-center">{{ $images->links() }}</div>
            </div>

        </div>
    </div>
</div>
<script>
    function getUrl(id){
        var imageSrc = $('#image_id'+id).attr('src');
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(imageSrc);
        tempInput.select();
        document.execCommand('copy');
        tempInput.remove();
        iziToast.show({
          title: 'Success',
          message: 'Image Url Copied',
          position: 'topRight',
          timeout: 8000,
          color: 'blue',
          balloon: true,
          close: true,
          progressBarColor: 'yellow',
      });
    }
</script>
