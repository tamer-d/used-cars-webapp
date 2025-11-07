<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => {
    localStorage.setItem('darkMode', val);
    if (val) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});
if (darkMode) document.documentElement.classList.add('dark');"
    class="fixed top-0 w-full z-50 backdrop-blur-md bg-white/80 dark:bg-dark-background/90 shadow-sm border-b border-gray-100 dark:border-gray-800 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16">
            <!-- Logo -->
            <div class="flex items-center ml-8">
                <a href="/" wire:navigate>
                    <x-application-logo class="block h-9 w-auto fill-current text-light-text dark:text-dark-text" />
                </a>
            </div>

            <!-- Navigation Links - Positionnés plus à droite avec espace -->
            <div class="hidden sm:flex items-center space-x-10 mx-auto mr-16">
                <a href="/"
                    class="text-base font-medium text-light-text dark:text-dark-text hover:text-light-primary dark:hover:text-dark-primary transition duration-150 ease-in-out">Home</a>
                <a href="#how-it-works"
                    class="text-base font-medium text-light-text dark:text-dark-text hover:text-light-primary dark:hover:text-dark-primary transition duration-150 ease-in-out">How
                    it Works</a>
                <a href="#contact-us"
                    class="text-base font-medium text-light-text dark:text-dark-text hover:text-light-primary dark:hover:text-dark-primary transition duration-150 ease-in-out">Contact
                    Us</a>
            </div>

            <!-- User Menu or Authentication Links -->
            <div class="hidden sm:flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
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
                    <!-- Authenticated User Menu -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center space-x-2 text-sm font-medium text-light-text dark:text-dark-text">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                    alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')">My Profile</x-dropdown-link>
                            <x-dropdown-link :href="route('messages.index')">Messages</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-light-text dark:text-dark-text hover:text-light-primary dark:hover:text-dark-primary transition duration-150 ease-in-out">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-light-primary dark:bg-dark-primary text-white text-sm font-medium rounded-md hover:bg-blue-700 dark:hover:bg-blue-500 transition duration-150 ease-in-out">Get
                        Started</a>
                @endauth
            </div>

            <div class="sm:hidden ml-auto flex items-center">
                <button @click="open = !open"
                    class="p-2 rounded-md text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'block': !open }" class="block" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'block': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <div :class="{ 'block': open, 'hidden': !open }"
        class="sm:hidden bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <div class="space-y-1">
            <a href="/"
                class="block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
            <a href="#how-it-works"
                class="block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">How
                it Works</a>
            <a href="#contact-us"
                class="block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">Contact
                Us</a>
        </div>

        @auth
            <div class="border-t border-gray-100 dark:border-gray-700 space-y-1">
                <a href="{{ route('profile') }}"
                    class="block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">My
                    Profile</a>
                <a href="{{ route('messages.index') }}"
                    class="block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">Messages</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">
                        Logout
                    </button>
                </form>
            </div>
        @else
            <div class="border-t border-gray-100 dark:border-gray-700 space-y-1">
                <a href="{{ route('login') }}"
                    class="block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">Login</a>
                <a href="{{ route('register') }}"
                    class="block px-4 py-2 text-base font-medium text-light-text dark:text-dark-text hover:bg-gray-100 dark:hover:bg-gray-700">Get
                    Started</a>
            </div>
        @endauth
    </div>
</nav>
