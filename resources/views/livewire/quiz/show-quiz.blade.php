<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-bold">{{ $quiz->title }}</h1>
        @if($quiz->is_pro && auth()->check() && !auth()->user()->isPro())
            <a href="{{ route('subscription.join') }}"
               class="inline-block px-4 py-2 rounded bg-[var(--color-primary)] text-[var(--button-primary-foreground)] hover:bg-[var(--color-tertiary)] transition">
               Join Pro
            </a>
        @elseif(!($quiz->is_pro && !auth()->user()->isPro()))
            <a href="{{ route('quizzes.play', $quiz->id) }}"
               class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-sm bg-[var(--button-primary-background)] text-[var(--button-primary-foreground)] hover:button-primary-background/90 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-button/50"
            >Play</a>
        @endif
    </div>
    <p class="text-lg text-foreground">{{ $quiz->description }}</p>

    <div class="mt-8">
        @if($quiz->is_pro && !(auth()->check() && auth()->user()->isPro()))
            <div class="bg-[var(--color-accent)] text-[var(--button-primary-foreground)] p-4 rounded mb-4">
                <p class="mb-2">This quiz is for Pro users only.</p>
            </div>
        @else
            {{-- Show questions here --}}
            <div class="bg-[var(--background)] p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2 text-foreground">Questions</h2>
                @foreach($quiz->getOrderedQuestions() as $question)
                    <div class="mb-4">
                        <div class="font-medium text-[var(--foreground)]">{{ $question->question }}</div>
                        @if($question->quizQuestionOptions && count($question->quizQuestionOptions) > 0)
                            <ul class="list-disc ml-6 mt-1 text-[var(--foreground)]">
                                @foreach($question->quizQuestionOptions as $option)
                                    <li>{{ $option->option_text }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>