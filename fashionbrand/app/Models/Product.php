<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function type(){
        return $this->belongsTo(Type::class, 'type_id');
    }
    public function categories(){
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id');
    }
    public function categorieswithTrashed(){
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id')->withTrashed();
    }
    public function transactions(){
        return $this->belongsToMany(Transaction::class, 'products_transactions', 'transaction_id', 'product_id')->withPivot('price', 'quantity', 'sub_total');
    }
    
}
