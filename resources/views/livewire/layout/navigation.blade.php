<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect('/', navigate: true);
    }

    public function toggleDarkMode(): void
    {
        $this->dispatch('toggle-dark-mode');
    }
}; ?>

<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => {
    localStorage.setItem('darkMode', val);
    if (val) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});
if (darkMode) document.documentElement.classList.add('dark');" @toggle-dark-mode.window="darkMode = !darkMode"
    class="fixed top-0 w-full z-50 backdrop-blur-md bg-white/80 dark:bg-dark-background/90 shadow-sm border-b border-gray-100 dark:border-gray-800 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-light-text dark:text-dark-text" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    <a href="{{ url('/') }}" wire:navigate
                        class="{{ request()->is('/') ? 'text-light-primary dark:text-dark-primary' : 'text-light-text dark:text-dark-text' }} inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('/') ? 'border-light-primary dark:border-dark-primary' : 'border-transparent' }} text-sm font-medium leading-5 hover:text-light-primary dark:hover:text-dark-primary hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        Home
                    </a>
                    <a href="{{ url('/cars') }}" wire:navigate
                        class="{{ request()->is('cars*') ? 'text-light-primary dark:text-dark-primary' : 'text-light-text dark:text-dark-text' }} inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('cars*') ? 'border-light-primary dark:border-dark-primary' : 'border-transparent' }} text-sm font-medium leading-5 hover:text-light-primary dark:hover:text-dark-primary hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        Cars
                    </a>
                    <a href="{{ url('/how-it-works') }}" wire:navigate
                        class="{{ request()->is('how-it-works') ? 'text-light-primary dark:text-dark-primary' : 'text-light-text dark:text-dark-text' }} inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('how-it-works') ? 'border-light-primary dark:border-dark-primary' : 'border-transparent' }} text-sm font-medium leading-5 hover:text-light-primary dark:hover:text-dark-primary hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        How it Works
                    </a>
                    <a href="{{ url('/contact') }}" wire:navigate
                        class="{{ request()->is('contact') ? 'text-light-primary dark:text-dark-primary' : 'text-light-text dark:text-dark-text' }} inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('contact') ? 'border-light-primary dark:border-dark-primary' : 'border-transparent' }} text-sm font-medium leading-5 hover:text-light-primary dark:hover:text-dark-primary hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        Contact Us
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown et Dark Mode Toggle -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="p-1.5 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 mr-4">
                    <svg x-show="!darkMode" class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                @auth
                    <!-- User Menu avec Avatar -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-light-text dark:text-dark-text bg-white dark:bg-gray-800 hover:text-light-primary dark:hover:text-dark-primary focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden mr-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                            alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Mon Profil') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('favorites', absolute: false) }}" wire:navigate>
                                {{ __('Favoris') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('messages.index', absolute: false) }}" wire:navigate>
                                {{ __('Messages') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Boutons Login et Get Started -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                            class="font-medium text-sm text-light-text dark:text-dark-text hover:text-light-primary dark:hover:text-dark-primary transition-colors duration-200"
                            wire:navigate>
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-light-primary dark:bg-dark-primary hover:bg-blue-700 dark:hover:bg-blue-500 text-white font-medium py-2 px-4 rounded-md text-sm transition-colors duration-200"
                            wire:navigate>
                            Get Started
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-light-text dark:text-dark-text hover:text-light-primary dark:hover:text-dark-primary hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-light-primary dark:focus:text-dark-primary transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" wire:navigate
                class="{{ request()->is('/') ? 'border-l-4 border-light-primary dark:border-dark-primary bg-gray-50 dark:bg-gray-900 text-light-primary dark:text-dark-primary' : 'border-l-4 border-transparent text-light-text dark:text-dark-text' }} block pl-3 pr-4 py-2 text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                Home
            </a>
            <a href="{{ url('/cars') }}" wire:navigate
                class="{{ request()->is('cars*') ? 'border-l-4 border-light-primary dark:border-dark-primary bg-gray-50 dark:bg-gray-900 text-light-primary dark:text-dark-primary' : 'border-l-4 border-transparent text-light-text dark:text-dark-text' }} block pl-3 pr-4 py-2 text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                Cars
            </a>
            <a href="{{ url('/how-it-works') }}" wire:navigate
                class="{{ request()->is('how-it-works') ? 'border-l-4 border-light-primary dark:border-dark-primary bg-gray-50 dark:bg-gray-900 text-light-primary dark:text-dark-primary' : 'border-l-4 border-transparent text-light-text dark:text-dark-text' }} block pl-3 pr-4 py-2 text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                How it Works
            </a>
            <a href="{{ url('/contact') }}" wire:navigate
                class="{{ request()->is('contact') ? 'border-l-4 border-light-primary dark:border-dark-primary bg-gray-50 dark:bg-gray-900 text-light-primary dark:text-dark-primary' : 'border-l-4 border-transparent text-light-text dark:text-dark-text' }} block pl-3 pr-4 py-2 text-base font-medium focus:outline-none transition duration-150 ease-in-out">
                Contact Us
            </a>
        </div>

        @auth
            <!-- Menu mobile user authentifié -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4 flex items-center">
                    <div class="flex-shrink-0 mr-3">
                        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div>
                        <div class="font-medium text-base text-light-text dark:text-dark-text">{{ Auth::user()->name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="block px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-light-primary dark:hover:text-dark-primary">
                        {{ __('Mon Profil') }}
                    </a>
                    <a href="{{ route('favorites', absolute: false) }}" wire:navigate
                        class="block px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-light-primary dark:hover:text-dark-primary">
                        {{ __('Favoris') }}
                    </a>
                    <a href="{{ route('messages.index', absolute: false) }}" wire:navigate
                        class="block px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-light-primary dark:hover:text-dark-primary">
                        {{ __('Messages') }}
                    </a>

                    <!-- Dark Mode Toggle (Mobile) -->
                    <button @click="darkMode = !darkMode"
                        class="w-full flex items-center px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-light-primary dark:hover:text-dark-primary">
                        <svg x-show="!darkMode" class="mr-3 h-5 w-5 text-gray-500 dark:text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        {{ __('Mode ') }} <span x-text="darkMode ? 'Clair' : 'Sombre'" class="ml-1"></span>
                    </button>

                    <!-- Authentication -->
                    <button wire:click="logout"
                        class="w-full text-start block px-3 py-2 rounded-md text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-light-primary dark:hover:text-dark-primary">
                        {{ __('Déconnexion') }}
                    </button>
                </div>
            </div>
        @else
            <!-- Menu mobile utilisateur non connecté -->
            <div class="py-3 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4 flex flex-col space-y-2">
                    <a href="{{ route('login') }}"
                        class="w-full px-3 py-2 rounded-md text-center font-medium text-sm text-light-text dark:text-dark-text hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-light-primary dark:hover:text-dark-primary transition-colors duration-200"
                        wire:navigate>
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full px-3 py-2 rounded-md text-center bg-light-primary dark:bg-dark-primary hover:bg-blue-700 dark:hover:bg-blue-500 text-white font-medium text-sm transition-colors duration-200"
                        wire:navigate>
                        Get Started
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>

<!-- Spacer pour éviter que le contenu ne soit caché derrière la navbar fixed -->
<div class="h-16"></div>
