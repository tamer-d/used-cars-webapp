<x-app-layout>
    <div class="pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('My profile') }}
                </h2>
                <div class="mt-2 md:mt-0 flex space-x-2">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        Member since {{ Auth::user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Sidebar with user information -->
                <div class="col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-center">
                            <div
                                class="w-24 h-24 mx-auto rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 text-2xl font-bold mb-4">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ Auth::user()->email }}</p>
                            @if (Auth::user()->phone_number)
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ Auth::user()->phone_number }}</p>
                            @endif

                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Account Status</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        Active
                                    </span>
                                </div>

                                @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Email Verified</span>
                                        @if (Auth::user()->hasVerifiedEmail())
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Yes
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                No
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main section with forms -->
                <div class="col-span-1 md:col-span-2 space-y-6">
                    <!-- Profile Information -->
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-md">
                        <div class="p-6">
                            <livewire:profile.update-profile-information-form />
                        </div>
                    </div>

                    <!-- Password Update -->
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-md">
                        <div class="p-6">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    <!-- Account Deletion -->
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-md">
                        <div class="p-6">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
