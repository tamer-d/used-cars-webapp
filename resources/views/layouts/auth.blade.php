<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600|montserrat:300,400,500,600&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-container {
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            transition: all 0.3s ease;
        }

        .form-side {
            transition: transform 0.5s ease, opacity 0.4s ease;
        }

        .visual-side {
            transition: transform 0.5s ease, opacity 0.4s ease;
            background-size: cover;
            background-position: center;
        }

        .form-appear {
            animation: formAppear 0.6s ease-out forwards;
        }

        @keyframes formAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-auth {
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .input-auth {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-auth:focus {
            border-color: theme('colors.light.primary');
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .dark .input-auth:focus {
            border-color: theme('colors.dark.primary');
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>

<body x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => {
    localStorage.setItem('darkMode', val);
    if (val) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});
if (darkMode) document.documentElement.classList.add('dark');"
    class="font-sans text-light-text dark:text-dark-text antialiased transition-colors duration-300">

    <div class="flex flex-col md:flex-row auth-container bg-light-background dark:bg-dark-background">
        <!-- Form Side -->
        <div class="w-full md:w-1/2 form-side p-6 md:p-12 flex flex-col justify-center items-center">
            <div class="w-full max-w-md">
                <div class="flex justify-between items-center mb-12">
                    <a href="/" wire:navigate class="flex items-center">
                        <x-application-logo class="w-12 h-12 fill-current text-light-primary dark:text-dark-primary" />
                        <span class="ml-3 text-xl font-semibold">{{ config('app.name', 'AutoMarket') }}</span>
                    </a>

                    <!-- Toggle Dark Mode -->
                    <button @click="darkMode = !darkMode"
                        class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-primary dark:focus:ring-dark-primary transition-colors duration-200">
                        <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>

                <div class="form-appear">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Visual Section -->
        <div class="hidden md:flex md:w-1/2 visual-side bg-light-primary dark:bg-dark-primary relative overflow-hidden">
            <!-- Background Gradient -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-light-primary/90 to-light-secondary/80 dark:from-dark-primary/90 dark:to-dark-secondary/80">
            </div>

            <!-- Main Content -->
            <div class="relative z-10 flex flex-col justify-center items-center p-12 text-white">
                <!-- Image with Alt Text -->
                <img src="{{ asset('images/auth/authimg.png') }}" alt="Image of a premium car"
                    class="max-w-md w-full mb-8 drop-shadow-xl" loading="lazy">

                <h2 class="text-3xl font-bold mb-4 text-center">
                    {{ $slogan ?? 'Connect and start discovering amazing car deals' }}
                </h2>

                <p class="text-lg text-center max-w-md opacity-90">
                    {{ $description ?? 'Join our used cars marketplace and find your dream car today.' }}
                </p>
            </div>
        </div>
    </div>

</body>

</html>
