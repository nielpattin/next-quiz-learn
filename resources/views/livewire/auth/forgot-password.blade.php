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
            <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Email Address') }}</label>
            <div class="mt-1">
                <input wire:model="email" id="email" name="email" type="email" required autofocus placeholder="email@example.com" class="block w-full appearance-none rounded-md border border-zinc-300 dark:border-zinc-600 px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm dark:bg-zinc-700 dark:text-white">
            </div>
            @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-zinc-800">{{ __('Email password reset link') }}</button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        {{ __('Or, return to') }}
        <a href="{{ route('login') }}" wire:navigate class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">{{ __('log in') }}</a>
    </div>
</div>
