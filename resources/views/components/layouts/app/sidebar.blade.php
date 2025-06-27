<div class="fixed inset-y-0 left-0 z-50 w-64 bg-[var(--background)] border-r border-[var(--border-color)]">
    <div class="flex flex-col h-full p-4">
        <nav class="flex-1 space-y-2">
            <a wire:navigate href="{{ route('quizzes.browse') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('quizzes.browse') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <x-lucide-search class="w-5 h-5 mr-3" />
                {{ __('Browse') }}
            </a>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a wire:navigate href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('dashboard') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                    <x-lucide-layout-dashboard class="w-5 h-5 mr-3" />
                    {{ __('Dashboard') }}
                </a>
                <a wire:navigate href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('admin.users') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                    <x-lucide-users class="w-5 h-5 mr-3" />
                    {{ __('Users') }}
                </a>
            @endif
            <a wire:navigate href="{{ route('quizzes.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('quizzes.index') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <x-lucide-book class="w-5 h-5 mr-3" />
                {{ __('My Quizzes') }}
            </a>
            <a wire:navigate href="{{ route('quizzes.create') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('quizzes.create') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <x-lucide-plus-circle class="w-5 h-5 mr-3" />
                {{ __('Create Quiz') }}
            </a>
     
            <a wire:navigate href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('settings.*') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <x-lucide-settings class="w-5 h-5 mr-3" />
                {{ __('Settings') }}
            </a>
        </nav>
        <div class="mt-4 flex flex-row gap-2 items-center">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-[var(--button-primary-foreground)] bg-[var(--button-primary-background)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</div>
