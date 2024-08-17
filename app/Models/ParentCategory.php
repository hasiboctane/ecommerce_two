<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'image', 'is_active'];
    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
