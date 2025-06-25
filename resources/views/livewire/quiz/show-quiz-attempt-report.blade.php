<div class="min-h-screen flex flex-col items-center justify-center bg-background text-foreground px-4 py-8">
    <div class="w-full max-w-2xl bg-card-bg rounded-lg shadow-lg p-8 flex flex-col gap-6">
        <h1 class="text-3xl font-bold text-center mb-2">Quiz Finished!</h1>
        <h2 class="text-xl font-semibold text-center mb-4">{{ $quizAttempt->quiz?->title ?? 'Quiz Report' }}</h2>
        <div class="flex flex-col items-center mb-6">
            <span class="text-lg font-medium">Score</span>
            <span class="text-2xl font-bold mt-1">
                {{ $this->correctQuestionsCount }} / {{ $this->totalQuestionsCount }}
            </span>
        </div>
        <div class="divide-y divide-border">
            @foreach($quizAttempt->questionAttempts as $questionAttempt)
                <div class="mb-8 p-4 border rounded-lg bg-card-bg shadow-sm">
                    <h3 class="text-lg font-semibold mb-4 text-foreground">{{ $questionAttempt->question->question }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($questionAttempt->question->questionOptions as $option)
                            @php
                                $correctOptionForQuestion = $questionAttempt->question->questionOptions->firstWhere('is_correct', true);
                                $isCorrect = $option->id === optional($correctOptionForQuestion)->id;
                                $isSelected = $option->id === $questionAttempt->question_option_id;
                                $optionClasses = 'p-3 border rounded-md text-foreground';
                                if ($isCorrect) {
                                    $optionClasses .= ' border-[var(--color-correct-border)] bg-[var(--color-correct-bg)]';
                                } elseif ($isSelected && !$isCorrect) {
                                    $optionClasses .= ' border-red-500 bg-red-200';
                                } else {
                                    $optionClasses .= ' border-border-light bg-background-light';
                                }
                            @endphp
                            <div class="{{ $optionClasses }} flex items-center gap-2 relative">
                                @if($isCorrect)
                                    <span class="absolute top-0 right-0 w-6 h-6 bg-[var(--color-success-bg)] text-[var(--color-success-foreground)] rounded-full flex items-center justify-center p-1" style="transform: translate(33%, -33%);">
                                        <svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 16 16">
                                            <path d="M4 8.5l3 3 5-5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                @endif
                                @if($isSelected)
                                    <span class=" w-5 h-5 rounded-full border-2 border-primary bg-primary/10 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="6"/>
                                        </svg>
                                    </span>
                                @endif
                                <span class="grow break-words overflow-hidden text-foreground">{{ $option->option_text }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center">
            <button
                type="button"
                wire:click="redirectToPlayQuiz"
                class="cursor-pointer w-full sm:w-auto px-6 py-2 bg-[var(--button-primary-background)] text-[var(--button-primary-foreground)] rounded transition"
            >
                Play Again
            </button>
            <button
                type="button"
                wire:click="redirectToBrowseQuizzes"
                class="cursor-pointer w-full sm:w-auto px-6 py-2 rounded bg-muted text-foreground font-semibold hover:bg-muted/80 transition"
            >
                View Quizzes
            </button>
        </div>
    </div>
</div>