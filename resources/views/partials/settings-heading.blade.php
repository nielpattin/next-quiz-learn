<div class="relative mb-6 w-full">
    <div class="flex items-center gap-2">
        <h1 class="text-3xl font-bold text-[var(--foreground)]">{{ __('Settings') }}</h1>
        @if(auth()->check())
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-[var(--color-primary)] text-[var(--button-primary-foreground)]">
                {{ auth()->user()->subscription }}
            </span>
        @endif
    </div>
    <p class="mt-2 text-lg text-[var(--foreground)] mb-6">{{ __('Manage your profile and account settings') }}</p>
    <div class="border-t border-[var(--border-color)]"></div>
</div>
