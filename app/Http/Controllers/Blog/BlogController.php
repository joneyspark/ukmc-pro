<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogImage;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller{
    public function all_blog_categories($id=NULL){
        $data['page_title'] = 'Blog | Categories';
        if($id){
            $data['category_data'] = BlogCategory::where('id',$id)->first();
        }
        $data['categories'] = BlogCategory::orderBy('id','desc')->paginate(10);
        return view('blog/category',$data);

    }
    public function create_blog_category(Request $request){
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
}
