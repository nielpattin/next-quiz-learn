<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-foreground mb-6">Browse Public Quizzes</h1>

    @if ($quizzes->isEmpty())
        <p class="text-foreground">No public quizzes available at the moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($quizzes as $quiz)
                <div class="bg-card-bg text-card-text rounded-lg shadow-lg p-6 border border-border-color">
                    <h2 class="text-2xl font-semibold mb-2">{{ $quiz->title }}</h2>
                    <p class="text-sm text-foreground-light mb-4">{{ Str::limit($quiz->description, 50) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-foreground-light">Questions: {{ $quiz->questions->count() }}</span>
                        <a href="{{ route('quiz.show', $quiz->id) }}" class="bg-primary text-quaternary px-4 py-2 rounded-md hover:bg-secondary transition-colors duration-200">View Quiz</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>