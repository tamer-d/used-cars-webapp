<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Affiche la page d'accueil avec les annonces en vedette
     */
    public function home()
    {
        $featuredCars = Car::with(['brand', 'model', 'category'])
            ->approved()
            ->featured()
            ->latest()
            ->take(6)
            ->get();
            
        $recentCars = Car::with(['brand', 'model'])
            ->approved()
            ->latest()
            ->take(8)
            ->get();
            
        $brands = Brand::withCount('cars')->orderBy('cars_count', 'desc')->take(10)->get();
        $categories = Category::withCount('cars')->orderBy('cars_count', 'desc')->get();
        
        return view('home', compact('featuredCars', 'recentCars', 'brands', 'categories'));
    }
    
    /**
     * Liste toutes les annonces avec filtres optionnels
     */
    public function index(Request $request)
    {
        $cars = Car::with(['brand', 'model', 'category'])
            ->approved()
            ->filter($request->all())
            ->latest()
            ->paginate(12);
            
        $brands = Brand::withCount('cars')->orderBy('name')->get();
        $categories = Category::all();
        
        // Années pour les filtres (de l'année actuelle à 30 ans en arrière)
        $years = range(date('Y'), date('Y') - 30);
        
        return view('cars.index', compact('cars', 'brands', 'categories', 'years'));
    }
    
    /**
     * Affiche une annonce spécifique
     */
    public function show(Car $car)
    {
        // Vérifie si l'annonce est approuvée ou appartient à l'utilisateur connecté
        if ($car->status !== 'approved' && (!Auth::check() || Auth::id() !== $car->user_id)) {
            abort(404);
        }
        
        // Incrémente le compteur de vues
        $car->incrementViewCount();
        
        // Charge les relations
        $car->load(['user', 'brand', 'model', 'category', 'features']);
        
        // Annonces similaires
        $similarCars = Car::with(['brand', 'model'])
            ->approved()
            ->where('id', '!=', $car->id)
            ->where(function($query) use ($car) {
                $query->where('brand_id', $car->brand_id)
                    ->orWhere('category_id', $car->category_id);
            })
            ->take(4)
            ->get();
            
        return view('cars.show', compact('car', 'similarCars'));
    }
    
    /**
     * Affiche les annonces par marque
     */
    public function byBrand(Brand $brand)
    {
        $cars = Car::with(['model', 'category'])
            ->approved()
            ->where('brand_id', $brand->id)
            ->latest()
            ->paginate(12);
            
        return view('cars.by-brand', compact('cars', 'brand'));
    }
    
    /**
     * Affiche les annonces par catégorie
     */
    public function byCategory(Category $category)
    {
        $cars = Car::with(['brand', 'model'])
            ->approved()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);
            
        return view('cars.by-category', compact('cars', 'category'));
    }
    
    /**
     * Recherche d'annonces
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $cars = Car::with(['brand', 'model', 'category'])
            ->approved()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);
            
        return view('cars.search', compact('cars', 'query'));
    }
    
    /**
     * Affiche les annonces de l'utilisateur connecté
     */
    public function myCars()
    {
        $cars = Car::with(['brand', 'model'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('cars.my-cars', compact('cars'));
    }
    
    /**
     * Supprime une annonce
     */
    public function destroy(Car $car)
    {
        // Vérifie si l'utilisateur est le propriétaire ou admin
        if (Auth::id() !== $car->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $car->delete();
        
        return redirect()->route('cars.my-cars')->with('success', 'Annonce supprimée avec succès');
    }
}