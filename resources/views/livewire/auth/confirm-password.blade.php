<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Confirm password')"
        :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
    />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        <!-- Password -->
        <div x-data="{ showPassword: false }">
            <label for="password" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">{{ __('Password') }}</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input wire:model="password" id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="new-password" placeholder="{{ __('Password') }}" class="block w-full appearance-none rounded-md border border-[var(--border-color)] dark:border-[var(--border-color)] px-3 py-2 placeholder-[var(--foreground)] dark:placeholder-[var(--foreground)] shadow-sm focus:border-[var(--color-primary)] focus:outline-none focus:ring-[var(--color-primary)] sm:text-sm dark:bg-[var(--card-background)] dark:text-[var(--foreground)]">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <button type="button" @click="showPassword = !showPassword" class="text-[var(--foreground)] dark:text-[var(--foreground)] hover:text-[var(--foreground)] dark:hover:text-[var(--foreground)]">
                        <svg x-show="!showPassword" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.18l.75-1.405A10.022 10.022 0 0110 4c2.305 0 4.408.867 6 2.292l.75 1.405a1.65 1.65 0 010 1.18l-.75 1.405A10.022 10.022 0 0110 16c-2.305 0-4.408-.867-6-2.292l-.75-1.405zM10 14a4 4 0 100-8 4 4 0 000 8z" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="showPassword" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.27 7.117 15.175 5 12 5c-.99 0-1.938.204-2.83.571L3.707 2.293zm9.207 9.207a4 4 0 01-5.656-5.656l5.656 5.656z" clip-rule="evenodd" />
                            <path d="M9.938 4.013A9.995 9.995 0 0110 4c2.305 0 4.408.867 6 2.292A1.65 1.65 0 0116.75 7.7l-1.414-1.414A8.002 8.002 0 0010 6a7.963 7.963 0 00-4.212 1.238l-1.414-1.414A9.995 9.995 0 019.938 4.013z" />
                        </svg>
                    </button>
                </div>
            </div>
            @error('password') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-[var(--button-primary-foreground)] bg-[var(--color-accent)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-accent)] dark:bg-[var(--color-accent)] dark:hover:bg-[var(--color-tertiary)] dark:focus:ring-offset-[var(--color-zinc-800)]">{{ __('Confirm') }}</button>
    </form>
</div>
