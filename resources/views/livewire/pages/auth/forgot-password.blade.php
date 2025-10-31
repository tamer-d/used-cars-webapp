<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <h1 class="text-2xl font-bold mb-2">Forgot Password</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-6">Recover access to your account</p>

    <div
        class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6 border-l-4 border-light-primary dark:border-dark-primary">
        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
            Forgot your password? No worries — it happens. Simply enter the email address associated with your account,
            and we'll send you a secure link to reset your password. Make sure to check your inbox (and spam folder if
            needed). Once you receive the email, follow the instructions to create a new password and regain full access
            to your account. Your security matters to us, and we're here to help you get back on track quickly and
            safely.
        </p>
    </div>

    <!-- Session Status -->
    <div class="mb-4">
        @if (session('status'))
            <div
                class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-sm text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium mb-1" />
            <x-text-input wire:model="email" id="email"
                class="input-auth block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none"
                type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <button type="submit"
                class="btn-auth w-full bg-light-primary dark:bg-dark-primary text-white py-3 px-4 rounded-lg font-medium hover:bg-light-primary/90 dark:hover:bg-dark-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-primary dark:focus:ring-dark-primary transition-all duration-300">
                {{ __('Send Reset Link') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a class="text-light-primary dark:text-dark-primary hover:underline font-medium"
                    href="{{ route('login') }}" wire:navigate>
                    {{ __('Back to Login') }}
                </a>
            </p>
        </div>
    </form>
</div>
