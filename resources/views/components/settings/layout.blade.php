@props([
    'heading' => '',
    'subheading' => ''
])

<div class="flex flex-col gap-6 md:flex-row">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav class="space-y-1">
            <a wire:navigate href="{{ route('settings.profile') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.profile') ? 'bg-teal-100 text-indigo-800' : 'text-indigo-600 hover:text-indigo-800 hover:bg-teal-50' }}">
                {{ __('Profile') }}
            </a>
            <a wire:navigate href="{{ route('settings.password') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.password') ? 'bg-teal-100 text-indigo-800' : 'text-indigo-600 hover:text-indigo-800 hover:bg-teal-50' }}">
                {{ __('Password') }}
            </a>
        </nav>
    </div>

    <div class="border-t border-teal-200 md:hidden"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        @if($heading)
            <h2 class="text-2xl font-bold text-gray-900">{{ $heading }}</h2>
        @endif
        @if($subheading)
            <p class="mt-1 text-sm text-gray-700">{{ $subheading }}</p>
        @endif

        <div class="mt-6">
            {{ $slot }}
        </div>
    </div>
</div>
