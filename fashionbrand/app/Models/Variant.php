<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function transactions(){
        return $this->belongsToMany(Transaction::class, 'transactions_variants', 'variant_id', 'transaction_id')->withPivot('price', 'quantity', 'sub_total');
    }
}
