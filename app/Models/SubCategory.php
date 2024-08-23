<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','image','category_id','is_active'];

    // public function parentCategory(){
    //     return $this->belongsTo(ParentCategory::class);
    // }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function productTypes(){
        return $this->hasMany(ProductType::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
