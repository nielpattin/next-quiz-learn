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
        @toast.window="let newToast = { id: Date.now(), message: $event.detail.message, type: $event.detail.type || 'success' }; toasts.push(newToast); setTimeout(() => toasts = toasts.filter(toast => toast.id !== newToast.id), 5000);"
        class="fixed top-0 right-0 p-4 z-50 w-full max-w-xs">
        <template x-for="toast in toasts" :key="toast.id">
            <div :class="{
                'bg-green-500': toast.type === 'success',
                'bg-red-500': toast.type === 'error',
                'bg-blue-500': toast.type === 'info'
            }"
                class="text-white px-4 py-2 rounded-md shadow-lg mb-3 flex items-center justify-between">
                <span x-text="toast.message"></span>
                <button @click="toasts = toasts.filter(t => t.id !== toast.id)" class="ml-4 text-white">
                    &times;
                </button>
            </div>
        </template>
    </div>
</body>
</html>
