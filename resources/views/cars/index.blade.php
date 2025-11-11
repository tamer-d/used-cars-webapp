<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Header avec titre et bouton d'ajout -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Discover Our Cars</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $cars->total() }} listings available</p>
                    </div>
                    @auth
                        <a href="{{ route('cars.create') }}"
                            class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Sell My Car
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar avec filtres -->
                <div class="lg:w-80 flex-shrink-0">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 sticky top-8">
                        <form method="GET" action="{{ route('cars.index') }}" id="filtersForm">
                            <!-- Header des filtres -->
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filters</h3>
                                    <button type="button" onclick="resetFilters()"
                                        class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                        Reset
                                    </button>
                                </div>
                            </div>

                            <div class="p-6 space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                                <!-- Search Bar -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Search
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Brand, model, keyword..."
                                            class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Filters -->
                                <div class="space-y-4">
                                    <button type="button" onclick="toggleSection('main-filters')"
                                        class="w-full flex items-center justify-between text-left text-sm font-medium text-gray-900 dark:text-white">
                                        <span>Main Filters</span>
                                        <svg class="w-5 h-5 transform transition-transform" id="main-filters-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div id="main-filters" class="space-y-4">
                                        <!-- Brand -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Brand
                                            </label>
                                            <select name="brand_id" id="brand_select" onchange="loadModels()"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All Brands</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }} ({{ $brand->cars_count }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Model -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Model
                                            </label>
                                            <select name="model_id" id="model_select"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All Models</option>
                                                @foreach ($models as $model)
                                                    <option value="{{ $model->id }}"
                                                        {{ request('model_id') == $model->id ? 'selected' : '' }}>
                                                        {{ $model->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Category -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Category
                                            </label>
                                            <select name="category_id"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All Categories</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Price -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Price (€)
                                            </label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="number" name="min_price"
                                                    value="{{ request('min_price') }}" placeholder="Min"
                                                    class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <input type="number" name="max_price"
                                                    value="{{ request('max_price') }}" placeholder="Max"
                                                    class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>

                                        <!-- Year -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Year
                                            </label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <select name="min_year"
                                                    class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                    <option value="">From</option>
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}"
                                                            {{ request('min_year') == $year ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <select name="max_year"
                                                    class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                    <option value="">To</option>
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year }}"
                                                            {{ request('max_year') == $year ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Mileage -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Max Mileage (km)
                                            </label>
                                            <select name="max_mileage"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All</option>
                                                <option value="50000"
                                                    {{ request('max_mileage') == '50000' ? 'selected' : '' }}>Less than
                                                    50,000 km</option>
                                                <option value="100000"
                                                    {{ request('max_mileage') == '100000' ? 'selected' : '' }}>Less
                                                    than
                                                    100,000 km</option>
                                                <option value="150000"
                                                    {{ request('max_mileage') == '150000' ? 'selected' : '' }}>Less
                                                    than
                                                    150,000 km</option>
                                                <option value="200000"
                                                    {{ request('max_mileage') == '200000' ? 'selected' : '' }}>Less
                                                    than
                                                    200,000 km</option>
                                            </select>
                                        </div>

                                        <!-- Fuel Type -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Fuel Type
                                            </label>
                                            <select name="fuel_type"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All</option>
                                                <option value="essence"
                                                    {{ request('fuel_type') == 'essence' ? 'selected' : '' }}>Gasoline
                                                </option>
                                                <option value="diesel"
                                                    {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel
                                                </option>
                                                <option value="hybride"
                                                    {{ request('fuel_type') == 'hybride' ? 'selected' : '' }}>Hybrid
                                                </option>
                                                <option value="électrique"
                                                    {{ request('fuel_type') == 'électrique' ? 'selected' : '' }}>
                                                    Electric</option>
                                                <option value="gpl"
                                                    {{ request('fuel_type') == 'gpl' ? 'selected' : '' }}>LPG</option>
                                            </select>
                                        </div>

                                        <!-- Location -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Location
                                            </label>
                                            <input type="text" name="location" value="{{ request('location') }}"
                                                placeholder="City or region"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Secondary Filters -->
                                <div class="space-y-4">
                                    <button type="button" onclick="toggleSection('secondary-filters')"
                                        class="w-full flex items-center justify-between text-left text-sm font-medium text-gray-900 dark:text-white">
                                        <span>Features & Comfort</span>
                                        <svg class="w-5 h-5 transform transition-transform"
                                            id="secondary-filters-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div id="secondary-filters" class="space-y-4 hidden">
                                        <!-- Transmission -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Transmission
                                            </label>
                                            <select name="transmission"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All</option>
                                                <option value="manuelle"
                                                    {{ request('transmission') == 'manuelle' ? 'selected' : '' }}>
                                                    Manual</option>
                                                <option value="automatique"
                                                    {{ request('transmission') == 'automatique' ? 'selected' : '' }}>
                                                    Automatic</option>
                                                <option value="semi-automatique"
                                                    {{ request('transmission') == 'semi-automatique' ? 'selected' : '' }}>
                                                    Semi-Automatic</option>
                                            </select>
                                        </div>

                                        <!-- Color -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Color
                                            </label>
                                            <select name="color"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color }}"
                                                        {{ request('color') == $color ? 'selected' : '' }}>
                                                        {{ ucfirst($color) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Number of Doors -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Number of Doors
                                            </label>
                                            <select name="doors"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">All</option>
                                                <option value="2"
                                                    {{ request('doors') == '2' ? 'selected' : '' }}>2 doors</option>
                                                <option value="3"
                                                    {{ request('doors') == '3' ? 'selected' : '' }}>3 doors</option>
                                                <option value="4"
                                                    {{ request('doors') == '4' ? 'selected' : '' }}>4 doors</option>
                                                <option value="5"
                                                    {{ request('doors') == '5' ? 'selected' : '' }}>5 doors</option>
                                            </select>
                                        </div>

                                        <!-- Features -->
                                        @if ($features->count() > 0)
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Equipment
                                                </label>
                                                <div class="space-y-2 max-h-40 overflow-y-auto">
                                                    @foreach ($features as $feature)
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="features[]"
                                                                value="{{ $feature->id }}"
                                                                {{ in_array($feature->id, request('features', [])) ? 'checked' : '' }}
                                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                                            <span
                                                                class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                                {{ $feature->name }}
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Search Button -->
                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out">
                                        Apply Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Sorting Bar -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $cars->total() }} results
                                </h2>
                            </div>

                            <div class="flex items-center gap-4">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Sort by:
                                </label>
                                <select name="sort" onchange="updateSort(this.value)"
                                    class="rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most
                                        Recent</option>
                                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>
                                        Featured</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                        Price Low to High</option>
                                    <option value="price_desc"
                                        {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High to Low
                                    </option>
                                    <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>
                                        Most Recent (Year)</option>
                                    <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>
                                        Oldest (Year)</option>
                                    <option value="mileage_asc"
                                        {{ request('sort') == 'mileage_asc' ? 'selected' : '' }}>Mileage Low to High
                                    </option>
                                    <option value="mileage_desc"
                                        {{ request('sort') == 'mileage_desc' ? 'selected' : '' }}>Mileage High to Low
                                    </option>
                                    <option value="views_desc"
                                        {{ request('sort') == 'views_desc' ? 'selected' : '' }}>Most Viewed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if ($cars->count() > 0)
                        <!-- Car Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($cars as $car)
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                                    <!-- Image -->
                                    <div class="relative h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                        @if ($car->images->count() > 0)
                                            <img src="{{ $car->images->first()->url }}" alt="{{ $car->title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Price Badge -->
                                        <div class="absolute top-3 left-3">
                                            <span
                                                class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                {{ number_format($car->price) }} €
                                            </span>
                                        </div>

                                        <!-- Featured Badge -->
                                        @if ($car->is_featured)
                                            <div class="absolute top-3 right-3">
                                                <span
                                                    class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                                    Featured
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Favorite Button -->
                                        @auth
                                            <button onclick="toggleFavorite({{ $car->id }})"
                                                class="absolute bottom-3 right-3 p-2 bg-white/80 hover:bg-white rounded-full transition-colors duration-200">
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        @endauth
                                    </div>

                                    <!-- Content -->
                                    <div class="p-4">
                                        <h3
                                            class="font-semibold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2">
                                            {{ $car->title }}
                                        </h3>

                                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                            <p class="font-medium">{{ $car->brand->name }} {{ $car->model->name }}
                                            </p>
                                            <p>{{ $car->year }} • {{ number_format($car->mileage) }} km</p>
                                            <p class="flex items-center mt-1">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $car->location }}
                                            </p>
                                        </div>

                                        <!-- Features -->
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span
                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-full">
                                                {{ ucfirst($car->fuel_type) }}
                                            </span>
                                            <span
                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-full">
                                                {{ ucfirst($car->transmission) }}
                                            </span>
                                            <span
                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-full">
                                                {{ $car->doors }} doors
                                            </span>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('cars.show', $car) }}"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                                                View Details
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>

                                            <div class="flex items-center text-gray-500 text-sm">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ $car->views_count }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $cars->appends(request()->query())->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 text-center py-16">
                            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No Cars Found
                            </h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Try modifying your search criteria.</p>
                            <a href="{{ route('cars.index') }}"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                View All Listings
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts JavaScript -->
    <script>
        // Toggle des sections de filtres
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            const icon = document.getElementById(sectionId + '-icon');

            if (section.classList.contains('hidden')) {
                section.classList.remove('hidden');
                icon.style.transform = 'rotate(0deg)';
            } else {
                section.classList.add('hidden');
                icon.style.transform = 'rotate(-90deg)';
            }
        }

        // Charger les modèles selon la marque sélectionnée
        function loadModels() {
            const brandId = document.getElementById('brand_select').value;
            const modelSelect = document.getElementById('model_select');

            // Vider les options existantes
            modelSelect.innerHTML = '<option value="">All Models</option>';

            if (brandId) {
                fetch(`/api/models-by-brand?brand_id=${brandId}`)
                    .then(response => response.json())
                    .then(models => {
                        models.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            if ({{ request('model_id') ?? 'null' }} == model.id) {
                                option.selected = true;
                            }
                            modelSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading models:', error));
            }
        }

        // Mise à jour du tri
        function updateSort(sortValue) {
            const url = new URL(window.location);
            url.searchParams.set('sort', sortValue);
            window.location.href = url.toString();
        }

        // Réinitialiser les filtres
        function resetFilters() {
            window.location.href = '{{ route('cars.index') }}';
        }

        // Fonction pour les favoris
        @auth

        function toggleFavorite(carId) {
            fetch('/favorites', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        car_id: carId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred', 'error');
                });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className =
                `fixed top-4 right-4 z-50 p-4 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        @endauth

        // Initialiser les sections collapsées au chargement
        document.addEventListener('DOMContentLoaded', function() {
            // Garder les filtres principaux ouverts par défaut
            // Les filtres secondaires sont fermés par défaut (classe hidden)
            document.getElementById('secondary-filters-icon').style.transform = 'rotate(-90deg)';
        });
    </script>
</x-app-layout>
