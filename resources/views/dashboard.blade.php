<?php

use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public $totalQuizzes;
    public $publicQuizzes;
    public $recentQuizzes;

    public function mount()
    {
        $this->totalQuizzes = Quiz::where('created_by', Auth::id())->count();
        $this->publicQuizzes = Quiz::where('created_by', Auth::id())->where('is_public', true)->count();
        $this->recentQuizzes = Quiz::where('created_by', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function deleteQuiz($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->delete();
        $this->recentQuizzes = Quiz::where('created_by', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        $this->totalQuizzes = Quiz::where('created_by', Auth::id())->count();
        $this->publicQuizzes = Quiz::where('created_by', Auth::id())->where('is_public', true)->count();
    }
}; ?>

<x-layouts.app :title="__('Dashboard')">
    <div class="w-full p-6 bg-[var(--background)] rounded-lg shadow-inner">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-[var(--foreground)]">Dashboard</h1>
            <p class="mt-1 text-sm text-[var(--foreground)]">Welcome back! Here's an overview of your quizzes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-[var(--background)] overflow-hidden shadow-md rounded-lg border border-[var(--border-color)]">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-[var(--foreground)] truncate">Total Quizzes</dt>
                                <dd class="text-lg font-medium text-[var(--foreground)]">{{ $totalQuizzes }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[var(--background)] overflow-hidden shadow-md rounded-lg border border-[var(--border-color)]">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-[var(--foreground)] truncate">Public Quizzes</dt>
                                <dd class="text-lg font-medium text-[var(--foreground)]">{{ $publicQuizzes }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[var(--background)] overflow-hidden shadow-md rounded-lg border border-[var(--border-color)]">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-[var(--color-secondary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-[var(--foreground)] truncate">Total Questions</dt>
                                <dd class="text-lg font-medium text-[var(--foreground)]">
                                    {{ Quiz::where('created_by', Auth::id())->get()->sum(function($quiz) { return $quiz->questions->count(); }) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[var(--background)] shadow-md rounded-lg mb-8 border border-[var(--border-color)]">
            <div class="px-6 py-4 border-b border-[var(--border-color)]">
                <h2 class="text-lg font-medium text-[var(--foreground)]">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a wire:navigate href="{{ route('quizzes.create') }}" class="flex items-center p-4 border border-[var(--border-color)] rounded-lg hover:bg-[var(--color-tertiary)] transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-[var(--foreground)]">Create New Quiz</h3>
                            <p class="text-sm text-[var(--foreground)]">Start building a new quiz from scratch</p>
                        </div>
                    </a>

                    <a wire:navigate href="{{ route('quizzes.index') }}" class="flex items-center p-4 border border-[var(--border-color)] rounded-lg hover:bg-[var(--color-tertiary)] transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-[var(--foreground)]">Manage Quizzes</h3>
                            <p class="text-sm text-[var(--foreground)]">View and edit your existing quizzes</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        @if($recentQuizzes->count() > 0)
        <div class="bg-[var(--background)] shadow-md rounded-lg border border-[var(--border-color)]">
            <div class="px-6 py-4 border-b border-[var(--border-color)]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-[var(--foreground)]">Recent Quizzes</h2>
                    <a wire:navigate href="{{ route('quizzes.index') }}" class="text-sm text-[var(--foreground)] hover:text-[var(--foreground)]">View all</a>
                </div>
            </div>
            <div class="divide-y divide-[var(--border-color)]">
                @foreach($recentQuizzes as $quiz)
                <div class="px-6 py-4 hover:bg-[var(--color-tertiary)]">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-[var(--foreground)] truncate">{{ $quiz->title }}</h3>
                            <div class="mt-1 flex items-center space-x-4 text-sm text-[var(--foreground)]">
                                <span>{{ $quiz->questions->count() }} questions</span>
                                <span>{{ $quiz->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($quiz->created_by == Auth::id())
                                <a wire:navigate href="{{ route('quizzes.edit', $quiz->id) }}" class="text-[var(--foreground)] hover:text-[var(--foreground)] text-sm font-medium">Edit</a>
                            @endif
                            <a wire:navigate href="{{ route('quiz.show', $quiz->id) }}" class="text-[var(--color-primary)] hover:underline text-sm font-medium ml-2">View</a>
                            <form wire:submit.prevent="deleteQuiz({{ $quiz->id }})" class="inline ml-2">
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this quiz?');"
                                    class="text-[var(--color-danger)] hover:underline text-sm font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>
