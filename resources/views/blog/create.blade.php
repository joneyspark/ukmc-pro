@extends('adminpanel')
@section('admin')
<link rel="stylesheet" href="{{ asset('front/css/switch.css') }}">
<script src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <div class="secondary-nav">
            <div class="breadcrumbs-container" data-page-heading="Analytics">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                    <div class="d-flex breadcrumb-content">
                        <div class="page-header">
                            <div class="page-title">
                            </div>
                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="row col-md-12 mt-4">
            <div id="select-wrapper">
                <div id="element-wrapper">
                    <form method="post" action="{{ URL::to('create-blog-data-post') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="hidden" name="blog_id" value="{{ (!empty($blog_data->id))?$blog_data->id:'' }}" />
                                <label for="title" class="form-label">Blog Category*</label>
                                <select name="blog_category_id" id="blog_category_id" class="form-select">
                                    <option value="" selected>Select Category</option>
                                    @foreach ($blog_categories as $row)
                                    <option {{ (!empty($blog_data->blog_category_id) && $blog_data->blog_category_id==$row->id)?'selected':'' }} value="{{ $row->id }}" >{{ $row->title }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('blog_category_id'))
                                    <span class="text-danger">{{ $errors->first('blog_category_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Blog Author*</label>
                                    <input type="text" value="{{ (!empty($blog_data->author_name))?$blog_data->author_name:'Author' }}" name="author_name" class="form-control" id="author_name" aria-describedby="fname">
                                    @if($errors->has('author_name'))
                                        <span class="text-danger">{{ $errors->first('author_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">Author Image (JPEG, PNG):</label>
                                    <input type="file" name="author_image" class="form-control" id="author_image" aria-describedby="fname">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">Blog Title</label>
                                <input type="text" value="{{ (!empty($blog_data->title))?$blog_data->title:old('title') }}" name="title" class="form-control" id="title" aria-describedby="fname">
                                @if($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fname" class="form-label">Feature Image (JPEG, PNG, Webp)</label>
                                <input type="file" name="image" class="form-control" id="fname" aria-describedby="fname">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fname" class="form-label">Feature Image Alt Tag</label>
                                <input type="text" value="{{ (!empty($blog_data->alt_tag))?$blog_data->alt_tag:old('alt_tag') }}" name="alt_tag" class="form-control" id="fname" aria-describedby="fname">
                            </div>
                        </div>
                        <div class="col-md-3">
                            @if(!empty($blog_data->image))
                            <div class="mb-3">
                                <img src="{{ asset($blog_data->image) }}" width="300px" height="180px" />
                            </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">Meta Description (Optional)</label>
                                <textarea name="meta_description" class="form-control" rows="3">{{ (!empty($blog_data->meta_description))?$blog_data->meta_description:old('meta_description') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="fname" class="form-label">Blog Description</label>

                                <textarea tabindex="-1" name="long_description" id="post_content" class="form-control" rows="10">{{ (!empty($blog_data->long_description))?$blog_data->long_description:old('long_description') }}</textarea>
                                @if($errors->has('long_description'))
                                    <span class="text-danger">{{ $errors->first('long_description') }}</span>
                                @endif
                                <script>
                                    CKEDITOR.replace('post_content');

                                </script>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">URL (Optional)</label>
                                <textarea name="slug" class="form-control" rows="3">{{ (!empty($blog_data->slug))?$blog_data->slug:'' }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">Blog Status</label>
                                    <select name="blog_status" id="blog_status" class="form-select">
                                        <option value="" selected="">Select status</option>
                                        <option {{ (!empty($blog_data->blog_status) && $blog_data->blog_status=='Publish')?'selected':'' }} value="Publish">Publish</option>
                                        <option {{ (!empty($blog_data->blog_status) && $blog_data->blog_status=='Draft')?'selected':'' }} value="Draft">Draft</option>
                                        <option {{ (!empty($blog_data->blog_status) && $blog_data->blog_status=='Schedule')?'selected':'' }} value="Schedule">Schedule</option>
                                    </select>
                                    @if($errors->has('blog_status'))
                                        <span class="text-danger">{{ $errors->first('blog_status') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">Publish time</label>
                                    <input name="publish_time" value="{{ (!empty($blog_data->publish_time))?$blog_data->publish_time:now()->format('Y-m-d\TH:i') }}" type="datetime-local" class="form-control" id="dob" aria-describedby="dob">
                                    @if($errors->has('publish_time'))
                                        <span class="text-danger">{{ $errors->first('publish_time') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-start py-2">
                            <button type="submit" class="px-5 py-2 common-button rounded-pill">Save</button>
                            @if(!empty($blog_data->slug))
                            <a href="{{ env('FRONT_URL').'blog-details/'.$blog_data->slug }}" target="_blank" class="btn btn-warning px-5 py-2 common-button rounded-pill">Preview</a>
                            <a href="{{ URL::to('list-blog') }}" class="btn btn-success px-5 py-2 common-button rounded-pill">Blog List</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 $(function(){
    $('.category-status-chnage').change(function(){
        var status = $(this).prop('checked') == true ? 0 : 1;
        var category_id = $(this).data('id');
        var url = $(this).data('action');
            $.post(url,
            {
                category_id: category_id,
                status: status
            },
            function(data, status){
                console.log(data);
                if(data['result']['key']===101){
                    iziToast.show({
                        title: 'Info',
                        message: data['result']['val'],
                        position: 'topRight',
                        timeout: 8000,
                        color: 'red',
                        balloon: true,
                        close: true,
                        progressBarColor: 'yellow',
                    });
                }
                if(data['result']['key']===200){
                    iziToast.show({
                        title: 'Info',
                        message: data['result']['val'],
                        position: 'topRight',
                        timeout: 8000,
                        color: 'green',
                        balloon: true,
                        close: true,
                        progressBarColor: 'yellow',
                    });
                    setTimeout(function () {
                        location.reload(true);
                    }, 2000);
                }
                //alert("Data: " + data + "\nStatus: " + status);
            });

    });
});
</script>
@endsection
