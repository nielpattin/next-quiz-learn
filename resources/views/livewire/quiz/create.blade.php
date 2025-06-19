<?php

use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    /**
     */
    public function createQuiz(): void
    {
        try {
            $quiz = Quiz::create([
                'title' => 'Untitled Quiz',
                'description' => '',
                'category' => '',
                'difficulty_level' => 'medium',
                'time_limit' => 30,
                'is_active' => false, // Start as draft
                'created_by' => Auth::id(),
                
            ]);

            // Check if quiz was created successfully
            if (!$quiz || !$quiz->id) {
                throw new \Exception('Quiz creation failed - no ID returned');
            }

            // Use explicit ID parameter instead of model object
            $this->redirect(route('questions.create', ['quiz' => $quiz->id]));
            
        } catch (\Exception $e) {
            // Log the error and show user-friendly message
            \Log::error('Quiz creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Failed to create quiz. Please try again.');
        }
    }
}; ?>

<div class="w-full max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-indigo-800">Create New Quiz</h1>
        <p class="mt-1 text-sm text-indigo-600">Start building your quiz by creating the first question</p>
    </div>

    @if (session()->has('error'))
        <div class="mb-4 bg-red-50 border border-red-200 rounded-md p-4">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-teal-50 shadow rounded-lg p-8 text-center">
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        
        <h3 class="text-lg font-medium text-indigo-800 mb-2">Ready to create your quiz?</h3>
        <p class="text-indigo-600 mb-6">We'll start with a basic quiz template and then help you add your first question.</p>
        
        <div class="flex items-center justify-center space-x-4">
            <a wire:navigate href="{{ route('quizzes.index') }}" class="px-4 py-2 border border-indigo-300 rounded-md shadow-sm text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                Cancel
            </a>
            <button wire:click="createQuiz" class="px-6 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                <span wire:loading.remove>Create Quiz & Add First Question</span>
                <span wire:loading>Creating...</span>
            </button>
        </div>
    </div>
</div>