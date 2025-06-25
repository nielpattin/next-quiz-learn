<?php

use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            Session::flash('status', __('auth.failed'));

            return;
        }

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Sign in to your account')" :description="__('Welcome back! Please enter your details.')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <div>
            <label for="email" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">
                {{ __('Email address') }}
            </label>
            <input
                wire:model="email"
                id="email"
                type="email"
                required
                autofocus
                autocomplete="username"
                placeholder="email@example.com"
                class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm placeholder-[var(--foreground)] focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:placeholder-[var(--foreground)] dark:text-[var(--foreground)]"
            />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="relative">
            <label for="password" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">
                {{ __('Password') }}
            </label>
            <input
                wire:model="password"
                id="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="{{ __('Password') }}"
                class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm placeholder-[var(--foreground)] focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:placeholder-[var(--foreground)] dark:text-[var(--foreground)]"
            />
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="absolute end-0 top-0 text-sm text-[var(--color-primary)] hover:text-[var(--color-secondary)]">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center">
            <input
                wire:model="remember"
                id="remember"
                type="checkbox"
                class="h-4 w-4 text-[var(--color-primary)] focus:ring-[var(--color-primary)] border-[var(--border-color)] rounded"
            >
            <label for="remember" class="ml-2 block text-sm text-[var(--foreground)] dark:text-[var(--foreground)]">
                {{ __('Remember me') }}
            </label>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-[var(--button-primary-foreground)] bg-[var(--color-primary)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-[var(--foreground)] dark:text-[var(--foreground)]">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" wire:navigate class="font-medium text-[var(--color-primary)] hover:text-[var(--color-secondary)]">{{ __('Sign up') }}</a>
        </div>
    @endif
</div>
