<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['parent_category_id','category_id','sub_category_id','product_type_id','brand_id','name', 'slug', 'images', 'description', 'price', 'is_active','is_featured','in_stock','on_sale'];

    protected $casts = [
        'images' => 'array'
    ];

    public function parentCategory(){
        return $this->belongsTo(ParentCategory::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }
    public function productType(){
        return $this->belongsTo(ProductType::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }


}
