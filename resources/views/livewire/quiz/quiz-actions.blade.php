<div x-data="{ open: false }" class="relative">
    <button 
        @click="open = !open"
        class="p-1 rounded-md hover:bg-[var(--color-primary)] text-foreground hover:text-quaternary focus:outline-none cursor-pointer"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        class="absolute right-0 mt-2 w-48 bg-[var(--card-background)] rounded-md shadow-lg z-50 border border-[var(--border-color)]"
    >
        <div class="py-1">
            <button
                wire:click="togglePublic"
                class="block w-full text-left px-4 py-2 text-sm text-foreground hover:bg-[var(--color-tertiary)] cursor-pointer"
            >
                {{ $quiz->is_public ? 'Make Private' : 'Make Public' }}
            </button>
            <a
                wire:navigate
                href="{{ route('quizzes.edit', $quiz->id) }}"
                class="block px-4 py-2 text-sm text-foreground hover:bg-[var(--color-tertiary)] cursor-pointer"
            >
                Edit
            </a>
            <button
                wire:click="delete"
                onclick="return confirm('Are you sure you want to delete this quiz?')"
                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-[var(--color-tertiary)] cursor-pointer"
            >
                Delete
            </button>
        </div>
    </div>
</div>