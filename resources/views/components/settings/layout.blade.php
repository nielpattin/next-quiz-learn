@props([
    'heading' => '',
    'subheading' => ''
])

<div class="flex flex-col gap-6 md:flex-row">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav class="space-y-1">
            <a wire:navigate href="{{ route('settings.profile') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.profile') ? 'bg-[var(--color-tertiary)] text-[var(--foreground)]' : 'text-[var(--foreground)] hover:text-[var(--foreground)] hover:bg-[var(--color-tertiary)]' }}">
                {{ __('Profile') }}
            </a>
            <a wire:navigate href="{{ route('settings.password') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.password') ? 'bg-[var(--color-tertiary)] text-[var(--foreground)]' : 'text-[var(--foreground)] hover:text-[var(--foreground)] hover:bg-[var(--color-tertiary)]' }}">
                {{ __('Password') }}
            </a>
        </nav>
    </div>

    <div class="border-t border-teal-200 md:hidden"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        @if($heading)
            <h2 class="text-2xl font-bold text-[var(--foreground)]">{{ $heading }}</h2>
        @endif
        @if($subheading)
            <p class="mt-1 text-sm text-[var(--foreground)]">{{ $subheading }}</p>
        @endif

        <div class="mt-6">
            {{ $slot }}
        </div>
    </div>
</div>
