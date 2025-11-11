<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-4 lg:px-6">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Post a Listing</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Fill out the form below to publish your vehicle listing.
                </p>
            </div>

            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Block 1: Main Information -->
                <div
                    class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mb-4 transition-transform transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full mr-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Main Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Listing Title -->
                        <div class="col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Listing Title *
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500"
                                required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description *
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500"
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price (€) *
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="price" id="price" value="{{ old('price') }}"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white pr-10 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="0.00" step="0.01" min="0" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location (Wilayas d'Algérie) -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Location (Wilaya) *
                            </label>
                            <select name="location" id="location"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a wilaya</option>
                                <option value="Adrar" {{ old('location') == 'Adrar' ? 'selected' : '' }}>01 - Adrar
                                </option>
                                <option value="Chlef" {{ old('location') == 'Chlef' ? 'selected' : '' }}>02 - Chlef
                                </option>
                                <option value="Laghouat" {{ old('location') == 'Laghouat' ? 'selected' : '' }}>03 -
                                    Laghouat</option>
                                <option value="Oum El Bouaghi"
                                    {{ old('location') == 'Oum El Bouaghi' ? 'selected' : '' }}>04 - Oum El Bouaghi
                                </option>
                                <option value="Batna" {{ old('location') == 'Batna' ? 'selected' : '' }}>05 - Batna
                                </option>
                                <option value="Béjaïa" {{ old('location') == 'Béjaïa' ? 'selected' : '' }}>06 - Béjaïa
                                </option>
                                <option value="Biskra" {{ old('location') == 'Biskra' ? 'selected' : '' }}>07 - Biskra
                                </option>
                                <option value="Béchar" {{ old('location') == 'Béchar' ? 'selected' : '' }}>08 - Béchar
                                </option>
                                <option value="Blida" {{ old('location') == 'Blida' ? 'selected' : '' }}>09 - Blida
                                </option>
                                <option value="Bouira" {{ old('location') == 'Bouira' ? 'selected' : '' }}>10 - Bouira
                                </option>
                                <option value="Tamanrasset" {{ old('location') == 'Tamanrasset' ? 'selected' : '' }}>11
                                    - Tamanrasset</option>
                                <option value="Tébessa" {{ old('location') == 'Tébessa' ? 'selected' : '' }}>12 -
                                    Tébessa</option>
                                <option value="Tlemcen" {{ old('location') == 'Tlemcen' ? 'selected' : '' }}>13 -
                                    Tlemcen</option>
                                <option value="Tiaret" {{ old('location') == 'Tiaret' ? 'selected' : '' }}>14 - Tiaret
                                </option>
                                <option value="Tizi Ouzou" {{ old('location') == 'Tizi Ouzou' ? 'selected' : '' }}>15 -
                                    Tizi Ouzou</option>
                                <option value="Alger" {{ old('location') == 'Alger' ? 'selected' : '' }}>16 - Alger
                                </option>
                                <option value="Djelfa" {{ old('location') == 'Djelfa' ? 'selected' : '' }}>17 - Djelfa
                                </option>
                                <option value="Jijel" {{ old('location') == 'Jijel' ? 'selected' : '' }}>18 - Jijel
                                </option>
                                <option value="Sétif" {{ old('location') == 'Sétif' ? 'selected' : '' }}>19 - Sétif
                                </option>
                                <option value="Saïda" {{ old('location') == 'Saïda' ? 'selected' : '' }}>20 - Saïda
                                </option>
                                <option value="Skikda" {{ old('location') == 'Skikda' ? 'selected' : '' }}>21 - Skikda
                                </option>
                                <option value="Sidi Bel Abbès"
                                    {{ old('location') == 'Sidi Bel Abbès' ? 'selected' : '' }}>22 - Sidi Bel Abbès
                                </option>
                                <option value="Annaba" {{ old('location') == 'Annaba' ? 'selected' : '' }}>23 - Annaba
                                </option>
                                <option value="Guelma" {{ old('location') == 'Guelma' ? 'selected' : '' }}>24 - Guelma
                                </option>
                                <option value="Constantine" {{ old('location') == 'Constantine' ? 'selected' : '' }}>25
                                    - Constantine</option>
                                <option value="Médéa" {{ old('location') == 'Médéa' ? 'selected' : '' }}>26 - Médéa
                                </option>
                                <option value="Mostaganem" {{ old('location') == 'Mostaganem' ? 'selected' : '' }}>27 -
                                    Mostaganem</option>
                                <option value="M'Sila" {{ old('location') == 'M\'Sila' ? 'selected' : '' }}>28 - M'Sila
                                </option>
                                <option value="Mascara" {{ old('location') == 'Mascara' ? 'selected' : '' }}>29 -
                                    Mascara</option>
                                <option value="Ouargla" {{ old('location') == 'Ouargla' ? 'selected' : '' }}>30 -
                                    Ouargla</option>
                                <option value="Oran" {{ old('location') == 'Oran' ? 'selected' : '' }}>31 - Oran
                                </option>
                                <option value="El Bayadh" {{ old('location') == 'El Bayadh' ? 'selected' : '' }}>32 -
                                    El Bayadh</option>
                                <option value="Illizi" {{ old('location') == 'Illizi' ? 'selected' : '' }}>33 - Illizi
                                </option>
                                <option value="Bordj Bou Arreridj"
                                    {{ old('location') == 'Bordj Bou Arreridj' ? 'selected' : '' }}>34 - Bordj Bou
                                    Arreridj</option>
                                <option value="Boumerdès" {{ old('location') == 'Boumerdès' ? 'selected' : '' }}>35 -
                                    Boumerdès</option>
                                <option value="El Tarf" {{ old('location') == 'El Tarf' ? 'selected' : '' }}>36 - El
                                    Tarf</option>
                                <option value="Tindouf" {{ old('location') == 'Tindouf' ? 'selected' : '' }}>37 -
                                    Tindouf</option>
                                <option value="Tissemsilt" {{ old('location') == 'Tissemsilt' ? 'selected' : '' }}>38 -
                                    Tissemsilt</option>
                                <option value="El Oued" {{ old('location') == 'El Oued' ? 'selected' : '' }}>39 - El
                                    Oued</option>
                                <option value="Khenchela" {{ old('location') == 'Khenchela' ? 'selected' : '' }}>40 -
                                    Khenchela</option>
                                <option value="Souk Ahras" {{ old('location') == 'Souk Ahras' ? 'selected' : '' }}>41 -
                                    Souk Ahras</option>
                                <option value="Tipaza" {{ old('location') == 'Tipaza' ? 'selected' : '' }}>42 - Tipaza
                                </option>
                                <option value="Mila" {{ old('location') == 'Mila' ? 'selected' : '' }}>43 - Mila
                                </option>
                                <option value="Aïn Defla" {{ old('location') == 'Aïn Defla' ? 'selected' : '' }}>44 -
                                    Aïn Defla</option>
                                <option value="Naâma" {{ old('location') == 'Naâma' ? 'selected' : '' }}>45 - Naâma
                                </option>
                                <option value="Aïn Témouchent"
                                    {{ old('location') == 'Aïn Témouchent' ? 'selected' : '' }}>46 - Aïn Témouchent
                                </option>
                                <option value="Ghardaïa" {{ old('location') == 'Ghardaïa' ? 'selected' : '' }}>47 -
                                    Ghardaïa</option>
                                <option value="Relizane" {{ old('location') == 'Relizane' ? 'selected' : '' }}>48 -
                                    Relizane</option>
                            </select>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Block 2: Vehicle Features -->
                <div
                    class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mb-4 transition-transform transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full mr-2">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Vehicle Features</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Brand -->
                        <div>
                            <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Brand *
                            </label>
                            <select name="brand_id" id="brand_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div>
                            <label for="model_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Model *
                            </label>
                            <select name="model_id" id="model_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a brand first</option>
                            </select>
                            @error('model_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category *
                            </label>
                            <select name="category_id" id="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Year -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Year *
                            </label>
                            <select name="year" id="year"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a year</option>
                                @for ($i = date('Y'); $i >= date('Y') - 30; $i--)
                                    <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mileage -->
                        <div>
                            <label for="mileage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Mileage *
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white pr-10 focus:border-blue-500 focus:ring-blue-500"
                                    min="0" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">km</span>
                                </div>
                            </div>
                            @error('mileage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fuel Type -->
                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fuel *
                            </label>
                            <select name="fuel_type" id="fuel_type"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a type</option>
                                <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel
                                </option>
                                <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol
                                </option>
                                <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>
                                    Electric</option>
                                <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid
                                </option>
                                <option value="lpg" {{ old('fuel_type') == 'lpg' ? 'selected' : '' }}>LPG</option>
                            </select>
                            @error('fuel_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transmission -->
                        <div>
                            <label for="transmission"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Transmission *
                            </label>
                            <select name="transmission" id="transmission"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                                <option value="">Select a type</option>
                                <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual
                                </option>
                                <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>
                                    Automatic</option>
                                <option value="Semi-automatic"
                                    {{ old('transmission') == 'Semi-automatic' ? 'selected' : '' }}>Semi-automatic
                                </option>
                            </select>
                            @error('transmission')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color with color picker -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Color *
                            </label>
                            <div class="flex space-x-2 mt-1">
                                <input type="color" id="color-picker"
                                    class="h-10 w-10 border-gray-300 dark:border-gray-700 rounded cursor-pointer"
                                    value="{{ old('color-hex', '#ffffff') }}">
                                <input type="text" name="color" id="color" value="{{ old('color') }}"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                            </div>
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Number of Doors -->
                        <div>
                            <label for="doors" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Number of Doors
                            </label>
                            <select name="doors" id="doors"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="3" {{ old('doors') == '3' ? 'selected' : '' }}>3</option>
                                <option value="5" {{ old('doors', '5') == '5' ? 'selected' : '' }}>5</option>
                                <option value="2" {{ old('doors') == '2' ? 'selected' : '' }}>2</option>
                                <option value="4" {{ old('doors') == '4' ? 'selected' : '' }}>4</option>
                            </select>
                            @error('doors')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Engine Size -->
                        <div>
                            <label for="engine_size"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Engine Size
                            </label>
                            <input type="text" name="engine_size" id="engine_size"
                                value="{{ old('engine_size') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="E.g., 2.0L, 1600cc">
                            @error('engine_size')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Power -->
                        <div>
                            <label for="power" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Power (HP)
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="power" id="power" value="{{ old('power') }}"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white pr-10 focus:border-blue-500 focus:ring-blue-500"
                                    min="0">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">HP</span>
                                </div>
                            </div>
                            @error('power')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Equipment and Options -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Equipment and Options
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach ($features as $feature)
                                <div class="flex items-center">
                                    <input type="checkbox" name="features[]" id="feature-{{ $feature->id }}"
                                        value="{{ $feature->id }}"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        {{ in_array($feature->id, old('features', [])) ? 'checked' : '' }}>
                                    <label for="feature-{{ $feature->id }}"
                                        class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        {{ $feature->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('features')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Block 3: Media -->
                <div
                    class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mb-4 transition-transform transform hover:scale-105">
                    <div class="flex items-center mb-3">
                        <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded-full mr-2">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Media</h2>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Vehicle Photos *
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                            Add at least one photo of your vehicle. You can add up to 10.
                        </p>

                        <div class="mt-2 flex justify-center px-4 pt-4 pb-4 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md"
                            id="drop-area">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="file-upload"
                                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload Files</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only"
                                            multiple accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, WEBP up to 5MB
                                </p>
                            </div>
                        </div>

                        <div id="preview-container" class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                            <!-- Image previews will be added here dynamically -->
                        </div>

                        <div id="image-count" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            0 image(s) selected
                        </div>

                        <div id="error-container" class="mt-1 text-red-500 text-sm hidden"></div>

                        <!-- Hidden field that will contain the selected images -->
                        <div id="images-container">
                            <!-- Inputs will be generated dynamically here -->
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('cars.index') }}"
                        class="inline-flex justify-center py-1 px-3 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-1 px-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                        Publish Listing
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Existing code for model management
            const brandSelect = document.getElementById('brand_id');
            const modelSelect = document.getElementById('model_id');

            brandSelect.addEventListener('change', function() {
                // Your existing code to load models
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

            // Color picker functionality
            const colorPicker = document.getElementById('color-picker');
            const colorInput = document.getElementById('color');

            // Set initial color if there's a value
            if (colorInput.value) {
                try {
                    // Try to convert the color name to hex
                    const tempElement = document.createElement('div');
                    tempElement.style.color = colorInput.value;
                    document.body.appendChild(tempElement);
                    const computedColor = window.getComputedStyle(tempElement).color;
                    document.body.removeChild(tempElement);

                    // Convert rgb to hex
                    if (computedColor.startsWith('rgb')) {
                        const rgb = computedColor.match(/\d+/g);
                        if (rgb && rgb.length === 3) {
                            const hex = '#' + rgb.map(x => {
                                const hex = parseInt(x).toString(16);
                                return hex.length === 1 ? '0' + hex : hex;
                            }).join('');
                            colorPicker.value = hex;
                        }
                    }
                } catch (e) {
                    console.error('Error setting initial color:', e);
                }
            }

            // Update text input when color picker changes
            colorPicker.addEventListener('input', function() {
                // Convert hex to color name or keep hex if no name exists
                const hexColor = this.value;

                // Get the closest color name
                const colorName = getColorNameFromHex(hexColor);
                colorInput.value = colorName || hexColor;
            });

            // Update color picker when text input changes
            colorInput.addEventListener('input', function() {
                try {
                    const tempElement = document.createElement('div');
                    tempElement.style.color = this.value;
                    document.body.appendChild(tempElement);
                    const computedColor = window.getComputedStyle(tempElement).color;
                    document.body.removeChild(tempElement);

                    // Convert rgb to hex
                    if (computedColor.startsWith('rgb')) {
                        const rgb = computedColor.match(/\d+/g);
                        if (rgb && rgb.length === 3) {
                            const hex = '#' + rgb.map(x => {
                                const hex = parseInt(x).toString(16);
                                return hex.length === 1 ? '0' + hex : hex;
                            }).join('');
                            colorPicker.value = hex;
                        }
                    }
                } catch (e) {
                    // If error, don't update the color picker
                }
            });

            // Function to get color name from hex
            function getColorNameFromHex(hex) {
                // Basic color mapping
                const colorMap = {
                    '#000000': 'Black',
                    '#FFFFFF': 'White',
                    '#FF0000': 'Red',
                    '#00FF00': 'Green',
                    '#0000FF': 'Blue',
                    '#FFFF00': 'Yellow',
                    '#00FFFF': 'Cyan',
                    '#FF00FF': 'Magenta',
                    '#C0C0C0': 'Silver',
                    '#808080': 'Gray',
                    '#800000': 'Maroon',
                    '#808000': 'Olive',
                    '#008000': 'Green',
                    '#800080': 'Purple',
                    '#008080': 'Teal',
                    '#000080': 'Navy',
                    '#FFA500': 'Orange',
                    '#A52A2A': 'Brown',
                    '#FFC0CB': 'Pink',
                    '#FFD700': 'Gold',
                    '#ADFF2F': 'GreenYellow',
                    '#B8860B': 'DarkGoldenrod',
                    '#D2691E': 'Chocolate',
                    '#DC143C': 'Crimson',
                    '#4682B4': 'SteelBlue',
                    '#2E8B57': 'SeaGreen',
                    '#9370DB': 'MediumPurple',
                    '#F5F5DC': 'Beige',
                };

                // Normalize hex to uppercase
                const normalizedHex = hex.toUpperCase();

                // Return the color name or null if not found
                return colorMap[normalizedHex] || null;
            }

            // New code for image management
            const fileInput = document.getElementById('file-upload');
            const previewContainer = document.getElementById('preview-container');
            const dropArea = document.getElementById('drop-area');
            const errorContainer = document.getElementById('error-container');
            const imageCountDisplay = document.getElementById('image-count');
            const imagesContainer = document.getElementById('images-container');
            const form = document.querySelector('form');

            // Array to store selected files
            let selectedFiles = [];

            const maxFiles = 10;
            const maxFileSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            // Function to display errors
            function showError(message) {
                errorContainer.textContent = message;
                errorContainer.classList.remove('hidden');
                setTimeout(() => {
                    errorContainer.classList.add('hidden');
                }, 5000);
            }

            // Function to update image count
            function updateImageCount() {
                imageCountDisplay.textContent = `${selectedFiles.length} image(s) selected`;
            }

            // Function to preview images
            function updatePreview() {
                // Clear the preview container
                previewContainer.innerHTML = '';
                imagesContainer.innerHTML = '';

                // Process each file
                selectedFiles.forEach((file, index) => {
                    // Create a preview item
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative group';

                    // Create the preview image
                    const img = document.createElement('img');
                    img.className = 'h-24 w-full object-cover rounded-md';

                    // Read the file and display the preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    previewItem.appendChild(img);

                    // Create the remove button
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
                        // Remove the file from the array
                        selectedFiles.splice(index, 1);
                        // Update the preview
                        updatePreview();
                        updateImageCount();
                    });
                    previewItem.appendChild(removeButton);

                    // Add to the preview container
                    previewContainer.appendChild(previewItem);

                    // Create a hidden input for this file
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'file';
                    hiddenInput.name = `images[]`;
                    hiddenInput.classList.add('hidden');
                    hiddenInput.dataset.index = index;

                    // Create a DataTransfer object to assign the file to the input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    hiddenInput.files = dataTransfer.files;

                    // Add the input to the form
                    imagesContainer.appendChild(hiddenInput);
                });
            }

            // Function to add files to the selection
            function addFiles(files) {
                // Check the total number of files
                if (selectedFiles.length + files.length > maxFiles) {
                    showError(`You cannot upload more than ${maxFiles} images in total.`);
                    return;
                }

                // Filter and add new files
                Array.from(files).forEach(file => {
                    // Check file type
                    if (!allowedTypes.includes(file.type)) {
                        showError(`The file "${file.name}" is not a valid image type.`);
                        return;
                    }

                    // Check file size
                    if (file.size > maxFileSize) {
                        showError(`The file "${file.name}" exceeds the maximum size of 5MB.`);
                        return;
                    }

                    // Add the file to the array
                    selectedFiles.push(file);
                });

                // Update preview and count
                updatePreview();
                updateImageCount();
            }

            // Listen for changes on the file input
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    addFiles(this.files);
                    // Reset the input to allow selecting the same file again
                    this.value = '';
                }
            });

            // Handle drag and drop
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

            // Ensure the form is correctly submitted with images
            form.addEventListener('submit', function(e) {
                if (selectedFiles.length === 0) {
                    e.preventDefault();
                    showError('Please add at least one image of your vehicle.');
                }
            });
        });
    </script>
</x-app-layout>
