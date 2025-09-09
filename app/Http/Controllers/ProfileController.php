<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Affiche le profil de l'utilisateur
     */
    public function show()
    {
        $user = Auth::user();
        
        // Nombre d'annonces publiées
        $carsCount = $user->cars()->count();
        
        // Nombre d'avis reçus et note moyenne
        $reviewsCount = $user->reviewsReceived()->count();
        $averageRating = $user->reviewsReceived()->avg('rating');
        
        return view('profile.show', compact('user', 'carsCount', 'reviewsCount', 'averageRating'));
    }
    
    /**
     * Affiche le formulaire d'édition du profil
     */
    public function edit()
    {
        $user = Auth::user();
        
        return view('profile.edit', compact('user'));
    }
    
    /**
     * Met à jour le profil de l'utilisateur
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Mise à jour des informations de base
        $user->name = $validated['name'];
        $user->phone_number = $validated['phone_number'] ?? null;
        
        // Gestion du changement d'email
        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
            $user->email_verified_at = null;
        }
        
        // Mise à jour du mot de passe si fourni
        if (isset($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        return redirect()->route('profile.show')->with('success', 'Profil mis à jour avec succès');
    }
}