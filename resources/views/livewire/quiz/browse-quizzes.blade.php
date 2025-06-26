<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-foreground mb-6">Browse Public Quizzes</h1>

    @if ($quizzes->isEmpty())
        <p class="text-foreground">No public quizzes available at the moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($quizzes as $quiz)
                <div class="bg-card-bg text-card-text rounded-lg shadow-lg p-6 border border-border-color">
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-2xl font-semibold">{{ $quiz->title }}</h2>
                        @if($quiz->is_pro)
                            <span class="bg-[var(--color-accent)] text-[var(--button-primary-foreground)] px-2 py-1 rounded text-xs ml-2">Pro Only</span>
                        @endif
                    </div>
                    <p class="text-sm text-foreground-light mb-4">{{ Str::limit($quiz->description, 50) }}</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-foreground-light">Questions: {{ $quiz->questions->count() }}</span>
                            @if($quiz->is_pro)
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-[var(--accent-background)] text-[var(--accent-foreground)] text-xs font-semibold uppercase tracking-wide border border-[var(--border-default)] shadow-sm">Pro Only</span>
                            @endif
                        </div>
                        <a href="{{ route('quiz.show', $quiz->id) }}" class="bg-primary text-quaternary px-4 py-2 rounded-md hover:bg-secondary transition-colors duration-200">View Quiz</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>