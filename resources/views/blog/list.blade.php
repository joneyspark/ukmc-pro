@extends('adminpanel')
@section('admin')
<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">
        <div class="secondary-nav">
            <div class="breadcrumbs-container" data-page-heading="Analytics">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </a>
                    <div class="d-flex breadcrumb-content">
                        <div class="page-header">
                            <div class="page-title">
                            </div>
                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">All</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <h5 class="pt-3">All Blog</h5>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publish Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blog_list as $list)
                                <tr>
                                    <td>{{ App\Models\Blog\Blog::stringSubstrLimit($list->title,25) }}</td>
                                    <td>
                                        {!! App\Models\Blog\Blog::stringSubstrLimit($list->long_description,30) !!}
                                    </td>
                                    <td>{{ (!empty($list->category->title))?$list->category->title:'' }}</td>
                                    <td>{{ date('F d Y',strtotime($list->publish_time)) }}</td>
                                    <td>{{ (!empty($list->blog_status))?$list->blog_status:'' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a target="_blank" href="{{ env('FRONT_URL').'blog-details/'.$list->slug }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </a>&nbsp;
                                            <a href="{{ URL::to('create-blog/'.$list->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>&nbsp;
                                            <div class="ms-1 switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                                                <div class="input-checkbox">
                                                    <span class="switch-chk-label label-left">On</span>
                                                    <input {{ ($list->status==0)?'checked':'' }} data-action="{{ URL::to('blog-status-change') }}" data-id="{{ $list->id }}" class="blog-status-chnage switch-input" type="checkbox"
                                                            role="switch" id="form-custom-switch-inner-text">
                                                    <span class="switch-chk-label label-right">Off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                  </tr>
                                @empty
                                    <tr>
                                        No Data Found
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div style="text-align: center;" class="pagination-custom_solid">
                            {{ $blog_list->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<style>
    .is-action-data{
        display: none;
    }
    .is-action-data-show{
        display: block;
    }
    .error{
        color: #a90606 !important;
    }
    .assignToDisplay{
        display: none;
    }
    .assignToDisplay1{
        display: none;
    }
    .assignToBtn{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
    .assignToBtn1{
        color: #f7bd1a !important;
        margin-left: 14px;
        font-size: 15px !important;
    }
    .form-control{
        padding: 0.45rem 1rem !important;
    }
</style>
<script src="{{ asset('web/js/jquery.js') }}"></script>
<script>
    $(function(){
       $('.blog-status-chnage').change(function(){
           var status = $(this).prop('checked') == true ? 0 : 1;
           var blog_id = $(this).data('id');
           var url = $(this).data('action');
               $.post(url,
               {
                   blog_id: blog_id,
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
                       setTimeout(function () {
                           location.reload(true);
                       }, 2000);
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

                   }
                   //alert("Data: " + data + "\nStatus: " + status);
               });

       });
   });
   </script>
@stop
