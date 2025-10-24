<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'model', 'category', 'images']);

        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('brand', function($brandQuery) use ($search) {
                      $brandQuery->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('model', function($modelQuery) use ($search) {
                      $modelQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filtres
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->get('brand_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->get('year'));
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->get('fuel_type'));
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->get('transmission'));
        }

        // Tri
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'year_desc':
                $query->orderBy('year', 'desc');
                break;
            case 'mileage_asc':
                $query->orderBy('mileage', 'asc');
                break;
            case 'views_desc':
                $query->orderBy('views_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $cars = $query->paginate(12);
        
        $brands = Brand::withCount('cars')->orderBy('name')->get();
        $categories = Category::all();
        
        // Années pour les filtres (de l'année actuelle à 30 ans en arrière)
        $years = range(date('Y'), date('Y') - 30);
        
        return view('cars.index', compact('cars', 'brands', 'categories', 'years'));
    }

    public function show(Car $car)
    {
        // Suppression de la vérification du status car le champ n'existe pas
        // Maintenant toutes les voitures sont visibles
        
        // Incrémente le compteur de vues
        $car->incrementViewCount();
        
        // Charge les relations
        $car->load(['user', 'brand', 'model', 'category', 'features', 'images']);
        
        // Annonces similaires 
        $similarCars = Car::with(['brand', 'model', 'images'])
            ->where('id', '!=', $car->id)
            ->where(function($query) use ($car) {
                $query->where('brand_id', $car->brand_id)
                    ->orWhere('category_id', $car->category_id);
            })
            ->take(4)
            ->get();
            
        return view('cars.show', compact('car', 'similarCars'));
    }

    public function myCars()
    {
        $cars = Car::with(['brand', 'model', 'images'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('cars.my-cars', compact('cars'));
    }

    public function home()
    {
        $featuredCars = Car::with(['brand', 'model', 'category'])
            ->featured()
            ->latest()
            ->take(6)
            ->get();
            
        $recentCars = Car::with(['brand', 'model'])
            ->latest()
            ->take(8)
            ->get();
            
        $brands = Brand::withCount('cars')->orderBy('cars_count', 'desc')->take(10)->get();
        $categories = Category::withCount('cars')->orderBy('cars_count', 'desc')->get();
        
        return view('home', compact('featuredCars', 'recentCars', 'brands', 'categories'));
    }

    public function byCategory(Category $category)
    {
        $cars = Car::with(['brand', 'model'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);
            
        return view('cars.by-category', compact('cars', 'category'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $cars = Car::with(['brand', 'model', 'category'])
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);
            
        return view('cars.search', compact('cars', 'query'));
    }
}