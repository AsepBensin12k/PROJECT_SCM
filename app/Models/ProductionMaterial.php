<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['production_id', 'material_id', 'quantity_used'];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
