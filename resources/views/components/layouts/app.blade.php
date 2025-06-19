<x-layouts.app.sidebar :title="$title ?? null">
    <main class="ml-64 flex-1 p-6">
        {{ $slot }}
    </main>
</x-layouts.app.sidebar>
