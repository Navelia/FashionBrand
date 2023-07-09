<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function staff(){
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function points_histories(){
        return $this->hasMany(PointsHistory::class, 'transaction_id', 'id');
    }
    public function variants(){
        return $this->belongsToMany(Variant::class, 'transactions_variants', 'transaction_id', 'variant_id')->withPivot('price', 'quantity', 'sub_total');
    }
}
