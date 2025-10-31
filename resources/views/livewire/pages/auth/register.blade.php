<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('cars.index', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h1 class="text-2xl font-bold mb-2">Create an Account</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-8">And join our community</p>

    <form wire:submit="register" class="space-y-5">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-medium mb-1" />
            <x-text-input wire:model="name" id="name"
                class="input-auth block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none"
                type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium mb-1" />
            <x-text-input wire:model="email" id="email"
                class="input-auth block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none"
                type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium mb-1" />
            <x-text-input wire:model="password" id="password"
                class="input-auth block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none"
                type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium mb-1" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation"
                class="input-auth block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button type="submit"
                class="btn-auth w-full bg-light-primary dark:bg-dark-primary text-white py-3 px-4 rounded-lg font-medium hover:bg-light-primary/90 dark:hover:bg-dark-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-primary dark:focus:ring-dark-primary transition-all duration-300">
                {{ __('Register') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Already registered?') }}
                <a class="text-light-primary dark:text-dark-primary hover:underline font-medium"
                    href="{{ route('login') }}" wire:navigate>
                    {{ __('Log In') }}
                </a>
            </p>
        </div>
    </form>
</div>
