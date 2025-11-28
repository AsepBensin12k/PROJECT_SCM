<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'origin',
        'contact',
        'status'
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'non-aktif');
    }

    public function isActive()
    {
        return $this->status === 'aktif';
    }

    public function getStatusBadgeClass()
    {
        return $this->status === 'aktif' 
            ? 'bg-green-100 text-green-800' 
            : 'bg-red-100 text-red-800';
    }

    public function getStatusIcon()
    {
        return $this->status === 'aktif' 
            ? 'fa-check-circle' 
            : 'fa-times-circle';
    }
}