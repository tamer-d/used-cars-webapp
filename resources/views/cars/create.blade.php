<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Post a Listing</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Fill out the form below to create your vehicle listing.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Block 1: Vehicle Information -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 dark:bg-blue-900 p-1 rounded-full mr-2">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Vehicle Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Listing Title
                                *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 right-6 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">DA</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" required
                                    min="0" step="0.01"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white pl-7 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label for="brand_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Brand *</label>
                            <select name="brand_id" id="brand_id" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select a brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="model_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Model *</label>
                            <select name="model_id" id="model_id" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select a brand first</option>
                            </select>
                        </div>

                        <div>
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category
                                *</label>
                            <select name="category_id" id="category_id" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="year"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year *</label>
                            <select name="year" id="year" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select a year</option>
                                @foreach (range(date('Y') + 1, 1950) as $year)
                                    <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="mileage"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mileage
                                *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}"
                                    required min="0"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">km</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="fuel_type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fuel Type
                                *</label>
                            <select name="fuel_type" id="fuel_type" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select a type</option>
                                <option value="Gasoline" {{ old('fuel_type') == 'Gasoline' ? 'selected' : '' }}>
                                    Gasoline</option>
                                <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel
                                </option>
                                <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>
                                    Electric</option>
                                <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid
                                </option>
                                <option value="LPG" {{ old('fuel_type') == 'LPG' ? 'selected' : '' }}>LPG</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Block 2: Listing Details -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 dark:bg-green-900 p-1 rounded-full mr-2">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Listing Details</h2>
                    </div>

                    <div class="mb-6">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description
                            *</label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Describe your vehicle in detail
                            (condition, options, history...)</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="transmission"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transmission
                                *</label>
                            <select name="transmission" id="transmission" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select a type</option>
                                <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual
                                </option>
                                <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>
                                    Automatic</option>
                                <option value="Semi-Automatic"
                                    {{ old('transmission') == 'Semi-Automatic' ? 'selected' : '' }}>Semi-Automatic
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="location"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location
                                *</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                placeholder="City, Zip code">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Features</label>
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
                </div>

                <!-- Block 3: Media -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded-full mr-3">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Media</h2>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Photos du véhicule *
                        </label>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Ajoutez au moins une photo de votre véhicule. Vous pouvez en ajouter jusqu'à 10.
                        </p>

                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md"
                            id="drop-area">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="file-upload"
                                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none">
                                        <span>Télécharger des fichiers</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only"
                                            multiple accept="image/*">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, WEBP jusqu'à 5MB
                                </p>
                            </div>
                        </div>

                        <div id="preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- Les aperçus des images seront ajoutés ici dynamiquement -->
                        </div>

                        <div id="image-count" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            0 image(s) sélectionnée(s)
                        </div>

                        <div id="error-container" class="mt-2 text-red-500 text-sm hidden"></div>

                        <!-- Champ caché qui contiendra les images sélectionnées -->
                        <div id="images-container">
                            <!-- Les inputs seront générés dynamiquement ici -->
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a href="{{ route('cars.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancel
                    </a>
                    <x-primary-button type="submit" class="px-6 py-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Publish Listing
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Code existant pour la gestion des modèles
            const brandSelect = document.getElementById('brand_id');
            const modelSelect = document.getElementById('model_id');

            brandSelect.addEventListener('change', function() {
                // Votre code existant pour charger les modèles
                const brandId = this.value;

                // Reset model select
                modelSelect.innerHTML = '<option value="">Loading models...</option>';

                if (brandId) {
                    // AJAX call to fetch models for the selected brand
                    fetch(`{{ route('api.models-by-brand') }}?brand_id=${brandId}`)
                        .then(response => response.json())
                        .then(data => {
                            modelSelect.innerHTML = '<option value="">Select a model</option>';

                            data.forEach(model => {
                                const option = document.createElement('option');
                                option.value = model.id;
                                option.textContent = model.name;
                                modelSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching models:', error);
                            modelSelect.innerHTML = '<option value="">Loading error</option>';
                        });
                } else {
                    modelSelect.innerHTML = '<option value="">Select a brand first</option>';
                }
            });

            // Nouveau code pour la gestion des images
            const fileInput = document.getElementById('file-upload');
            const previewContainer = document.getElementById('preview-container');
            const dropArea = document.getElementById('drop-area');
            const errorContainer = document.getElementById('error-container');
            const imageCountDisplay = document.getElementById('image-count');
            const imagesContainer = document.getElementById('images-container');
            const form = document.querySelector('form');

            // Tableau pour stocker les fichiers sélectionnés
            let selectedFiles = [];

            const maxFiles = 10;
            const maxFileSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            // Fonction pour afficher les erreurs
            function showError(message) {
                errorContainer.textContent = message;
                errorContainer.classList.remove('hidden');
                setTimeout(() => {
                    errorContainer.classList.add('hidden');
                }, 5000);
            }

            // Fonction pour mettre à jour le compteur d'images
            function updateImageCount() {
                imageCountDisplay.textContent = `${selectedFiles.length} image(s) sélectionnée(s)`;
            }

            // Fonction pour prévisualiser les images
            function updatePreview() {
                // Vider le conteneur de prévisualisation
                previewContainer.innerHTML = '';
                imagesContainer.innerHTML = '';

                // Traiter chaque fichier
                selectedFiles.forEach((file, index) => {
                    // Créer un élément de prévisualisation
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative group';

                    // Créer l'image de prévisualisation
                    const img = document.createElement('img');
                    img.className = 'h-32 w-full object-cover rounded-lg';

                    // Lire le fichier et afficher l'aperçu
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    previewItem.appendChild(img);

                    // Créer le bouton de suppression
                    const removeButton = document.createElement('button');
                    removeButton.className =
                        'absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity';
                    removeButton.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                `;
                    removeButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        // Supprimer le fichier du tableau
                        selectedFiles.splice(index, 1);
                        // Mettre à jour l'aperçu
                        updatePreview();
                        updateImageCount();
                    });
                    previewItem.appendChild(removeButton);

                    // Ajouter au conteneur d'aperçu
                    previewContainer.appendChild(previewItem);

                    // Créer un input file caché pour ce fichier
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'file';
                    hiddenInput.name = `images[]`;
                    hiddenInput.classList.add('hidden');
                    hiddenInput.dataset.index = index;

                    // Créer un objet DataTransfer pour pouvoir assigner le fichier à l'input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    hiddenInput.files = dataTransfer.files;

                    // Ajouter l'input au formulaire
                    imagesContainer.appendChild(hiddenInput);
                });
            }

            // Fonction pour ajouter des fichiers à la sélection
            function addFiles(files) {
                // Vérifier le nombre total de fichiers
                if (selectedFiles.length + files.length > maxFiles) {
                    showError(`Vous ne pouvez pas télécharger plus de ${maxFiles} images au total.`);
                    return;
                }

                // Filtrer et ajouter les nouveaux fichiers
                Array.from(files).forEach(file => {
                    // Vérifier le type de fichier
                    if (!allowedTypes.includes(file.type)) {
                        showError(`Le fichier "${file.name}" n'est pas un type d'image valide.`);
                        return;
                    }

                    // Vérifier la taille du fichier
                    if (file.size > maxFileSize) {
                        showError(`Le fichier "${file.name}" dépasse la taille maximale de 5MB.`);
                        return;
                    }

                    // Ajouter le fichier au tableau
                    selectedFiles.push(file);
                });

                // Mettre à jour l'aperçu et le compteur
                updatePreview();
                updateImageCount();
            }

            // Écouter le changement de l'input file
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    addFiles(this.files);
                    // Réinitialiser l'input pour permettre la sélection du même fichier
                    this.value = '';
                }
            });

            // Gérer le glisser-déposer
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.remove('border-blue-500', 'bg-blue-50',
                        'dark:bg-blue-900/20');
                }, false);
            });

            dropArea.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    addFiles(files);
                }
            }, false);

            // S'assurer que le formulaire est correctement soumis avec les images
            form.addEventListener('submit', function(e) {
                if (selectedFiles.length === 0) {
                    e.preventDefault();
                    showError('Veuillez ajouter au moins une image de votre véhicule.');
                }
            });
        });
    </script>

</x-app-layout>
