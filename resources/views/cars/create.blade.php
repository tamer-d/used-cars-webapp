@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Publier une annonce</h1>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre
                            de l'annonce *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prix
                            *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">€</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required
                                min="0" step="0.01"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white pl-7 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description *</label>
                    <textarea name="description" id="description" rows="5" required
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Décrivez votre véhicule en détail (état,
                        options, historique...)</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marque
                            *</label>
                        <select name="brand_id" id="brand_id" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Sélectionner une marque</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="model_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modèle
                            *</label>
                        <select name="model_id" id="model_id" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Sélectionnez d'abord une marque</option>
                        </select>
                    </div>

                    <div>
                        <label for="category_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie *</label>
                        <select name="category_id" id="category_id" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Année
                            *</label>
                        <select name="year" id="year" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Sélectionner une année</option>
                            @foreach (range(date('Y') + 1, 1950) as $year)
                                <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="mileage"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kilométrage *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}" required
                                min="0"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">km</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="fuel_type"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Carburant *</label>
                        <select name="fuel_type" id="fuel_type" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Sélectionner un type</option>
                            <option value="Essence" {{ old('fuel_type') == 'Essence' ? 'selected' : '' }}>Essence</option>
                            <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="Électrique" {{ old('fuel_type') == 'Électrique' ? 'selected' : '' }}>Électrique
                            </option>
                            <option value="Hybride" {{ old('fuel_type') == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                            <option value="GPL" {{ old('fuel_type') == 'GPL' ? 'selected' : '' }}>GPL</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="transmission"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transmission *</label>
                        <select name="transmission" id="transmission" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Sélectionner un type</option>
                            <option value="Manuelle" {{ old('transmission') == 'Manuelle' ? 'selected' : '' }}>Manuelle
                            </option>
                            <option value="Automatique" {{ old('transmission') == 'Automatique' ? 'selected' : '' }}>
                                Automatique</option>
                            <option value="Semi-automatique"
                                {{ old('transmission') == 'Semi-automatique' ? 'selected' : '' }}>Semi-automatique</option>
                        </select>
                    </div>

                    <div>
                        <label for="location"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Localisation *</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            placeholder="Ville, Code postal">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Caractéristiques</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach ($features as $feature)
                            <div class="flex items-center">
                                <input type="checkbox" name="features[]" id="feature_{{ $feature->id }}"
                                    value="{{ $feature->id }}"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    {{ is_array(old('features')) && in_array($feature->id, old('features')) ? 'checked' : '' }}>
                                <label for="feature_{{ $feature->id }}"
                                    class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $feature->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Photos du véhicule
                        *</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="images"
                                    class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-500 hover:text-blue-500 focus-within:outline-none">
                                    <span>Télécharger des fichiers</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" multiple
                                        accept="image/*" required>
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF jusqu'à 2MB (max 10 photos)
                            </p>
                        </div>
                    </div>
                    <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('cars.index') }}"
                        class="text-gray-600 dark:text-gray-400 mr-4 hover:text-gray-900 dark:hover:text-white">
                        Annuler
                    </a>
                    <x-primary-button type="submit">
                        Publier l'annonce
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la sélection des modèles en fonction de la marque
            const brandSelect = document.getElementById('brand_id');
            const modelSelect = document.getElementById('model_id');

            brandSelect.addEventListener('change', function() {
                const brandId = this.value;

                // Réinitialiser le select des modèles
                modelSelect.innerHTML = '<option value="">Chargement des modèles...</option>';

                if (brandId) {
                    // Appel AJAX pour récupérer les modèles de la marque sélectionnée
                    fetch(`{{ route('cars.models.by.brand') }}?brand_id=${brandId}`)
                        .then(response => response.json())
                        .then(data => {
                            modelSelect.innerHTML = '<option value="">Sélectionner un modèle</option>';

                            data.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.id;
                                option.textContent = model.name;
                                modelSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des modèles:', error);
                            modelSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        });
                } else {
                    modelSelect.innerHTML = '<option value="">Sélectionnez d'
                    abord une marque < /option>';
                }
            });

            // Prévisualisation des images
            const imageInput = document.getElementById('images');
            const imagePreview = document.getElementById('image-preview');

            imageInput.addEventListener('change', function() {
                imagePreview.innerHTML = '';

                if (this.files) {
                    const filesAmount = this.files.length;

                    for (let i = 0; i < filesAmount; i++) {
                        const reader = new FileReader();

                        reader.onload = function(event) {
                            const div = document.createElement('div');
                            div.className = 'relative';

                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.className = 'w-full h-32 object-cover rounded-lg';

                            div.appendChild(img);
                            imagePreview.appendChild(div);
                        }

                        reader.readAsDataURL(this.files[i]);
                    }
                }
            });
        });
    </script>
@endsection
