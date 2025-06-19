<?php
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

$totalQuizzes = Quiz::where('created_by', Auth::id())->count();
$activeQuizzes = Quiz::where('created_by', Auth::id())->where('is_active', true)->count();
$recentQuizzes = Quiz::where('created_by', Auth::id())
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();
?>

<x-layouts.app :title="__('Dashboard')">
    <div class="w-full p-6 bg-blue-50 rounded-lg shadow-inner">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-indigo-800">Dashboard</h1>
            <p class="mt-1 text-sm text-indigo-600">Welcome back! Here's an overview of your quizzes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-teal-50 overflow-hidden shadow-md rounded-lg border border-teal-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-indigo-600 truncate">Total Quizzes</dt>
                                <dd class="text-lg font-medium text-indigo-800">{{ $totalQuizzes }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-teal-50 overflow-hidden shadow-md rounded-lg border border-teal-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-indigo-600 truncate">Active Quizzes</dt>
                                <dd class="text-lg font-medium text-indigo-800">{{ $activeQuizzes }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-teal-50 overflow-hidden shadow-md rounded-lg border border-teal-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-indigo-600 truncate">Total Questions</dt>
                                <dd class="text-lg font-medium text-indigo-800">
                                    {{ Quiz::where('created_by', Auth::id())->get()->sum(function($quiz) { return is_array($quiz->questions) ? count($quiz->questions) : 0; }) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-teal-50 shadow-md rounded-lg mb-8 border border-teal-200">
            <div class="px-6 py-4 border-b border-teal-200">
                <h2 class="text-lg font-medium text-indigo-800">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a wire:navigate href="{{ route('quizzes.create') }}" class="flex items-center p-4 border border-teal-200 rounded-lg hover:bg-teal-100 transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-indigo-800">Create New Quiz</h3>
                            <p class="text-sm text-indigo-600">Start building a new quiz from scratch</p>
                        </div>
                    </a>

                    <a wire:navigate href="{{ route('quizzes.index') }}" class="flex items-center p-4 border border-teal-200 rounded-lg hover:bg-teal-100 transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-indigo-800">Manage Quizzes</h3>
                            <p class="text-sm text-indigo-600">View and edit your existing quizzes</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        @if($recentQuizzes->count() > 0)
        <div class="bg-teal-50 shadow-md rounded-lg border border-teal-200">
            <div class="px-6 py-4 border-b border-teal-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-indigo-800">Recent Quizzes</h2>
                    <a wire:navigate href="{{ route('quizzes.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
                </div>
            </div>
            <div class="divide-y divide-teal-200">
                @foreach($recentQuizzes as $quiz)
                <div class="px-6 py-4 hover:bg-teal-100">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-indigo-800 truncate">{{ $quiz->title }}</h3>
                            <div class="mt-1 flex items-center space-x-4 text-sm text-indigo-600">
                                <span>{{ is_array($quiz->questions) ? count($quiz->questions) : 0 }} questions</span>
                                <span>{{ $quiz->created_at->diffForHumans() }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $quiz->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a wire:navigate href="{{ route('quizzes.edit', $quiz->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>
