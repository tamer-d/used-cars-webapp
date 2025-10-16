<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];
    
     public static function validationRules($id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|regex:/^[0-9]{10}$/',
            'password' => 'required|min:8',
        ];
    }
    
    public static function validationMessages()
    {
        return [
            'phone_number.regex' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
        ];
    }
    

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }
    
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'seller_id');
    }
    
    // Helpers
    public function isAdmin()
    {
        return $this->is_admin === true;
    }
}