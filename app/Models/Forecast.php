<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'period', 'forecast_result'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
