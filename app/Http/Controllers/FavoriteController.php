<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Liste les annonces favorites de l'utilisateur
     */
    public function index()
    {
        $favorites = Favorite::with(['car.brand', 'car.model'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('favorites.index', compact('favorites'));
    }
    
    /**
     * Ajoute une annonce aux favoris
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id'
        ]);
        
        $carId = $request->input('car_id');
        
        // Vérifie si déjà en favoris
        $existing = Favorite::where('user_id', Auth::id())
            ->where('car_id', $carId)
            ->first();
            
        if ($existing) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Cette annonce est déjà dans vos favoris'
            ]);
        }
        
        // Crée un nouveau favori
        Favorite::create([
            'user_id' => Auth::id(),
            'car_id' => $carId
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Annonce ajoutée aux favoris'
            ]);
        }
        
        return back()->with('success', 'Annonce ajoutée aux favoris');
    }
    
    /**
     * Supprime une annonce des favoris
     */
    public function destroy(Favorite $favorite)
    {
        // Vérifie si l'utilisateur est le propriétaire
        if (Auth::id() !== $favorite->user_id) {
            abort(403);
        }
        
        $favorite->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Annonce retirée des favoris'
            ]);
        }
        
        return back()->with('success', 'Annonce retirée des favoris');
    }
}