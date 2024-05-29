<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogImage;
use Illuminate\Support\Facades\Session;
use App\Traits\Service;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller{
    use Service;
    public function all_blog_categories($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First Then Create Blog');
            return redirect('login');
        }
        $data['blog'] = true;
        $data['blog_categories_menu'] = true;
        $data['page_title'] = 'Blog | Categories';
        if($id){
            $data['category_data'] = BlogCategory::where('id',$id)->first();
        }
        $data['categories'] = BlogCategory::orderBy('id','desc')->paginate(10);
        return view('blog/category',$data);

    }
    public function create_blog_category(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First Then Create Blog');
            return redirect('login');
        }
        $request->validate([
            'title'=>'required',
        ]);
        if($request->blog_category_id){
            $topic = BlogCategory::where('id',$request->blog_category_id)->first();
        }else{
            $topic = new BlogCategory();
        }
        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->save();
        Session::flash('success','Blog Category Saved');
        return redirect('blog-categories');
    }
    public function category_status_change(Request $request){
        $category = BlogCategory::where('id',$request->category_id)->first();
        if(!$category){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Category Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($category->status==1){
            $update = BlogCategory::where('id',$category->id)->update(['status'=>$request->status]);
            $msg = 'Category Activated';
        }else{
            $update = BlogCategory::where('id',$category->id)->update(['status'=>$request->status]);
            $msg = 'Category Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    public function create_blog($id=NULL){
        if(!Auth::check()){
            Session::flash('error','Login First Then Create Blog');
            return redirect('login');
        }
        $data['blog'] = true;
        $data['add_blog'] = true;
        if($id){
            $data['blog_data'] = Blog::where('id',$id)->first();
        }
        $data['blog_categories'] = BlogCategory::where('status',0)->get();
        $data['page_title'] = "Blog | Create Blog";
        return view('blog/create',$data);
    }
    public function create_blog_data_post(Request $request){
        if(!Auth::check()){
            Session::flash('error','Login First Then Create Blog');
            return redirect('login');
        }
        $request->validate([
            'blog_category_id'=>'required',
            'author_name'=>'required',
            'title'=>'required',
            'long_description'=>'required',
            'blog_status'=>'required',
            'publish_time'=>'required',
            'meta_description'=>'max:160',
        ]);
        if($request->blog_id){
            $blog = Blog::where('id',$request->blog_id)->first();
            $blog->slug = $request->slug;
        }else{
            $blog = new Blog();
        }

        $blog->title = $request->title;
        //slug create
        if(empty($request->blog_id)){
            $url_modify = Service::slug_create($request->title);
            $checkSlug = Blog::where('slug', 'LIKE', '%' . $url_modify . '%')->count();
            if($checkSlug > 0) {
                $new_number = $checkSlug + 1;
                $new_slug = $url_modify . '-' . $new_number;
                $blog->slug = $new_slug;
            }else{
                $blog->slug = $url_modify;
            }
        }
        $blog->alt_tag = $request->alt_tag;
        $blog->long_description = $request->long_description;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->author_name = $request->author_name;
        $blog->meta_description = $request->meta_description;
        $blog->blog_status = $request->blog_status;
        $blog->publish_time = Carbon::parse($request->publish_time);

        //upload image
        $image1 = $request->image;
        if($request->hasFile('image')) {
            if (File::exists(asset($blog->image))) {
                File::delete(asset($blog->image));
            }
            $ext = $image1->getClientOriginalExtension();
            $filename = $image1->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(11, 99).'.'.$ext;
            $image_resize = Image::make($image1->getRealPath());
            $image_resize->resize(1200, 644);
            $upload_path = 'backend/images/blog/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/blog/'.$filename));
            $blog->image = 'backend/images/blog/'.$filename;
        }
        //upload author image
        $image2 = $request->author_image;
        if($request->hasFile('author_image')) {
            if (File::exists(asset($blog->author_image))) {
                File::delete(asset($blog->author_image));
            }
            $ext = $image2->getClientOriginalExtension();
            $filename = $image2->getClientOriginalName();
            $filename = Service::slug_create($filename).rand(11, 99).'.'.$ext;
            $image_resize = Image::make($image2->getRealPath());
            $image_resize->resize(100, 100);
            $upload_path = 'backend/images/blog/author/';
            Service::createDirectory($upload_path);
            $image_resize->save(public_path('backend/images/blog/author/'.$filename));
            $blog->author_image = 'backend/images/blog/author/'.$filename;
        }
        $blog->save();
        Session::flash('success','Blog Data Updated');
        return redirect('create-blog/'.$blog->id);
    }
    public function list_blog(){
        if(!Auth::check()){
            Session::flash('error','Login First Then Create Blog');
            return redirect('login');
        }
        $data['blog'] = true;
        $data['blog_list_menu'] = true;
        $data['page_title'] = "Blog / All Blog";
        $data['blog_list'] = Blog::with('category')->orderBy('created_at','desc')->paginate(10);
        return view('blog/list',$data);
    }
    public function blog_status_change(Request $request){
        $blog = Blog::where('id',$request->blog_id)->first();
        if(!$blog){
            $data['result'] = array(
                'key'=>101,
                'val'=>'Blog Data Not Found! Server Error!'
            );
            return response()->json($data,200);
        }
        $msg = '';
        if($blog->status==1){
            $update = Blog::where('id',$blog->id)->update(['status'=>$request->status]);
            $msg = 'Blog Activated';
        }else{
            $update = Blog::where('id',$blog->id)->update(['status'=>$request->status]);
            $msg = 'Blog Deactivated';
        }
        $data['result'] = array(
            'key'=>200,
            'val'=>$msg
        );
        return response()->json($data,200);
    }
    public function upload_image_page(Request $request){
        $data['images'] = BlogImage::orderBy('id','desc')->paginate(30);
        return view('blog/imagepage',$data);
    }
    public function upload_image(Request $request){
        $blog = new BlogImage();
        $image1 = $request->upload;
        if ($request->hasFile('upload')) {
            $ext = $image1->getClientOriginalExtension();
            $doc_file_name = $image1->getClientOriginalName();
            $doc_file_name = 'UKMC-'.Service::get_random_str_number().'-'.Service::slug_create($doc_file_name).'.'.$ext;
            $upload_path1 = 'backend/images/blog/upload/';
            Service::createDirectory($upload_path1);
            $request->file('upload')->move(public_path('backend/images/blog/upload/'), $doc_file_name);
            $blog->url = $upload_path1.$doc_file_name;
            $blog->save();
            return redirect('image/upload?CKEditor=post_content&CKEditorFuncNum=1&langCode=en');
        }else{
            return redirect('image/upload?CKEditor=post_content&CKEditorFuncNum=1&langCode=en');
        }
    }
}
