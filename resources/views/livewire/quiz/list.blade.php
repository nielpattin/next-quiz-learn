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

    /**
     */
    public function getQuizzes()
    {
        return Quiz::where('created_by', Auth::id())
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

    /**
     */
    public function toggleActive($quizId)
    {
        $quiz = Quiz::where('id', $quizId)
            ->where('created_by', Auth::id())
            ->first();

        if ($quiz) {
            $quiz->update(['is_active' => !$quiz->is_active]);
            session()->flash('message', 'Quiz status updated successfully.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}; ?>

<div class="w-full">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Quizzes</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your quiz collection</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 shadow rounded-lg">
        <div class="p-6 border-b border-gray-200 dark:border-zinc-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1 max-w-lg">
                    <input 
                        wire:model.live="search" 
                        type="text" 
                        placeholder="Search quizzes..." 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    >
                </div>
                <a 
                    wire:navigate 
                    href="{{ route('quizzes.create') }}" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Quiz
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th wire:click="sortBy('title')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-700">
                            <div class="flex items-center space-x-1">
                                <span>Title</span>
                                @if ($sortBy === 'title')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15l-4 4-4-4m0-6l4-4 4 4"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Questions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-700">
                            <div class="flex items-center space-x-1">
                                <span>Created</span>
                                @if ($sortBy === 'created_at')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15l-4 4-4-4m0-6l4-4 4 4"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse ($this->getQuizzes() as $quiz)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $quiz->title }}</div>
                                    @if ($quiz->description)
                                        <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $quiz->description }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ is_array($quiz->questions) ? count($quiz->questions) : 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button
                                    wire:click="toggleActive('{{ $quiz->id }}')"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $quiz->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}"
                                >
                                    {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $quiz->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a 
                                        wire:navigate
                                        href="{{ route('quizzes.edit', $quiz->id) }}"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        wire:click="deleteQuiz('{{ $quiz->id }}')"
                                        onclick="return confirm('Are you sure you want to delete this quiz?')"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No quizzes</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new quiz.</p>
                                    <div class="mt-6">
                                        <a 
                                            wire:navigate 
                                            href="{{ route('quizzes.create') }}" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Create Quiz
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($this->getQuizzes()->hasPages())
            <div class="px-6 py-3 border-t border-gray-200 dark:border-zinc-700">
                {{ $this->getQuizzes()->links() }}
            </div>
        @endif
    </div>
</div>