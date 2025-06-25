<div>
    @if (!$quizFinished)
        @if ($currentQuestion)
            <h2 class="text-2xl font-bold mb-4 text-foreground">Play Quiz: {{ $quiz->title }}</h2>
            <div class="bg-card-bg p-6 rounded-lg shadow-md">
                @if (!empty($currentQuestion->title))
                    <h3 class="text-xl font-bold mb-2 text-foreground">{{ $currentQuestion->title }}</h3>
                @endif
                <p class="text-lg font-semibold mb-4 text-card-text">{{ $currentQuestion->question }}</p>
                <div class="space-y-2">
                    @foreach (($currentQuestion->questionOptions ?? []) as $option)
                        @php
                            $isSelected = $selectedOptionId === $option->id;
                            $isCorrect = $option->is_correct ?? false;
                        @endphp
                        <button
                            wire:click="selectAnswer({{ $currentQuestion->id }}, {{ $option->id }})"
                            class="w-full text-left py-2 border-2 px-4 rounded-md transition-colors duration-200 cursor-pointer
                                 @if($answerLocked && $isSelected && !$isCorrect)
                                     bg-incorrect-selected text-secondary-foreground border-incorrect
                                 @else
                                      text-secondary-foreground hover:bg-secondary-hover 
                                     @if($answerLocked)
                                         @if($isCorrect)
                                             border-correct
                                         @elseif($isSelected)
                                             border-incorrect
                                         @else
                                             border-default
                                         @endif
                                     @else
                                         border-default quiz-answer-default
                                     @endif
                                 @endif"
                            @if($answerLocked) disabled @endif
                        >
                            {{ $option->option_text }}
                        </button>
                    @endforeach
                </div>
                <div class="mt-6 text-right">
                    <button wire:click="nextQuestion"
                            class="py-2 px-4 rounded-md font-semibold text-sm transition-colors duration-200 cursor-pointer
                                   bg-[var(--button-primary-background)] text-[var(--button-primary-foreground)] hover:bg-[var(--color-tertiary)]"
                            @if(!$isQuestionAnswered) disabled @endif>
                        Next
                    </button>
                </div>
            </div>
        @else
            <p class="text-foreground">No questions available for this quiz.</p>
        @endif
    @else
        <h2 class="text-2xl font-bold mb-4 text-foreground">Quiz Finished!</h2>
        <div class="bg-card-bg p-6 rounded-lg shadow-md text-card-text">
            <p class="text-lg">You scored {{ $score }} out of {{ $quiz->questions->count() }} questions correctly!</p>
        </div>
    @endif
</div>