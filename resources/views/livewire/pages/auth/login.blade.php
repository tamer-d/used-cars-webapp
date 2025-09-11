<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-light-text dark:text-dark-text" />
            <x-text-input wire:model="form.email" id="email"
                class="block mt-1 w-full bg-white dark:bg-gray-900 text-light-text dark:text-dark-text border-gray-300 dark:border-gray-700 focus:border-light-primary dark:focus:border-dark-primary focus:ring-light-primary dark:focus:ring-dark-primary rounded-md shadow-sm"
                type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-light-text dark:text-dark-text" />

            <x-text-input wire:model="form.password" id="password"
                class="block mt-1 w-full bg-white dark:bg-gray-900 text-light-text dark:text-dark-text border-gray-300 dark:border-gray-700 focus:border-light-primary dark:focus:border-dark-primary focus:ring-light-primary dark:focus:ring-dark-primary rounded-md shadow-sm"
                type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded border-gray-300 dark:border-gray-700 text-light-primary dark:text-dark-primary shadow-sm focus:ring-light-primary dark:focus:ring-dark-primary bg-white dark:bg-gray-900"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-primary dark:focus:ring-dark-primary"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit"
                class="ms-3 inline-flex items-center px-4 py-2 bg-light-primary dark:bg-dark-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-500 focus:bg-blue-700 dark:focus:bg-blue-500 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-light-primary dark:focus:ring-dark-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</div>
