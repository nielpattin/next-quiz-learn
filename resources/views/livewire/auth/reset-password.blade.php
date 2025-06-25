<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Handle an incoming password reset request.
     */
    public function resetPassword(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::broker()->reset(
            $validated,
            function (User $user) use ($validated) {
                $user->forceFill([
                    'password' => Hash::make($validated['password']),
                ])->save();

                event(new PasswordReset($user));

                Auth::login($user);
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            $this->redirect(route('dashboard', absolute: false), navigate: true);
        } else {
            $this->addError('email', __($status));
        }
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Reset password')" :description="__('Enter your email and new password to reset your password')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">{{ __('Email') }}</label>
            <div class="mt-1">
                <input wire:model="email" id="email" name="email" type="email" required autocomplete="email" class="block w-full appearance-none rounded-md border border-[var(--border-color)] dark:border-[var(--border-color)] px-3 py-2 placeholder-[var(--foreground)] dark:placeholder-[var(--foreground)] shadow-sm focus:border-[var(--color-primary)] focus:outline-none focus:ring-[var(--color-primary)] sm:text-sm dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:text-[var(--foreground)]">
            </div>
            @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Password -->
        <div x-data="{ showPassword: false }">
            <label for="password" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">{{ __('Password') }}</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input wire:model="password" id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="new-password" placeholder="{{ __('Password') }}" class="block w-full appearance-none rounded-md border border-[var(--border-color)] dark:border-[var(--border-color)] px-3 py-2 placeholder-[var(--foreground)] dark:placeholder-[var(--foreground)] shadow-sm focus:border-[var(--color-primary)] focus:outline-none focus:ring-[var(--color-primary)] sm:text-sm dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:text-[var(--foreground)]">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <button type="button" @click="showPassword = !showPassword" class="text-[var(--foreground)] dark:text-[var(--foreground)] hover:text-[var(--foreground)] dark:hover:text-[var(--foreground)]">
                        <svg x-show="!showPassword" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="showPassword" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414L5.586 8H4a1 1 0 000 2h1.586l-2.293 2.293a1 1 0 001.414 1.414L8 11.414V13a1 1 0 102 0v-1.586l2.293 2.293a1 1 0 001.414-1.414L11.414 10H13a1 1 0 100-2h-1.586l2.293-2.293a1 1 0 00-1.414-1.414L10 8.586V7a1 1 0 10-2 0v1.586L3.707 2.293zM10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            @error('password') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Confirm Password -->
        <div x-data="{ showPasswordConfirmation: false }">
            <label for="password_confirmation" class="block text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)]">{{ __('Confirm password') }}</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" :type="showPasswordConfirmation ? 'text' : 'password'" required autocomplete="new-password" placeholder="{{ __('Confirm password') }}" class="block w-full appearance-none rounded-md border border-[var(--border-color)] dark:border-[var(--border-color)] px-3 py-2 placeholder-[var(--foreground)] dark:placeholder-[var(--foreground)] shadow-sm focus:border-[var(--color-primary)] focus:outline-none focus:ring-[var(--color-primary)] sm:text-sm dark:bg-[var(--card-background)] dark:border-[var(--border-color)] dark:text-[var(--foreground)]">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="text-[var(--foreground)] dark:text-[var(--foreground)] hover:text-[var(--foreground)] dark:hover:text-[var(--foreground)]">
                        <svg x-show="!showPasswordConfirmation" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="showPasswordConfirmation" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414L5.586 8H4a1 1 0 000 2h1.586l-2.293 2.293a1 1 0 001.414 1.414L8 11.414V13a1 1 0 102 0v-1.586l2.293 2.293a1 1 0 001.414-1.414L11.414 10H13a1 1 0 100-2h-1.586l2.293-2.293a1 1 0 00-1.414-1.414L10 8.586V7a1 1 0 10-2 0v1.586L3.707 2.293zM10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            @error('password_confirmation') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-[var(--button-primary-foreground)] bg-[var(--color-accent)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-accent)] dark:bg-[var(--color-accent)] dark:hover:bg-[var(--color-tertiary)] dark:focus:ring-offset-[var(--color-zinc-800)]">
                {{ __('Reset password') }}
            </button>
        </div>
    </form>
</div>
