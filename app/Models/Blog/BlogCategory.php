<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    public $table = "blog_categories";

    public function blog_list(){
        return $this->hasMany(Blog::class,'blog_category_id');
    }
}
