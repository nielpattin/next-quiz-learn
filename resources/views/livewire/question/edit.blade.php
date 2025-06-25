<?php

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public Quiz $quiz;
    public Question $question;
    public string $questionText = '';
    public string $type = 'multiple_choice';
    public array $options = ['', '', '', ''];
    public int $correct_answer = 0;
    public string $explanation = '';

    public function mount(Quiz $quiz, Question $question): void
    {
        // Ensure the quiz belongs to the current user
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'Unauthorized access to this quiz.');
        }

        // Ensure the question belongs to this quiz
        if ((string) $question->quiz_id !== (string) $quiz->id) {
            abort(404, 'Question not found in this quiz.');
        }

        $this->quiz = $quiz;
        $this->question = $question;

        // Load question data
        $this->questionText = $this->question->question;
        $this->type = $this->question->type;
        $this->options = $this->question->options ?? ['', '', '', ''];
        $this->correct_answer = $this->question->correct_answer;
        $this->explanation = $this->question->explanation ?? '';
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
    public function updateQuestion(): void
    {
        $validated = $this->validate([
            'questionText' => 'required|string|max:500',
            'type' => 'required|in:multiple_choice,true_false',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|min:1|max:200',
            'correct_answer' => 'required|integer|min:0',
            'explanation' => 'nullable|string|max:200'
        ]);

        // Validate correct answer is within bounds
        if ($this->correct_answer >= count($this->options)) {
            $this->addError('correct_answer', 'Please select a valid correct answer.');
            return;
        }

        $this->question->update([
            'question' => $this->questionText,
            'type' => $this->type,
            'options' => $this->options,
            'correct_answer' => $this->correct_answer,
            'explanation' => $this->explanation
        ]);

        session()->flash('message', 'Question updated successfully!');
        
        // Redirect back to quiz edit
        $this->redirect(route('quizzes.edit', $this->quiz));
    }

    /**
     */
    public function deleteQuestion(): void
    {
        // Remove question ID from quiz
        $this->quiz->removeQuestion($this->question->id);
        
        // Delete the question
        $this->question->delete();

        session()->flash('message', 'Question deleted successfully!');
        
        // Redirect back to quiz edit
        $this->redirect(route('quizzes.edit', $this->quiz));
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
            <a wire:navigate href="{{ route('quizzes.edit', $quiz) }}" class="hover:text-[var(--foreground)]">{{ $quiz->title }}</a>
            <span>/</span>
            <span class="text-[var(--foreground)]">Edit Question</span>
        </nav>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[var(--foreground)]">Edit Question</h1>
                <p class="mt-1 text-sm text-[var(--foreground)] dark:text-[var(--foreground)]">Update question for "{{ $quiz->title }}"</p>
            </div>
            <button wire:click="updateQuestion" class="px-4 py-2 bg-[var(--color-accent)] hover:bg-[var(--color-tertiary)] text-[var(--color-accent-foreground)] font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-accent)]">
                <span wire:loading.remove wire:target="updateQuestion">Save</span>
                <span wire:loading wire:target="updateQuestion">Saving...</span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 bg-[var(--background)] dark:bg-[var(--color-zinc-900)] border border-[var(--border-color)] dark:border-[var(--border-color)] rounded-md p-4">
            <p class="text-[var(--foreground)] dark:text-[var(--foreground)]">{{ session('message') }}</p>
        </div>
    @endif

    <form wire:submit="updateQuestion" class="space-y-6">
        <div class="shadow rounded-lg p-6">
            <div class="space-y-6">
                <div>
                    <label for="questionText" class="block text-sm font-medium text-[var(--foreground)]">Question Text *</label>
                    <textarea wire:model="questionText" id="questionText" rows="3" placeholder="Enter your question here..." class="mt-1 block w-full px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-bg)] text-[var(--foreground)]"></textarea>
                    @error('questionText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
    
                <div>
                    <label for="type" class="block text-sm font-medium text-[var(--foreground)]">Question Type *</label>
                    <select wire:model.live="type" id="type" class="mt-1 block w-40 px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-bg)] text-[var(--foreground)]">
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True/False</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
    
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-[var(--foreground)]">Answer Options *</label>
                        @if ($type === 'multiple_choice' && count($options) < 6)
                            <button type="button" wire:click="addOption" class="text-sm text-[var(--color-accent)] hover:text-[var(--color-primary)] dark:text-[var(--color-accent)] dark:hover:text-[var(--color-secondary)] font-medium">
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
                                   class="h-4 w-4 text-[var(--color-primary)] focus:ring-[var(--color-primary)] bg-[var(--card-bg)]">
                            <input wire:model="options.{{ $optionIndex }}"
                                                                                                                                                                                                                                            type="text"
                                                                                                                                                                                                                                            placeholder="Option {{ $optionIndex + 1 }}"
                                                                                                                                                                                                                                            class="flex-1 px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-bg)] text-[var(--foreground)]">
                            @if ($type === 'multiple_choice' && count($options) > 2)
                                <button type="button" wire:click="removeOption({{ $optionIndex }})" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
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
                    <textarea wire:model="explanation" id="explanation" rows="3" maxlength="200" placeholder="Explain why this is the correct answer..." class="mt-1 block w-full px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] bg-[var(--card-bg)] text-[var(--foreground)]"></textarea>
                    @error('explanation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a wire:navigate href="{{ route('quizzes.edit', $quiz) }}" class="px-4 py-2 rounded-md shadow-sm text-sm font-medium dark:bg-[var(--background)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-primary)]">
                    Back to Quiz
                </a>
                <button type="button"
                        wire:click="deleteQuestion"
                        wire:confirm="Are you sure you want to delete this question? This action cannot be undone."
                        class="px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 dark:bg-[var(--background)] dark:text-[var(--foreground)] hover:bg-[var(--color-tertiary)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <span wire:loading.remove wire:target="deleteQuestion">Delete Question</span>
                    <span wire:loading wire:target="deleteQuestion">Deleting...</span>
                </button>
            </div>
            <button type="submit" class="px-6 py-2 bg-[var(--color-accent)] hover:bg-[var(--color-tertiary)] text-[var(--color-accent-foreground)] font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-accent)]">
                <span wire:loading.remove wire:target="updateQuestion">Save Changes</span>
                <span wire:loading wire:target="updateQuestion">Saving...</span>
            </button>
        </div>
    </form>
</div>