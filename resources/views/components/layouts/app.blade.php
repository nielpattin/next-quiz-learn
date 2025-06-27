<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[var(--background)] text-[var(--foreground)]">
    <div class="flex h-screen">
        <x-layouts.app.sidebar :title="$title ?? null" />
        <main class="ml-64 flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
    <div x-data="{ toasts: [] }"
        @toast.window="let newToast = { id: Date.now(), message: $event.detail[0].message, type: $event.detail[0].type || 'success' }; toasts.push(newToast); setTimeout(() => toasts = toasts.filter(toast => toast.id !== newToast.id), 3000);"
        class="fixed top-0 right-0 p-4 z-50 w-full max-w-xs">
        <template x-for="toast in toasts" :key="toast.id">
            <div :class="{
                'bg-[var(--color-primary)]': toast.type === 'success',
                'bg-[var(--color-error)]': toast.type === 'error',
                'bg-[var(--color-accent)]': toast.type === 'info'
            }"
                class="text-[var(--button-primary-foreground)] px-4 py-2 rounded-md shadow-lg mb-3 flex items-center justify-between">
                <span x-text="toast.message"></span>
                <button @click="toasts = toasts.filter(t => t.id !== toast.id)" class="ml-4 text-[var(--button-primary-foreground)]">
                    &times;
                </button>
            </div>
        </template>
    </div>
</body>
</html>
