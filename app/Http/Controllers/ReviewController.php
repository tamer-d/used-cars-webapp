<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Stocke un nouvel avis
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'seller_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);
        
        // Empêche de s'auto-évaluer
        if ($validated['seller_id'] == Auth::id()) {
            return back()->withErrors(['seller_id' => 'Vous ne pouvez pas vous évaluer vous-même.']);
        }
        
        // Vérifie si un avis existe déjà
        $existingReview = Review::where('reviewer_id', Auth::id())
            ->where('seller_id', $validated['seller_id'])
            ->first();
            
        if ($existingReview) {
            // Met à jour l'avis existant
            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null
            ]);
            
            return back()->with('success', 'Votre avis a été mis à jour avec succès');
        }
        
        // Crée un nouvel avis
        Review::create([
            'reviewer_id' => Auth::id(),
            'seller_id' => $validated['seller_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null
        ]);
        
        return back()->with('success', 'Votre avis a été publié avec succès');
    }
}