@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-3xl font-bold text-[var(--foreground)] dark:text-[var(--foreground)]">{{ $title }}</h1>
    <p class="mt-2 text-sm text-[var(--foreground)] dark:text-[var(--foreground)]">{{ $description }}</p>
</div>
