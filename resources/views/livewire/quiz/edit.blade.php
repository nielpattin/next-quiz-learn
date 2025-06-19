<?php

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public Quiz $quiz;
    public string $title = '';
    public string $description = '';
    public string $category = '';
    public string $difficulty_level = 'medium';
    public int $time_limit = 30;
    public bool $is_active = true;
    public $questions;

    public function mount(Quiz $quiz): void
    {
        // Ensure the quiz belongs to the current user
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'Unauthorized access to this quiz.');
        }

        $this->quiz = $quiz;
        $this->loadQuizData();
        $this->loadQuestions();
    }

    /**
     */
    public function loadQuizData(): void
    {
        $this->title = $this->quiz->title;
        $this->description = $this->quiz->description ?? '';
        $this->category = $this->quiz->category ?? '';
        $this->difficulty_level = $this->quiz->difficulty_level;
        $this->time_limit = $this->quiz->time_limit;
        $this->is_active = $this->quiz->is_active;
    }

    /**
     */
    public function loadQuestions(): void
    {
        $this->questions = $this->quiz->getOrderedQuestions();
    }

    /**
     */
    public function addQuestion(): void
    {
        $this->redirect(route('questions.create', ['quiz' => $this->quiz->id]));
    }

    /**
     */
    public function editQuestion($questionId): void
    {
        $question = Question::findOrFail($questionId);
        $this->redirect(route('questions.edit', [$this->quiz, $question]));
    }

    /**
     */
    public function deleteQuestion($questionId): void
    {
        $question = Question::findOrFail($questionId);
        
        // Remove from quiz question_ids
        $this->quiz->removeQuestion($questionId);
        
        // Delete the question
        $question->delete();
        
        // Reload questions
        $this->loadQuestions();
        
        session()->flash('message', 'Question deleted successfully!');
    }

    /**
     */
    public function updateQuiz(): void
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'time_limit' => 'required|integer|min:1|max:180',
            'is_active' => 'boolean',
        ]);

        $this->quiz->update($validated);

        session()->flash('message', 'Quiz updated successfully!');
    }
}; ?>

<div class="w-full max-w-4xl mx-auto">
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-2">
            <a wire:navigate href="{{ route('quizzes.index') }}" class="hover:text-gray-900 dark:hover:text-gray-200">Quizzes</a>
            <span>/</span>
            <span class="text-gray-900 dark:text-gray-200">{{ $quiz->title }}</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Quiz</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update your quiz details and manage questions</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md p-4">
            <p class="text-green-800 dark:text-green-200">{{ session('message') }}</p>
        </div>
    @endif

    <form wire:submit="updateQuiz" class="mb-8">
        <div class="bg-white dark:bg-zinc-900 shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Quiz Information</h2>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span wire:loading.remove wire:target="updateQuiz">Save Changes</span>
                    <span wire:loading wire:target="updateQuiz">Saving...</span>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
                    <input wire:model="title" id="title" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <input wire:model="category" id="category" type="text" placeholder="e.g., Science, History, Math" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="difficulty_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Difficulty Level *</label>
                    <select wire:model="difficulty_level" id="difficulty_level" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                    @error('difficulty_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="time_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time Limit (minutes) *</label>
                    <input wire:model="time_limit" id="time_limit" type="number" min="1" max="180" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    @error('time_limit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input wire:model="is_active" id="is_active" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Active (visible to users)</label>
                </div>
            </div>
        </div>
    </form>

    <div class="bg-white dark:bg-zinc-900 shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ count($questions) }} Questions</h2>
            <button type="button" wire:click="addQuestion" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Question
            </button>
        </div>

        @if (count($questions) > 0)
            <div class="space-y-4">
                @foreach ($questions as $index => $question)
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Question {{ $index + 1 }}</span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $question->type === 'multiple_choice' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                        {{ $question->type === 'multiple_choice' ? 'Multiple Choice' : 'True/False' }}
                                    </span>
                                </div>
                                <p class="text-gray-900 dark:text-gray-100 font-medium mb-2">{{ $question->question }}</p>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    @if ($question->options)
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach ($question->options as $optionIndex => $option)
                                                <div class="flex items-center space-x-2">
                                                    @if ($optionIndex === $question->correct_answer)
                                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @else
                                                        <div class="w-4 h-4"></div>
                                                    @endif
                                                    <span>{{ $option }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button wire:click="editQuestion('{{ $question->id }}')"
                                        class="px-3 py-1.5 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                    Edit
                                </button>
                                <button wire:click="deleteQuestion('{{ $question->id }}')"
                                        wire:confirm="Are you sure you want to delete this question?"
                                        class="px-3 py-1.5 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">No questions yet</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Get started by adding your first question to this quiz.</p>
                <div class="mt-4">
                    <button wire:click="addQuestion" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add First Question
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-6 flex items-center justify-between">
        <a wire:navigate href="{{ route('quizzes.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            ← Back to Quizzes
        </a>
        @if (count($questions) > 0)
            <span class="text-sm text-gray-600 dark:text-gray-400">
                Quiz is {{ $quiz->is_active ? 'active' : 'inactive' }} with {{ count($questions) }} question{{ count($questions) === 1 ? '' : 's' }}
            </span>
        @endif
    </div>
</div>