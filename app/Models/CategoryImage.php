<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CategoryImage extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['image', 'image200','image50','rank','category_id'];


    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}
