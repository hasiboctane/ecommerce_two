<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug','image','is_active'];

    public function parentCategories()
    {
        return $this->belongsToMany(ParentCategory::class);
    }
    public function subCategories(){
        return $this->hasMany(SubCategory::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
