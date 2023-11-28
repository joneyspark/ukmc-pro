<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    public $table = "blogs";

    public function category(){
        return $this->belongsTo(BlogCategory::class,'blog_category_id');
    }
    public static function stringSubstrLimit($string = null, $limit = null)
    {
        if (! empty($string) && ! empty($limit)) {
            if (strlen($string) > $limit) {
                $string = substr($string, 0, $limit).'...';

                return $string;
            } else {
                return $string;
            }
        } else {
            return null;
        }
    }
}
