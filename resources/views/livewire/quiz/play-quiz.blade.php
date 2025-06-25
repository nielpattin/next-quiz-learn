<div x-data="{
        showProgressBar: false,
        progressBarKey: 0,
        init() {
            window.addEventListener('show-progress-bar', () => {
                this.progressBarKey++;
                this.showProgressBar = true;
                setTimeout(() => {
                    this.showProgressBar = false;
                    $wire.proceedAfterDelay();
                }, 2000);
            });
        }
    }">
    <div class="relative">
        @if (!$quizFinished)
            @if ($currentQuestion)
                <div class="flex items-center mb-4">
                    <h2 class="text-2xl font-bold text-foreground">Play Quiz: {{ $quiz->title }}</h2>
                    <template x-if="showProgressBar">
                        <div x-cloak x-show="showProgressBar" x-transition.opacity class="ml-4">
                            <span class="circular-spinner">
                                <svg class="h-4 w-4" viewBox="0 0 40 40">
                                    <circle
                                        class="spinner-path"
                                        cx="20"
                                        cy="20"
                                        r="16"
                                        stroke-dasharray="40 60"
                                        stroke-width="2"
                                    />
                                </svg>
                            </span>
                        </div>
                    </template>
                </div>
                <div class="bg-card-bg p-6 rounded-lg shadow-md">
                    <div class="w-full h-2 bg-secondary rounded-full overflow-hidden mb-4">
                        <div
                            class="h-full bg-primary transition-all duration-500 ease-linear"
                            style="width: {{ round((($currentQuestionIndex + 1) / $questions->count()) * 100) }}%;"
                        ></div>
                    </div>
                    @if (!empty($currentQuestion->title))
                        <h3 class="text-xl font-bold mb-2 text-foreground">{{ $currentQuestion->title }}</h3>
                    @endif
                    <p class="text-lg font-semibold mb-4 text-card-text">{{ $currentQuestion->question }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach (($currentQuestion->questionOptions ?? []) as $index => $option)
                                @php
                                    $isSelected = $selectedOptionId === $option->id;
                                    $isCorrect = $option->is_correct ?? false;

                                    $colorClass = '';
                                    $hoverClass = '';

                                    switch ($index % 4) {
                                        case 0:
                                            $colorClass = 'bg-option-1-bg';
                                            $hoverClass = 'hover:bg-option-1-hover';
                                            break;
                                        case 1:
                                            $colorClass = 'bg-option-2-bg';
                                            $hoverClass = 'hover:bg-option-2-hover';
                                            break;
                                        case 2:
                                            $colorClass = 'bg-option-3-bg';
                                            $hoverClass = 'hover:bg-option-3-hover';
                                            break;
                                        case 3:
                                            $colorClass = 'bg-option-4-bg';
                                            $hoverClass = 'hover:bg-option-4-hover';
                                            break;
                                    }
                                @endphp
                                <button
                                    x-on:click="
                                        $wire.selectAnswer({{ $currentQuestion->id }}, {{ $option->id }})
                                            .then(() => {
                                                showProgressBar = true;
                                                setTimeout(() => {
                                                    showProgressBar = false;
                                                    $wire.proceedAfterDelay();
                                                }, 2000);
                                            });
                                    "
                                    :disabled="showProgressBar || {{ $answerLocked ? 'true' : 'false' }}"
                                    class="flex-1 text-left py-2 border-2 px-4 rounded-md transition-colors duration-200 cursor-pointer min-w-[150px] h-50 flex items-center justify-center text-xl
                                         @if($answerLocked && $isSelected && !$isCorrect)
                                            bg-incorrect-selected text-secondary-foreground border-incorrect
                                         @else
                                             text-secondary-foreground
                                             @if($answerLocked)
                                                 @if($isCorrect)
                                                     border-correct
                                                 @elseif($isSelected)
                                                     border-incorrect
                                                 @else
                                                     border-default
                                                 @endif
                                             @else
                                                 {{ $colorClass }} {{ $hoverClass }} border-default quiz-answer-default
                                             @endif
                                         @endif"
                                >
                                    {{ $option->option_text }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-foreground">No questions available for this quiz.</p>
                @endif
            @else
            @endif
        </div>
    </div>