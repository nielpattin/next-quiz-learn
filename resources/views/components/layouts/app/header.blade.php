<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[var(--background)] dark:bg-[var(--background)]">
        <header class="container border-b border-[var(--border-color)] bg-[var(--background)] dark:border-[var(--border-color)] dark:bg-[var(--background)] flex items-center py-4">
            <button x-data @click="$dispatch('open-sidebar', 'left')" class="lg:hidden p-2 rounded-md hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)]">
                <x-lucide-menu class="w-6 h-6" />
            </button>

            <a href="{{ route('dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <x-app-logo />
            </a>

            <nav class="-mb-px max-lg:hidden flex space-x-4">
                <a href="{{ route('dashboard') }}" wire:navigate class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-[var(--color-zinc-100)] dark:bg-[var(--color-zinc-700)] text-[var(--color-accent)] dark:text-[var(--color-accent)]' : 'text-[var(--foreground)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)]' }}">
                    {{ __('Dashboard') }}
                </a>
            </nav>

            <div class="flex-grow"></div>

            <nav class="me-1.5 space-x-0.5 rtl:space-x-reverse flex items-center">
                <div title="{{ __('Search') }}">
                    <a href="#" class="flex items-center justify-center h-10 w-10 rounded-md hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)] text-[var(--foreground)] dark:text-[var(--foreground)]">
                        <x-lucide-search class="w-5 h-5" />
                    </a>
                </div>
                <div title="{{ __('Repository') }}">
                    <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="max-lg:hidden flex items-center justify-center h-10 w-10 rounded-md hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)] text-[var(--foreground)] dark:text-[var(--foreground)]">
                        <x-lucide-folder class="w-5 h-5" />
                    </a>
                </div>
                <div title="{{ __('Documentation') }}">
                    <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="max-lg:hidden flex items-center justify-center h-10 w-10 rounded-md hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)] text-[var(--foreground)] dark:text-[var(--foreground)]">
                        <x-lucide-book-open class="w-5 h-5" />
                    </a>
                </div>
            </nav>

            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                <button @click="open = !open" class="cursor-pointer flex items-center justify-center h-10 w-10 rounded-full bg-[var(--color-zinc-200)] dark:bg-[var(--color-zinc-700)] text-[var(--foreground)] dark:text-[var(--foreground)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                    {{ auth()->user()->initials() }}
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 w-56 rounded-md shadow-lg origin-top-end end-0" style="display: none;">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-[var(--card-background)] dark:bg-[var(--card-background)] shadow-lg">
                        <div class="py-1">
                            <div class="px-4 py-2 text-sm text-[var(--foreground)] dark:text-[var(--foreground)]">
                                <div class="flex items-center gap-2 text-start">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span class="flex h-full w-full items-center justify-center rounded-lg bg-[var(--color-zinc-200)] text-[var(--foreground)] dark:bg-[var(--color-zinc-700)] dark:text-[var(--foreground)]">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>
                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-zinc-200 dark:border-zinc-700 my-1" />

                            <a href="{{ route('settings.profile') }}" wire:navigate class="flex items-center px-4 py-2 text-sm text-[var(--foreground)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.646.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 1.905c-.007.379.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.333.183-.583.495-.646.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.646-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.759 6.759 0 0 1 0-1.905c.007-.379-.137-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.646-.869l.213-1.28Z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                {{ __('Settings') }}
                            </a>

                            <hr class="border-zinc-200 dark:border-zinc-700 my-1" />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-[var(--foreground)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <aside x-data="{ open: false }" @open-sidebar.window="if ($event.detail === 'left') open = true" x-show="open" @keydown.escape.window="open = false" x-trap.inert.noscroll="open" class="fixed inset-y-0 left-0 z-50 flex flex-col w-72 lg:hidden border-e border-[var(--border-color)] bg-[var(--background)] dark:border-[var(--border-color)] dark:bg-[var(--background)] p-4" style="display: none;">
            <button @click="open = false" class="lg:hidden p-2 rounded-md hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)] self-start">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <nav class="mt-4 flex flex-col space-y-1">
                <div>
                    <h3 class="px-3 text-xs font-semibold uppercase text-[var(--foreground)] dark:text-[var(--foreground)]">{{ __('Platform') }}</h3>
                    <div class="mt-1 space-y-1">
                        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-[var(--color-zinc-100)] dark:bg-[var(--color-zinc-700)] text-[var(--color-accent)] dark:text-[var(--color-accent)]' : 'text-[var(--foreground)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)]' }}">
                            {{ __('Dashboard') }}
                        </a>
                    </div>
                </div>
            </nav>

            <div class="flex-grow"></div>

            <nav class="mt-4 flex flex-col space-y-1">
                <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)]">
                    {{ __('Repository') }}
                </a>
                <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-[var(--foreground)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] dark:hover:bg-[var(--color-tertiary)]">
                    {{ __('Documentation') }}
                </a>
            </nav>
        </aside>

        {{ $slot }}

    </body>
</html>
