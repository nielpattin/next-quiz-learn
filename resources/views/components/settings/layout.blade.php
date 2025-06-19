@props([
    'heading' => '',
    'subheading' => ''
])

<div class="flex flex-col gap-6 md:flex-row">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav class="space-y-1">
            <a wire:navigate href="{{ route('settings.profile') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.profile') ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                {{ __('Profile') }}
            </a>
            <a wire:navigate href="{{ route('settings.password') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.password') ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                {{ __('Password') }}
            </a>
        </nav>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 md:hidden"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        @if($heading)
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $heading }}</h2>
        @endif
        @if($subheading)
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $subheading }}</p>
        @endif

        <div class="mt-6">
            {{ $slot }}
        </div>
    </div>
</div>
