<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BlogImage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'blog_images';
    protected $fillable = ['image', 'image200','image50','rank','blog_id'];


    public function blog()
    {
        return $this->belongsTo(\App\Models\Blog::class, 'blog_id');
    }
}
