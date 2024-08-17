<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug','image','parent_id','category_id','sub_category_id','is_active'];
    public function parentCategory(){
        return $this->belongsTo(ParentCategory::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
