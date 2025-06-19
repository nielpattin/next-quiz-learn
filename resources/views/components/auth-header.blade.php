@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
</div>
