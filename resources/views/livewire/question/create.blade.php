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
            'explanation' => 'nullable|string|max:500'
        ]);

        // Validate correct answer is within bounds
        if ($this->correct_answer >= count($this->options)) {
            $this->addError('correct_answer', 'Please select a valid correct answer.');
            return;
        }

        $question = Question::create([
            'quiz_id' => $this->quiz->id,
            'question' => $this->question,
            'type' => $this->type,
            'options' => $this->options,
            'correct_answer' => $this->correct_answer,
            'explanation' => $this->explanation,
            'created_by' => Auth::id()
        ]);

        // Add question ID to quiz's question_ids array
        $this->quiz->addQuestion($question->id);

        // Redirect to edit the question
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
        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-2">
            <a wire:navigate href="{{ route('quizzes.index') }}" class="hover:text-gray-900 dark:hover:text-gray-200">Quizzes</a>
            <span>/</span>
            <span class="text-gray-900 dark:text-gray-200">{{ $quiz->title }}</span>
            <span>/</span>
            <span class="text-gray-900 dark:text-gray-200">New Question</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add Question</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Create a new question for "{{ $quiz->title }}"</p>
    </div>

    <form wire:submit="createQuestion" class="space-y-6">
        <div class="bg-white dark:bg-zinc-900 shadow rounded-lg p-6">
            <div class="space-y-6">
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question Text *</label>
                    <textarea wire:model="question" id="question" rows="3" placeholder="Enter your question here..." class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                    @error('question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question Type *</label>
                    <select wire:model.live="type" id="type" class="mt-1 block w-40 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True/False</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer Options *</label>
                        @if ($type === 'multiple_choice' && count($options) < 6)
                            <button type="button" wire:click="addOption" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
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
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <input wire:model="options.{{ $optionIndex }}" 
                                   type="text" 
                                   placeholder="Option {{ $optionIndex + 1 }}" 
                                   class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
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
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Select the radio button next to the correct answer</p>
                </div>

                <div>
                    <label for="explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Explanation (optional)</label>
                    <textarea wire:model="explanation" id="explanation" rows="3" placeholder="Explain why this is the correct answer..." class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                    @error('explanation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a wire:navigate href="{{ route('quizzes.edit', $quiz) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <span wire:loading.remove>Create Question</span>
                <span wire:loading>Creating...</span>
            </button>
        </div>
    </form>
</div>