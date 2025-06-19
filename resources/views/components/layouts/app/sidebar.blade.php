<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-blue-50">
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-100 border-r border-blue-200">
        <div class="flex flex-col h-full p-4">
            <nav class="flex-1 space-y-2">
                <a wire:navigate href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-blue-200 {{ request()->routeIs('dashboard') ? 'bg-teal-200 text-teal-800' : 'text-indigo-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z"></path>
                    </svg>
                    {{ __('Dashboard') }}
                </a>
                <a wire:navigate href="{{ route('quizzes.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-blue-200 {{ request()->routeIs('quizzes.index') ? 'bg-teal-200 text-teal-800' : 'text-indigo-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    {{ __('My Quizzes') }}
                </a>
                <a wire:navigate href="{{ route('quizzes.create') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-blue-200 {{ request()->routeIs('quizzes.create') ? 'bg-teal-200 text-teal-800' : 'text-indigo-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Create Quiz') }}
                </a>
                <a wire:navigate href="{{ route('settings.profile') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-blue-200 {{ request()->routeIs('settings.*') ? 'bg-teal-200 text-teal-800' : 'text-indigo-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ __('Settings') }}
                </a>
            </nav>
            
            <div class="mt-4">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{ $slot }}
</body>

</html>
