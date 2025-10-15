<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'year',
        'mileage',
        'fuel_type',
        'transmission',
        'brand_id',
        'model_id',
        'category_id',
        'color',
        'doors',
        'engine_size',
        'power',
        'is_featured',
        'location',
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
        'mileage' => 'integer',
        'doors' => 'integer',
        'power' => 'integer',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
    ];
    
    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }
    
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    // Scopes pour des requêtes fréquentes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }
        
        if (isset($filters['model_id'])) {
            $query->where('model_id', $filters['model_id']);
        }
        
        if (isset($filters['fuel_type'])) {
            $query->where('fuel_type', $filters['fuel_type']);
        }
        
        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        
        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        
        if (isset($filters['min_year'])) {
            $query->where('year', '>=', $filters['min_year']);
        }
        
        if (isset($filters['max_year'])) {
            $query->where('year', '<=', $filters['max_year']);
        }
        
        return $query;
    }
    
    // Incrémenter le compteur de vues
    public function incrementViewCount()
    {
        $this->increment('views_count');
        return $this->views_count;
    }
}