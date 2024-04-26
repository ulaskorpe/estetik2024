<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Blog extends Model
    {
        use HasFactory,SoftDeletes;
        protected $table = 'blogs';
        protected $fillable = ['title', 'icon','blog','prologue','slug','category_id','user_id','youtube_link'];
    
      
        public function images()
        {
            return $this->hasMany(\App\Models\BlogImage::class, 'blog_id');
        }
    
        public function category()
        {
            return $this->belongsTo(\App\Models\Category::class, 'category_id');
        }
        public function user()
        {
            return $this->belongsTo(\App\Models\User::class, 'user_id');
        }
}
