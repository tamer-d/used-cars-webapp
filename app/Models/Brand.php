<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];
    
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
    
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return Storage::url($this->logo);
        }
        return null;
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::updating(function ($brand) {
            if ($brand->isDirty('logo') && $brand->getOriginal('logo')) {
                Storage::disk('public')->delete($brand->getOriginal('logo'));
            }
        });
        
        static::deleting(function ($brand) {
            if ($brand->logo) {
                Storage::delete($brand->logo);
            }
        });
    }
}