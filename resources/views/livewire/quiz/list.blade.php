<?php

use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    protected $listeners = ['quiz-updated' => 'refreshQuizzes', 'quiz-deleted' => 'refreshQuizzes'];

    public function refreshQuizzes()
    {
        $this->dispatch('refresh-quizzes');
        $this->dispatch('toast', message: 'Quiz updated successfully.', type: 'success');
    }

    /**
     */
    public function getQuizzes()
    {
        return Quiz::where('created_by', Auth::id())
            ->withCount('questions')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    /**
     */
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     */
    public function deleteQuiz($quizId)
    {
        $quiz = Quiz::where('id', $quizId)
            ->where('created_by', Auth::id())
            ->first();

        if ($quiz) {
            $quiz->delete();
            session()->flash('message', 'Quiz deleted successfully.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}; ?>

<div class="w-full">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-indigo-800">My Quizzes</h1>
        <p class="mt-1 text-sm text-indigo-600">Manage your quiz collection</p>
    </div>


    <div class="bg-teal-50 shadow rounded-lg">
        <div class="p-6 border-b border-teal-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1 max-w-lg">
                    <input 
                        wire:model.live="search" 
                        type="text" 
                        placeholder="Search quizzes..." 
                        class="w-full px-3 py-2 border border-teal-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 bg-white text-indigo-800"
                    >
                </div>
                <a 
                    wire:navigate 
                    href="{{ route('quizzes.create') }}" 
                    class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Quiz
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @forelse ($this->getQuizzes() as $quiz)
                <div class="bg-white rounded-lg shadow-md border border-teal-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="p-4 border-b border-teal-200">
                        <h3 class="text-lg font-semibold text-indigo-800">{{ $quiz->title }}</h3>
                        @if ($quiz->description)
                            <p class="mt-1 text-sm text-indigo-600 line-clamp-2 overflow-hidden">{{ $quiz->description }}</p>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-center justify-between text-sm text-indigo-800 mb-2">
                            <span>Questions: {{ $quiz->questions_count }}</span>
                            <span>{{ $quiz->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $quiz->is_public ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $quiz->is_public ? 'Public' : 'Private' }}
                                </span>
                                
                                <livewire:quiz.quiz-actions :quiz="$quiz" wire:key="quiz-actions-{{ $quiz->id }}" class="cursor-pointer" />
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-indigo-600">
                        <svg class="mx-auto h-12 w-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-indigo-800">No quizzes</h3>
                        <p class="mt-1 text-sm text-indigo-600">Get started by creating a new quiz.</p>
                        <div class="mt-6">
                            <a
                                wire:navigate
                                href="{{ route('quizzes.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Quiz
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($this->getQuizzes()->hasPages())
            <div class="px-6 py-3 border-t border-teal-200">
                {{ $this->getQuizzes()->links() }}
            </div>
        @endif
    </div>
</div>