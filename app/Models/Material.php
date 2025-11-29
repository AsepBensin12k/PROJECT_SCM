<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'name', 'unit', 'stock', 'price'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function forecasts()
    {
        return $this->hasMany(Forecast::class);
    }

    public function productions()
    {
        return $this->belongsToMany(Production::class, 'production_materials    ')
                    ->withPivot('quantity_used')
                    ->withTimestamps();
    }

}
