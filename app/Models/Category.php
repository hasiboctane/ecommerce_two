<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'image','parent_id','is_active'];

    public function parentCategory(){
        return $this->belongsTo(ParentCategory::class);
    }
    public function subCategories(){
        return $this->hasMany(SubCategory::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
