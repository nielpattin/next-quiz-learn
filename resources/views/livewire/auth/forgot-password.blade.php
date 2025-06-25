<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">{{ __('Email Address') }}</label>
            <div class="mt-1">
                <input wire:model="email" id="email" name="email" type="email" required autofocus placeholder="email@example.com" class="block w-full appearance-none rounded-md border border-[var(--border-color)] dark:border-[var(--border-color)] px-3 py-2 placeholder-[var(--foreground)] dark:placeholder-[var(--foreground)] shadow-sm focus:border-[var(--color-primary)] focus:outline-none focus:ring-[var(--color-primary)] sm:text-sm dark:bg-[var(--card-bg)] dark:text-[var(--foreground)]">
            </div>
            @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-[var(--color-accent-foreground)] bg-[var(--color-accent)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-accent)] dark:bg-[var(--color-accent)] dark:hover:bg-[var(--color-tertiary)] dark:focus:ring-offset-[var(--color-zinc-800)]">{{ __('Email password reset link') }}</button>
            </form>
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-[var(--foreground)]">
        {{ __('Or, return to') }}
        <a href="{{ route('login') }}" wire:navigate class="font-medium text-[var(--color-accent)] hover:text-[var(--color-primary)] dark:text-[var(--color-accent)] dark:hover:text-[var(--color-secondary)]">{{ __('log in') }}</a>
    </div>
</div>
