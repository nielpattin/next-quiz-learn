<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalQuizzes;
    public $publicQuizzes;
    public $recentQuizzes;
    public $totalUsers;

    public function mount()
    {
        $this->refreshQuizStats();
    }

    public function refreshQuizStats()
    {
        if (Auth::user() && Auth::user()->role === 'admin') {
            $this->totalQuizzes = Quiz::count();
            $this->publicQuizzes = Quiz::where('is_public', true)->count();
            $this->recentQuizzes = Quiz::orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();
            $this->totalUsers = \App\Models\User::count();
        } else {
            $this->totalQuizzes = Quiz::where('created_by', Auth::id())->count();
            $this->publicQuizzes = Quiz::where('created_by', Auth::id())->where('is_public', true)->count();
            $this->recentQuizzes = Quiz::where('created_by', Auth::id())
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get();
        }
    }

    public function deleteQuiz($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->delete();

        $this->recentQuizzes = $this->recentQuizzes->reject(fn($q) => $q->id == $quizId);
        $this->refreshQuizStats();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Quiz deleted.'
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}