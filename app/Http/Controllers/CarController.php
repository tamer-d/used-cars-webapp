<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CarModel;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'model', 'category', 'images', 'features']);

        // Recherche textuelle (keyword)
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhereHas('brand', function($brandQuery) use ($search) {
                      $brandQuery->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('model', function($modelQuery) use ($search) {
                      $modelQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filtres principaux
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->get('brand_id'));
        }

        if ($request->filled('model_id')) {
            $query->where('model_id', $request->get('model_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        // Prix
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        // Année
        if ($request->filled('min_year')) {
            $query->where('year', '>=', $request->get('min_year'));
        }
        if ($request->filled('max_year')) {
            $query->where('year', '<=', $request->get('max_year'));
        }

        // Kilométrage
        if ($request->filled('max_mileage')) {
            $query->where('mileage', '<=', $request->get('max_mileage'));
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->get('fuel_type'));
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->get('transmission'));
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->get('location') . '%');
        }

        // Filtres secondaires
        if ($request->filled('color')) {
            $query->where('color', $request->get('color'));
        }

        if ($request->filled('doors')) {
            $query->where('doors', $request->get('doors'));
        }

        // Filtres par caractéristiques
        if ($request->filled('features')) {
            $features = $request->get('features');
            if (is_array($features) && !empty($features)) {
                $query->whereHas('features', function($q) use ($features) {
                    $q->whereIn('features.id', $features);
                }, '>=', count($features)); // Toutes les caractéristiques sélectionnées
            }
        }

        // Tri
        $sortBy = $request->get('sort', 'recent');
        switch ($sortBy) {
            case 'recent':
                $query->latest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'year_desc':
                $query->orderBy('year', 'desc');
                break;
            case 'year_asc':
                $query->orderBy('year', 'asc');
                break;
            case 'mileage_asc':
                $query->orderBy('mileage', 'asc');
                break;
            case 'mileage_desc':
                $query->orderBy('mileage', 'desc');
                break;
            case 'views_desc':
                $query->orderBy('views_count', 'desc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')->latest();
                break;
            default:
                $query->latest();
        }

        $cars = $query->paginate(12);
        
        // Données pour les filtres
        $brands = Brand::withCount('cars')->orderBy('name')->get();
        $categories = Category::withCount('cars')->orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        
        // Modèles basés sur la marque sélectionnée
        $models = collect();
        if ($request->filled('brand_id')) {
            $models = CarModel::where('brand_id', $request->get('brand_id'))
                ->orderBy('name')
                ->get();
        }
        
        // Années pour les filtres
        $years = range(date('Y'), date('Y') - 30);
        
        // Couleurs disponibles
        $colors = Car::select('color')
            ->distinct()
            ->whereNotNull('color')
            ->orderBy('color')
            ->pluck('color');
            
        // Villes/régions disponibles
        $locations = Car::select('location')
            ->distinct()
            ->whereNotNull('location')
            ->orderBy('location')
            ->pluck('location');
        
        return view('cars.index', compact(
            'cars', 'brands', 'categories', 'features', 'models', 
            'years', 'colors', 'locations'
        ));
    }

    // Méthode AJAX pour récupérer les modèles d'une marque
    public function getModelsByBrand(Request $request)
    {
        $brandId = $request->get('brand_id');
        $models = CarModel::where('brand_id', $brandId)->orderBy('name')->get();
        
        return response()->json($models);
    }

    public function show(Car $car)
    {
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
        
        $brands = Brand::withCount('cars')
        ->orderBy('cars_count', 'desc')
        ->get();

        $categories = Category::withCount('cars')
        ->orderBy('cars_count', 'desc')
        ->get();

        return view('welcome', compact('featuredCars', 'recentCars', 'brands', 'categories'));
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

    public function create()
    {
        // Récupérer les marques pour le formulaire
        $brands = Brand::orderBy('name')->get();
        
        // Récupérer les catégories pour le formulaire
        $categories = Category::orderBy('name')->get();
        
        // Récupérer les caractéristiques disponibles
        $features = Feature::orderBy('name')->get();
        
        return view('cars.create', compact('brands', 'categories', 'features'));
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:car_models,id',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|string',
            'transmission' => 'required|string',
            'location' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'doors' => 'required|integer|in:2,3,4,5',
            'engine_size' => 'nullable|string|max:20',
            'power' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,webp|max:5120', // 5MB max
        ]);
        
        // Créer l'annonce
        $car = Car::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'brand_id' => $validated['brand_id'],
            'model_id' => $validated['model_id'],
            'category_id' => $validated['category_id'],
            'year' => $validated['year'],
            'mileage' => $validated['mileage'],
            'fuel_type' => $validated['fuel_type'],
            'transmission' => $validated['transmission'],
            'location' => $validated['location'],
            'color' => $validated['color'],
            'doors' => $validated['doors'],
            'engine_size' => $validated['engine_size'] ?? null,
            'power' => $validated['power'] ?? null,
            'is_featured' => false, // Par défaut, l'annonce n'est pas mise en avant
            'views_count' => 0,
        ]);
        
        // Associer les caractéristiques
        if (isset($validated['features'])) {
            $car->features()->attach($validated['features']);
        }
        
        // Traiter les images
        if ($request->hasFile('images')) {
            $this->uploadCarImages($car, $request->file('images'));
        }
        
        return redirect()->route('cars.show', $car)
            ->with('success', 'Votre annonce a été publiée avec succès!');
    }

    public function edit(Car $car)
    {
        // Vérifier que l'utilisateur est bien le propriétaire de l'annonce
        if ($car->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }
        
        // Récupérer les données nécessaires pour le formulaire
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        $models = CarModel::where('brand_id', $car->brand_id)->orderBy('name')->get();
        
        // Récupérer les IDs des caractéristiques déjà associées
        $selectedFeatures = $car->features->pluck('id')->toArray();
        
        return view('cars.edit', compact('car', 'brands', 'categories', 'features', 'models', 'selectedFeatures'));
    }

    public function update(Request $request, Car $car)
    {
        // Vérifier que l'utilisateur est bien le propriétaire de l'annonce
        if ($car->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }
        
        // Validation des données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:car_models,id',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|string',
            'transmission' => 'required|string',
            'location' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'doors' => 'required|integer|in:2,3,4,5',
            'engine_size' => 'nullable|string|max:20',
            'power' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,webp|max:5120', // 5MB max
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:car_images,id',
        ]);
        
        // Mettre à jour l'annonce
        $car->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'brand_id' => $validated['brand_id'],
            'model_id' => $validated['model_id'],
            'category_id' => $validated['category_id'],
            'year' => $validated['year'],
            'mileage' => $validated['mileage'],
            'fuel_type' => $validated['fuel_type'],
            'transmission' => $validated['transmission'],
            'location' => $validated['location'],
            'color' => $validated['color'],
            'doors' => $validated['doors'],
            'engine_size' => $validated['engine_size'] ?? null,
            'power' => $validated['power'] ?? null,
        ]);
        
        // Mettre à jour les caractéristiques
        if (isset($validated['features'])) {
            $car->features()->sync($validated['features']);
        } else {
            $car->features()->detach();
        }
        
        // Supprimer les images sélectionnées
        if (isset($validated['delete_images']) && is_array($validated['delete_images'])) {
            foreach ($validated['delete_images'] as $imageId) {
                $image = $car->images()->find($imageId);
                if ($image) {
                    // Supprimer le fichier physique
                    Storage::disk('public')->delete($image->path);
                    // Supprimer l'enregistrement
                    $image->delete();
                }
            }
        }
        
        // Ajouter de nouvelles images si nécessaire
        if ($request->hasFile('images')) {
            // Vérifier que le nombre total d'images ne dépasse pas 10
            $currentImagesCount = $car->images()->count();
            $newImagesCount = count($request->file('images'));
            
            if ($currentImagesCount + $newImagesCount <= 10) {
                $this->uploadCarImages($car, $request->file('images'));
            } else {
                return redirect()->back()->withErrors(['images' => 'Le nombre total d\'images ne peut pas dépasser 10.']);
            }
        }
        
        return redirect()->route('cars.show', $car)
            ->with('success', 'Votre annonce a été mise à jour avec succès!');
    }

    public function destroy(Car $car)
    {
        // Vérifier que l'utilisateur est bien le propriétaire de l'annonce
        if ($car->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette annonce.');
        }
        
        // Supprimer les images associées
        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        
        // Supprimer l'annonce (les relations seront supprimées automatiquement grâce aux contraintes de clé étrangère)
        $car->delete();
        
        return redirect()->route('cars.my-cars')
            ->with('success', 'Votre annonce a été supprimée avec succès.');
    }

    public function toggleFavorite(Car $car)
    {
        $user = Auth::user();
        
        // Vérifier si la voiture est déjà dans les favoris
        $favorite = $user->favorites()->where('car_id', $car->id)->first();
        
        if ($favorite) {
            // Supprimer des favoris
            $favorite->delete();
            $message = 'Annonce retirée de vos favoris.';
        } else {
            // Ajouter aux favoris
            $user->favorites()->create(['car_id' => $car->id]);
            $message = 'Annonce ajoutée à vos favoris.';
        }
        
        if (request()->ajax()) {
            return response()->json(['message' => $message]);
        }
        
        return back()->with('success', $message);
    }

    public function favorites()
    {
        $favorites = Auth::user()->favorites()->with(['car.brand', 'car.model', 'car.images'])->latest()->paginate(12);
        
        return view('cars.favorites', compact('favorites'));
    }

    /**
     * Upload et enregistre les images d'une voiture
     *
     * @param Car $car
     * @param array $images
     * @return void
     */
    private function uploadCarImages(Car $car, array $images)
    {
        foreach ($images as $image) {
            // Générer un nom unique pour l'image
            $filename = 'car-' . $car->id . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Stocker l'image
            $path = $image->storeAs('cars', $filename, 'public');
            
            // Créer l'enregistrement dans la base de données
            $car->images()->create([
                'path' => $path,
                'main' => $car->images()->count() === 0, // La première image est définie comme principale
            ]);
        }
    }
}