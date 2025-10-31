<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('cars.index', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h1 class="text-2xl font-bold mb-2">Welcome</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-8">Log in to access your account</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium mb-1" />
            <x-text-input wire:model="form.email" id="email"
                class="input-auth block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none"
                type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" class="text-sm font-medium" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-light-primary dark:text-dark-primary hover:underline"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <x-text-input wire:model="form.password" id="password"
                class="input-auth block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 text-light-primary dark:text-dark-primary shadow-sm focus:ring-light-primary dark:focus:ring-dark-primary"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember Me') }}</span>
            </label>
        </div>

        <div>
            <button type="submit"
                class="btn-auth w-full bg-light-primary dark:bg-dark-primary text-white py-3 px-4 rounded-lg font-medium hover:bg-light-primary/90 dark:hover:bg-dark-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-primary dark:focus:ring-dark-primary transition-all duration-300">
                {{ __('Log In') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Don\'t have an account?') }}
                <a class="text-light-primary dark:text-dark-primary hover:underline font-medium"
                    href="{{ route('register') }}" wire:navigate>
                    {{ __('Create an account') }}
                </a>
            </p>
        </div>
    </form>
</div>
