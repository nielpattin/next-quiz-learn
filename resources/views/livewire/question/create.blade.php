<?php

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public Quiz $quiz;
    public string $question = '';
    public string $type = 'multiple_choice';
    public array $options = ['', '', '', ''];
    public int $correct_answer = 0;
    public string $explanation = '';

    public function mount(Quiz $quiz): void
    {
        // Ensure the quiz belongs to the current user
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'Unauthorized access to this quiz.');
        }

        $this->quiz = $quiz;
    }

    /**
     */
    public function addOption(): void
    {
        if (count($this->options) < 6) {
            $this->options[] = '';
        }
    }

    /**
     */
    public function removeOption(int $optionIndex): void
    {
        if (count($this->options) > 2) {
            unset($this->options[$optionIndex]);
            $this->options = array_values($this->options);
            
            // Adjust correct answer index if needed
            if ($this->correct_answer >= $optionIndex) {
                $this->correct_answer = max(0, $this->correct_answer - 1);
            }
        }
    }

    /**
     */
    public function createQuestion(): void
    {
        $validated = $this->validate([
            'question' => 'required|string|max:500',
            'type' => 'required|in:multiple_choice,true_false',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|min:1|max:200',
            'correct_answer' => 'required|integer|min:0',
            'explanation' => 'nullable|string|max:200'
        ]);

        if ($this->correct_answer >= count($this->options)) {
            $this->addError('correct_answer', 'Please select a valid correct answer.');
            return;
        }

        $question = Question::create([
            'quiz_id' => $this->quiz->id,
            'question' => $this->question,
            'type' => $this->type,
            'explanation' => $this->explanation,
            'created_by' => Auth::id()
        ]);

        foreach ($this->options as $index => $optionText) {
            $question->quizQuestionOptions()->create([
                'option_text' => $optionText,
                'is_correct' => $index === $this->correct_answer,
            ]);
        }

        $this->redirect(route('questions.edit', [$this->quiz, $question]));
    }

    /**
     */
    public function updatedType(): void
    {
        if ($this->type === 'true_false') {
            $this->options = ['True', 'False'];
            $this->correct_answer = 0;
        } elseif ($this->type === 'multiple_choice' && count($this->options) === 2) {
            $this->options = ['', '', '', ''];
            $this->correct_answer = 0;
        }
    }
}; ?>

<div class="w-full max-w-3xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-[var(--foreground)] mb-2">
            <a wire:navigate href="{{ route('quizzes.index') }}" class="hover:text-[var(--foreground)]">Quizzes</a>
            <span>/</span>
            <span class="text-[var(--foreground)]">{{ $quiz->title }}</span>
            <span>/</span>
            <span class="text-[var(--foreground)]">New Question</span>
        </nav>
        <div class="flex items-center justify-between my-4">
            <a wire:navigate href="{{ route('quizzes.edit', $quiz) }}" class="px-4 py-2 border border-[var(--border-color)] rounded-md shadow-sm text-sm font-medium text-[var(--foreground)] bg-[var(--card-background)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                Cancel
            </a>
            <button type="submit" form="create-question-form" class="px-6 py-2 bg-[var(--color-primary)] hover:bg-[var(--color-tertiary)] text-[var(--button-primary-foreground)] font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                <span wire:loading.remove>Create Question</span>
                <span wire:loading>Creating...</span>
            </button>
        </div>
        <h1 class="text-2xl font-bold text-[var(--foreground)]">Add Question</h1>
        <p class="mt-1 text-sm text-[var(--foreground)]">Create a new question for "{{ $quiz->title }}"</p>
    </div>

    <form wire:submit="createQuestion" id="create-question-form" class="space-y-6">
        <div class="bg-[var(--background)] shadow rounded-lg p-6">
            <div class="space-y-6">
                <div>
                    <label for="question" class="block text-sm font-medium text-[var(--foreground)]">Question Text *</label>
                    <textarea wire:model="question" id="question" rows="3" placeholder="Enter your question here..." class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-background)] text-[var(--foreground)]"></textarea>
                    @error('question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-[var(--foreground)]">Question Type *</label>
                    <select wire:model.live="type" id="type" class="mt-1 block w-40 px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-background)] text-[var(--foreground)]">
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True/False</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-[var(--foreground)]">Answer Options *</label>
                        @if ($type === 'multiple_choice' && count($options) < 6)
                            <button type="button" wire:click="addOption" class="text-sm text-[var(--color-primary)] hover:text-[var(--color-secondary)] font-medium">
                                + Add Option
                            </button>
                        @endif
                    </div>
                    
                    @foreach ($options as $optionIndex => $option)
                        <div class="flex items-center space-x-3 mb-3">
                            <input type="radio" 
                                   name="correct_answer" 
                                   wire:click="$set('correct_answer', {{ $optionIndex }})" 
                                   @checked($correct_answer == $optionIndex)
                                   class="h-4 w-4 text-[var(--color-primary)] focus:ring-[var(--color-primary)] border-[var(--border-color)]">
                            <input wire:model="options.{{ $optionIndex }}"
                                   type="text"
                                   placeholder="Option {{ $optionIndex + 1 }}"
                                   class="flex-1 px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-background)] text-[var(--foreground)]">
                            @if ($type === 'multiple_choice' && count($options) > 2)
                                <button type="button" wire:click="removeOption({{ $optionIndex }})" class="text-red-600 hover:text-red-800 p-1">
                                    <x-lucide-x class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                        @error("options.{$optionIndex}") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @endforeach
                    @error('correct_answer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-[var(--foreground)] mt-2">Select the radio button next to the correct answer</p>
                </div>

                <div>
                    <label for="explanation" class="block text-sm font-medium text-[var(--foreground)]">Explanation (optional)</label>
                    <textarea wire:model="explanation" id="explanation" rows="3" maxlength="200" placeholder="Explain why this is the correct answer..." class="mt-1 block w-full px-3 py-2 border border-[var(--border-color)] rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-background)] text-[var(--foreground)]"></textarea>
                    @error('explanation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </form>
</div>