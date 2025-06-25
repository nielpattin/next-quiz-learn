<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-bold">{{ $quiz->title }}</h1>
        <a href="{{ route('quizzes.play', $quiz->id) }}"
           class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-sm bg-[var(--button-primary-background)] text-[var(--button-primary-foreground)] hover:button-primary-background/90 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-button/50"
        >Play</a>
    </div>
    <p class="text-lg text-foreground">{{ $quiz->description }}</p>

    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-2 text-foreground">Quiz Attempts</h2>
        @php
            $attempts = $quiz->quizAttempts()->with('user')->orderByDesc('created_at')->get();
        @endphp
        @if ($attempts->isEmpty())
            <p class="text-foreground">No attempts yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-card-bg text-card-text rounded-lg shadow border border-border-color">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">User</th>
                            <th class="px-4 py-2 text-left">Score</th>
                            <th class="px-4 py-2 text-left">Started At</th>
                            <th class="px-4 py-2 text-left">Completed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attempts as $attempt)
                            <tr>
                                <td class="px-4 py-2">{{ $attempt->user->name ?? 'Unknown' }}</td>
                                <td class="px-4 py-2">{{ $attempt->score ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $attempt->started_at ? $attempt->started_at->format('Y-m-d H:i') : '-' }}</td>
                                <td class="px-4 py-2">{{ $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>