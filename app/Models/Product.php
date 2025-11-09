<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }
}
