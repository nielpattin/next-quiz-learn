<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    /**
     * Send a new email verification notification.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        session()->flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Verify your email address')" :description="__('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <p class="text-center text-sm text-[var(--foreground)] dark:text-[var(--foreground)]">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
        @if (session('status') == 'verification-link-sent')
            <span class="block font-medium text-[var(--color-primary)] dark:text-[var(--color-primary)]">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </span>
        @endif
    </p>

    <div class="flex flex-col items-center justify-between space-y-3">
        <button wire:click="sendVerification" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-[var(--color-accent-foreground)] bg-[var(--color-accent)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-accent)] dark:bg-[var(--color-accent)] dark:hover:bg-[var(--color-tertiary)] dark:focus:ring-offset-[var(--color-zinc-800)]">
            {{ __('Resend verification email') }}
        </button>

        <button wire:click="logout" class="text-sm text-[var(--foreground)] dark:text-[var(--foreground)] hover:text-[var(--foreground)] dark:hover:text-[var(--foreground)] cursor-pointer">
            {{ __('Log out') }}
        </button>
    </div>
</div>
