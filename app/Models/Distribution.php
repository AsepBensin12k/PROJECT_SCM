<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
    'code',
    'user_id',
    'product_id',
    'destination',
    'quantity',
    'status',
    'notes'
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
