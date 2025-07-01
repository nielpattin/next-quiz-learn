<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[var(--background)] antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-full flex-col p-10 text-[var(--foreground)] lg:flex dark:border-e dark:border-[var(--border-color)]">
                <div class="absolute inset-0 bg-neutral-900"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-md">
                        <x-app-logo class="me-2 h-7 fill-current text-[var(--foreground)]" />
                    </span>
                    {{ config('app.name', 'Laravel') }}
                </a>


                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <p class="text-lg">&ldquo;{{ trim($message) }}&rdquo;</p>
                        <footer><p class="text-base">{{ trim($author) }}</p></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo class="size-9 fill-current text-[var(--foreground)] dark:text-[var(--foreground)]" />
                        </span>

                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
