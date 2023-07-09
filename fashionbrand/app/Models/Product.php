<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function type(){
        return $this->belongsTo(Type::class, 'type_id');
    }
    public function typewithTrashed(){
        return $this->belongsTo(Type::class, 'type_id')->withTrashed();
    }
    public function categories(){
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id');
    }
    public function categorieswithTrashed(){
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id')->withTrashed();
    }
    public function variants(){
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }
}
