<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))":class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UsedCars') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
    :class="{ 'dark bg-gray-900': darkMode }">
    <!-- Navbar fixe -->
    <nav class="fixed top-0 left-0 right-0 bg-white dark:bg-gray-800 shadow-md z-50 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800 dark:text-white">UsedCars</span>
                    </a>
                </div>

                <!-- Navigation desktop -->
                <div class="hidden sm:flex items-center space-x-8">
                    <a href="{{ route('cars.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white relative">
                        Buy Cars
                        <span
                            class="absolute -top-2.5 -right-4 bg-red-500 text-gray-100 text-xs font-semibold px-0.9 py-0.5 rounded-full shadow-md transform transition-transform duration-300 hover:scale-110">
                            NEW
                        </span>
                    </a>
                    <a href="#how-it-works"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        How It Works
                    </a>
                    <a href="{{ route('about') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        About Us
                    </a>
                    <a href="{{ route('contact') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        Contact Us
                    </a>

                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Dashboard</a>
                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Register</a>
                        @endif
                    @endauth
                </div>

                <!-- Menu mobile (contenu) -->
                <div id="mobile-menu"
                    class="hidden sm:hidden bg-white dark:bg-gray-800 pb-4 px-4 transition-colors duration-200">
                    <div class="space-y-2 pt-2">
                        <a href="{{ route('cars.index') }}"
                            class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 relative">
                            Buy Cars
                            <span
                                class="absolute top-2 right-6 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                                NEW
                            </span>
                        </a>
                        <a href="#how-it-works"
                            class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                            How It Works
                        </a>
                        <a href="{{ route('about') }}"
                            class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                            About Us
                        </a>
                        <a href="{{ route('contact') }}"
                            class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                            Contact Us
                        </a>

                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                                Dashboard
                            </a>
                            <!-- Logout Form (mobile) -->
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Menu mobile (hamburger) -->
                <div class="flex items-center sm:hidden">
                    <button @click="darkMode = !darkMode"
                        class="mr-4 p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg x-show="!darkMode" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    <button id="mobile-menu-button"
                        class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu mobile (contenu) -->
        <div id="mobile-menu"
            class="hidden sm:hidden bg-white dark:bg-gray-800 pb-4 px-4 transition-colors duration-200">
            <div class="space-y-2 pt-2">
                <a href="#listings"
                    class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700 relative">
                    Listings
                    <span
                        class="absolute top-2 right-6 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                        NEW
                    </span>
                </a>
                <a href="#categories"
                    class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">Categories</a>
                <a href="#about"
                    class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">About</a>

                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">Dashboard</a>

                    <!-- Logout Form (mobile) -->
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">Register</a>
                    @endif
                @endauth

                <!-- CTA Button (mobile) -->
                <a href="#"
                    class="block w-full text-center bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out mt-4">
                    Sell Your Car
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-16 lg:pt-24">
        <!-- Background avec overlay -->
        <div class="absolute inset-0 z-0 h-[85vh]">
            <div
                class="absolute inset-0 bg-gradient-to-br from-blue-900/90 to-gray-900/80 z-10 dark:from-black/90 dark:to-gray-900/90">
            </div>
            <img src="{{ asset('images/car-hero.jpg') }}" alt="Luxury car" class="w-full h-full object-cover"
                onerror="this.src='https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=2070&auto=format&fit=crop'">
        </div>

        <!-- Hero Content -->
        <div
            class="relative z-20 flex flex-col items-center justify-center min-h-[85vh] text-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto space-y-12">
                <!-- Titre et sous-titre -->
                <div class="animate-fade-in-down">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight mb-6">
                        Your next car is waiting for you <br class="hidden md:block">at an exceptional price!
                    </h1>
                    <p class="text-xl md:text-2xl text-white/80 max-w-3xl mx-auto">
                        Thousands of verified listings for every budget and preference.
                    </p>
                </div>

                <!-- Boutons d'action principaux (maintenant au milieu) -->
                <div class="flex flex-col sm:flex-row justify-center gap-6 animate-fade-in-up">
                    <a href="#how-it-works"
                        class="px-8 py-4 bg-white text-blue-600 text-lg font-semibold rounded-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105 hover:shadow-xl">
                        How It Works ?
                    </a>
                    <a href="#listings"
                        class="px-8 py-4 bg-blue-600 text-white text-lg font-semibold rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105 hover:shadow-xl">
                        Browse Cars
                    </a>
                </div>

                <!-- Barre de recherche (maintenant en bas) -->
                <div
                    class="w-full max-w-4xl mx-auto bg-white/95 dark:bg-gray-800/95 rounded-xl shadow-2xl p-6 backdrop-blur-sm animate-fade-in-up">
                    <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="make"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">Make</label>
                            <select id="make" name="make"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option>Any Make</option>
                                <option>Toyota</option>
                                <option>Honda</option>
                                <option>BMW</option>
                                <option>Mercedes</option>
                                <option>Ford</option>
                            </select>
                        </div>
                        <div>
                            <label for="price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">Max
                                Price</label>
                            <select id="price" name="price"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option>Any Price</option>
                                <option>$5,000</option>
                                <option>$10,000</option>
                                <option>$25,000</option>
                                <option>$50,000</option>
                                <option>$100,000+</option>
                            </select>
                        </div>
                        <div>
                            <label for="bodyType"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">Body
                                Type</label>
                            <select id="bodyType" name="bodyType"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option>Any Type</option>
                                <option>Sedan</option>
                                <option>SUV</option>
                                <option>Coupe</option>
                                <option>Truck</option>
                                <option>Van</option>
                            </select>
                        </div>
                        <div>
                            <label class="invisible block text-sm font-medium mb-1">Search</label>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-md hover:shadow-xl">
                                Search Cars
                            </button>
                        </div>
                    </form>
                    <div class="mt-3 flex justify-center">
                        <button type="button" class="text-blue-600 dark:text-blue-400 text-sm hover:underline">
                            Advanced Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-16 bg-white dark:bg-gray-900 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Browse By Category</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Find the perfect vehicle that suits your needs from our wide range of categories
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6" x-data="{ loading: true }"
                x-init="setTimeout(() => loading = false, 1000)">
                <!-- Category Card (with skeleton) -->
                <template x-for="i in 6">
                    <div
                        class="bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        <div x-show="loading" class="animate-pulse">
                            <div class="h-32 bg-gray-300 dark:bg-gray-700"></div>
                            <div class="p-4">
                                <div class="h-4 bg-gray-300 dark:bg-gray-700 w-3/4 mb-2 rounded"></div>
                                <div class="h-3 bg-gray-200 dark:bg-gray-600 w-1/2 rounded"></div>
                            </div>
                        </div>
                        <div x-show="!loading" class="h-full flex flex-col">
                            <div class="h-32 bg-cover bg-center"
                                :style="`background-image: url('https://source.unsplash.com/random/300x200/?car,${i}')`">
                            </div>
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <h3 class="font-bold text-gray-900 dark:text-white"
                                    x-text="['Sedan', 'SUV', 'Coupe', 'Truck', 'Van', 'Electric'][i-1]"></h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400"
                                    x-text="`${Math.floor(Math.random() * 50) + 10} listings`"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- Featured Listings Section -->
    <section id="listings" class="py-16 bg-gray-50 dark:bg-gray-800 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span
                    class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">NEW</span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white mb-4">Featured Listings</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Discover our top-rated cars with verified histories and competitive prices
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" x-data="{ loading: true }"
                x-init="setTimeout(() => loading = false, 1500)">
                <!-- Car Card Skeletons -->
                <template x-for="i in 8" x-show="loading">
                    <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden animate-pulse">
                        <div class="h-48 bg-gray-300 dark:bg-gray-600"></div>
                        <div class="p-4">
                            <div class="h-5 bg-gray-300 dark:bg-gray-600 w-3/4 mb-3 rounded"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-500 w-1/2 mb-3 rounded"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-500 w-4/5 mb-2 rounded"></div>
                            <div class="flex justify-between mt-6">
                                <div class="h-6 bg-gray-300 dark:bg-gray-600 w-1/3 rounded"></div>
                                <div class="h-6 bg-gray-300 dark:bg-gray-600 w-1/4 rounded"></div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Car Cards -->
                <template x-for="i in 8" x-show="!loading">
                    <div
                        class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg">
                        <div class="relative">
                            <img :src="`https://source.unsplash.com/random/600x400/?car,${i+10}`"
                                class="h-48 w-full object-cover" alt="Car listing">
                            <div
                                class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-bold px-2 py-1 m-2 rounded">
                                Featured
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg"
                                x-text="`${['Toyota', 'Honda', 'BMW', 'Mercedes', 'Ford', 'Tesla', 'Audi', 'Lexus'][i-1]} ${['Camry', 'Civic', 'X5', 'C-Class', 'Mustang', 'Model S', 'A4', 'RX'][i-1]} ${2020 + (i % 3)}`">
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-2"
                                x-text="`${10000 + i * 5000} miles • ${['Gasoline', 'Diesel', 'Electric', 'Hybrid'][i % 4]} • ${['Automatic', 'Manual'][i % 2]}`">
                            </p>
                            <div class="flex items-center text-yellow-500 mb-2">
                                <template x-for="star in 5">
                                    <svg class="h-4 w-4 fill-current"
                                        :class="star <= Math.floor(4 + (i % 2)) ? 'text-yellow-500' :
                                            'text-gray-300 dark:text-gray-600'"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                </template>
                                <span class="text-gray-600 dark:text-gray-400 text-sm ml-1"
                                    x-text="`(${Math.floor(Math.random() * 50) + 5} reviews)`"></span>
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <span class="font-bold text-gray-900 dark:text-white text-lg"
                                    x-text="`$${(15000 + i * 7500).toLocaleString()}`"></span>
                                <a href="#"
                                    class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-12 text-center">
                <a href="#"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                    View All Listings
                    <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="about" class="py-16 bg-white dark:bg-gray-900 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Why Choose UsedCars</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    We offer a trusted platform with verified listings and exceptional service
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="inline-block p-3 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Verified Listings</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Every vehicle is thoroughly checked for history, quality, and accurate information.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="inline-block p-3 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Best Prices</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Competitive pricing with no hidden fees, so you get the best deal possible.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="inline-block p-3 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                        <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Expert Support</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Our team is available to help you find the perfect car and answer any questions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 bg-gray-50 dark:bg-gray-800 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">How It Works</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Our simple process makes buying or selling a car easy and hassle-free
                </p>
            </div>

            <div class="relative">
                <!-- Connecting line -->
                <div
                    class="hidden md:block absolute top-1/2 left-0 right-0 h-0.5 bg-gray-200 dark:bg-gray-700 transform -translate-y-1/2 z-0">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 dark:bg-blue-500 text-white text-2xl font-bold mb-4">
                            1</div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Browse Listings</h3>
                        <p class="text-center text-gray-600 dark:text-gray-400">
                            Search through our extensive inventory of verified pre-owned vehicles.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 dark:bg-blue-500 text-white text-2xl font-bold mb-4">
                            2</div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Contact Seller</h3>
                        <p class="text-center text-gray-600 dark:text-gray-400">
                            Connect directly with sellers to ask questions or schedule a test drive.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 dark:bg-blue-500 text-white text-2xl font-bold mb-4">
                            3</div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Make a Deal</h3>
                        <p class="text-center text-gray-600 dark:text-gray-400">
                            Negotiate the price and complete the purchase with confidence.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-700 dark:bg-blue-800 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-8 md:mb-0 md:mr-8 text-center md:text-left">
                    <h2 class="text-4xl font-bold text-white mb-4">
                        Sell Your Car Easily & Quickly
                    </h2>
                    <p class="text-xl text-blue-100 max-w-2xl">
                        Join thousands of sellers who trust our platform. Post your car in minutes and connect with
                        serious buyers in your area.
                    </p>
                </div>
                <div class="flex flex-col gap-4">
                    <!-- CTA Button -->
                    <a href="{{ auth()->check() ? route('cars.create') : route('register') }}"
                        class="group relative bg-white hover:bg-gray-100 text-blue-700 font-bold py-4 px-8 rounded-lg text-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-xl text-center min-w-[200px]">
                        Post Your Car for Sale
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">
                            FREE
                        </span>
                    </a>
                    <p class="text-center text-blue-100 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-white hover:underline font-medium">
                            Sign in to manage your listings
                        </a>
                    </p>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <!-- Feature 1 -->
                <div class="flex items-center space-x-4 bg-blue-600/50 dark:bg-blue-900/50 rounded-lg p-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold">Quick & Easy Listing</h3>
                        <p class="text-blue-100 text-sm">Create your listing in less than 5 minutes</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-center space-x-4 bg-blue-600/50 dark:bg-blue-900/50 rounded-lg p-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold">Local Buyers Network</h3>
                        <p class="text-blue-100 text-sm">Connect with serious buyers in your area</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex items-center space-x-4 bg-blue-600/50 dark:bg-blue-900/50 rounded-lg p-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold">Instant Notifications</h3>
                        <p class="text-blue-100 text-sm">Get alerts when buyers show interest</p>
                    </div>
                </div>
            </div>

            <!-- Additional Benefits -->
            <div class="mt-12 text-center">
                <div
                    class="inline-flex items-center space-x-2 text-white bg-blue-600/50 dark:bg-blue-900/50 rounded-full px-4 py-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm">No listing fees • Direct contact with buyers • Easy to use platform</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span class="ml-2 text-xl font-bold">UsedCars</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        The best place to buy and sell used vehicles with confidence and ease.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.1 10.1 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#listings" class="text-gray-400 hover:text-white">Listings</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">How It Works</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400">Email: contact@usedcars.com</li>
                        <li class="text-gray-400">Phone: +1 234 567 890</li>
                        <li class="text-gray-400">123 Car Street, Auto City</li>
                        <li><a href="#" class="text-blue-400 hover:text-blue-300">Contact Form</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} UsedCars. All rights reserved.</p>
                <div class="mt-4 md:mt-0">
                    <ul class="flex space-x-6">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts for interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Simple animations for elements as they come into view
            const fadeElements = document.querySelectorAll('.animate-fade-in-down, .animate-fade-in-up');

            const fadeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100');
                        entry.target.classList.remove('opacity-0');
                        entry.target.classList.add('translate-y-0');
                        entry.target.classList.remove('-translate-y-10', 'translate-y-10');
                    }
                });
            }, {
                threshold: 0.1
            });

            fadeElements.forEach(el => {
                el.classList.add('transition-all', 'duration-1000', 'opacity-0');
                if (el.classList.contains('animate-fade-in-down')) {
                    el.classList.add('-translate-y-10');
                } else {
                    el.classList.add('translate-y-10');
                }
                fadeObserver.observe(el);
            });
        });
    </script>
</body>

</html>
