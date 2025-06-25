<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();
        
        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <h3 class="text-lg font-medium text-[var(--foreground)]">{{ __('Delete account') }}</h3>
        <p class="mt-1 text-sm text-[var(--foreground)]">{{ __('Delete your account and all of its resources') }}</p>
    </div>

    <div x-data="{ showModal: false }">
        <button type="button" @click="showModal = true" class="px-4 py-2 bg-red-600 hover:bg-[var(--color-tertiary)] text-[var(--button-primary-foreground)] font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            {{ __('Delete account') }}
        </button>

        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-[var(--color-zinc-500)] bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-[var(--card-background)] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="deleteUser" class="space-y-6 p-6">
                        <div>
                            <h3 class="text-lg font-medium text-[var(--foreground)]">{{ __('Are you sure you want to delete your account?') }}</h3>
                            <p class="mt-2 text-sm text-[var(--foreground)]">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-[var(--foreground)]">{{ __('Password') }}</label>
                            <input wire:model="password" id="password" name="password" type="password" class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 bg-[var(--card-background)] text-[var(--foreground)]">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="showModal = false" class="px-4 py-2 bg-[var(--color-secondary)] hover:bg-[var(--color-tertiary)] text-[var(--foreground)] font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-[var(--color-tertiary)] text-[var(--button-primary-foreground)] font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                {{ __('Delete account') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
