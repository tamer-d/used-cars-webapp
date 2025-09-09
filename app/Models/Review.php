<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['reviewer_id', 'seller_id', 'rating', 'comment'];
    
    protected $casts = [
        'rating' => 'integer',
    ];
    
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
    
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}