<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'product_id',
        'quantity_produced',
        'production_date',
        'operator',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'production_materials')
                    ->withPivot('quantity_used')
                    ->withTimestamps();
    }

}
