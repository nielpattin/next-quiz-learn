<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
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

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">
                {{ __('Name') }}
            </label>
            <input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="{{ __('Full name') }}"
                class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm placeholder-[var(--foreground)] focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:placeholder-[var(--foreground)] dark:text-[var(--foreground)]"
            />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">
                {{ __('Email address') }}
            </label>
            <input
                wire:model="email"
                id="email"
                name="email"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
                class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm placeholder-[var(--foreground)] focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:placeholder-[var(--foreground)] dark:text-[var(--foreground)]"
            />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">
                {{ __('Password') }}
            </label>
            <input
                wire:model="password"
                id="password"
                name="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Password') }}"
                class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm placeholder-[var(--foreground)] focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:placeholder-[var(--foreground)] dark:text-[var(--foreground)]"
            />
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">
                {{ __('Confirm password') }}
            </label>
            <input
                wire:model="password_confirmation"
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Confirm password') }}"
                class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm placeholder-[var(--foreground)] focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:placeholder-[var(--foreground)] dark:text-[var(--foreground)]"
            />
            @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-[var(--button-primary-foreground)] bg-[var(--color-primary)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                {{ __('Create account') }}
            </button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-[var(--foreground)] dark:text-[var(--foreground)]">
        {{ __('Already have an account?') }}
        <a href="{{ route('login') }}" wire:navigate class="font-medium text-[var(--color-primary)] hover:text-[var(--color-secondary)]">{{ __('Log in') }}</a>
    </div>
</div>
