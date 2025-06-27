<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background dark:bg-background text-foreground flex pt-6 items-center lg:justify-center min-h-screen flex-col relative overflow-x-hidden">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="/quizzes/browse"
                            class="inline-block px-5 py-1.5 border border-border hover:border-accent rounded-sm text-sm leading-normal text-foreground dark:text-foreground transition-colors duration-200"
                        >
                            Discover Quizzes
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 border border-transparent hover:border-accent rounded-sm text-sm leading-normal text-foreground dark:text-foreground transition-colors duration-200"
                        >
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 border border-border hover:border-accent rounded-sm text-sm leading-normal text-foreground dark:text-foreground transition-colors duration-200"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        <div class="absolute inset-0 pointer-events-none select-none z-0">
            <div class="w-[600px] h-[600px] bg-gradient-to-br from-primary/20 via-secondary/10 to-accent/10 rounded-full blur-3xl opacity-60 dark:opacity-40 absolute -top-40 -left-40 animate-pulse"></div>
            <div class="w-[400px] h-[400px] bg-gradient-to-tr from-accent/20 via-primary/10 to-secondary/10 rounded-full blur-2xl opacity-50 dark:opacity-30 absolute -bottom-24 -right-24 animate-pulse"></div>
        </div>
        <main class="flex  w-full flex-col-reverse lg:max-w-4xl lg:flex-row z-10">
            <div class="relative flex flex-col items-center justify-center w-full mx-auto shrink-0 overflow-visible bg-card-bg dark:bg-card-bg rounded-2xl shadow-xl ring-1 ring-border/10 dark:ring-border/20 p-8 aspect-[335/376] lg:aspect-auto mb-8 lg:mb-0">
                <div class="flex flex-col items-center w-full">
                    <div class="relative flex flex-col items-center w-full">
                        <div class="flex justify-center w-full">
                            <div class="relative -mt-16 mb-2 z-10">
                                <img src="{{ asset('images/quiz-learn-logo.png') }}" alt="Next Quiz Learn Logo" class="w-28 h-28 drop-shadow-lg animate-bounce">
                            </div>
                        </div>
                        <div class="relative z-10 flex flex-col items-center mb-8">
                    <h1 class="text-3xl font-extrabold tracking-tight text-center text-foreground dark:text-foreground drop-shadow-2xl mb-2">
                        Welcome to <span class="">Next Quiz Learn!</span>
                    </h1>
                    <p class="text-lg text-center text-muted-foreground dark:text-muted-foreground mb-4 max-w-4xl">
                        Fun, cute, and powerful quizzes for everyone. Challenge yourself, learn new things, and join our playful community!
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-primary text-primary-foreground shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 dark:focus:ring-offset-background text-base font-semibold mt-2">
                        <x-lucide-arrow-right class="w-5 h-5" />
                        Get Started
                    </a>
                </div>
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-32 h-8 bg-gradient-to-t from-card-bg to-transparent blur-lg opacity-60"></div>
            </div>
            <section class="flex-1 flex flex-col items-center justify-center gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                    <div class="rounded-xl bg-card-bg dark:bg-card-bg shadow-lg ring-1 ring-border/10 dark:ring-border/20 p-6 flex flex-col items-center hover:scale-105 hover:shadow-xl transition-all duration-200">
                        <x-lucide-users class="w-10 h-10 mb-2 text-primary" />
                        <h2 class="font-bold text-lg text-foreground mb-1">Create Quizzes</h2>
                        <p class="text-muted-foreground text-center text-sm">Design your own quizzes and share them with friends or the world.</p>
                    </div>
                    <div class="rounded-xl bg-card-bg dark:bg-card-bg shadow-lg ring-1 ring-border/10 dark:ring-border/20 p-6 flex flex-col items-center hover:scale-105 hover:shadow-xl transition-all duration-200">
                        <x-lucide-play class="w-10 h-10 mb-2 text-accent" />
                        <h2 class="font-bold text-lg text-foreground mb-1">Play & Compete</h2>
                        <p class="text-muted-foreground text-center text-sm">Take quizzes, earn points, and climb the leaderboard. Learning is fun!</p>
                    </div>
                    <div class="rounded-xl bg-card-bg dark:bg-card-bg shadow-lg ring-1 ring-border/10 dark:ring-border/20 p-6 flex flex-col items-center hover:scale-105 hover:shadow-xl transition-all duration-200">
                        <x-lucide-bar-chart-2 class="w-10 h-10 mb-2 text-secondary" />
                        <h2 class="font-bold text-lg text-foreground mb-1">Track Progress</h2>
                        <p class="text-muted-foreground text-center text-sm">Monitor your learning journey and celebrate your achievements.</p>
                    </div>
                    <div class="rounded-xl bg-card-bg dark:bg-card-bg shadow-lg ring-1 ring-border/10 dark:ring-border/20 p-6 flex flex-col items-center hover:scale-105 hover:shadow-xl transition-all duration-200">
                        <x-lucide-edit class="w-10 h-10 mb-2 text-primary" />
                        <h2 class="font-bold text-lg text-foreground mb-1">Join Community</h2>
                        <p class="text-muted-foreground text-center text-sm">Connect, compete, and collaborate with other quiz lovers.</p>
                    </div>
                </div>
            </section>
        </main>
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
