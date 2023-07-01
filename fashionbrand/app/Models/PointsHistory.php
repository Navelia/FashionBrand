<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsHistory extends Model
{
    use HasFactory;
    protected $table = 'points_history';
    public $timestamps = false;

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
