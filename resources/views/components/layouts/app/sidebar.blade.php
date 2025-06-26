<div class="fixed inset-y-0 left-0 z-50 w-64 bg-[var(--background)] border-r border-[var(--border-color)]">
    <div class="flex flex-col h-full p-4">
        <nav class="flex-1 space-y-2">
            <a wire:navigate href="{{ route('quizzes.browse') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('quizzes.browse') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                {{ __('Browse') }}
            </a>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a wire:navigate href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('dashboard') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z"></path>
                    </svg>
                    {{ __('Dashboard') }}
                </a>
                <a wire:navigate href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('admin.users') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"></path>
                    </svg>
                    {{ __('Users') }}
                </a>
            @endif
            <a wire:navigate href="{{ route('quizzes.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('quizzes.index') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                {{ __('My Quizzes') }}
            </a>
            <a wire:navigate href="{{ route('quizzes.create') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('quizzes.create') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                {{ __('Create Quiz') }}
            </a>
     
            <a wire:navigate href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-[var(--color-tertiary)] hover:text-[var(--foreground)] {{ request()->routeIs('settings.*') ? 'bg-[var(--card-background)] text-[var(--foreground)]' : 'text-[var(--foreground)]' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
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
