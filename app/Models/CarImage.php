<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'car_id',
        'path',
        'main',
    ];
    
    protected $casts = [
        'main' => 'boolean',
    ];
    
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}