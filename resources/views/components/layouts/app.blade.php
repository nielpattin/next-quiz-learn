<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @livewireStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50">
    <x-layouts.app.sidebar :title="$title ?? null">
        <main class="ml-64 flex-1 p-6">
            {{ $slot }}
        </main>
    </x-layouts.app.sidebar>
    @livewireScripts
</body>
</html>
