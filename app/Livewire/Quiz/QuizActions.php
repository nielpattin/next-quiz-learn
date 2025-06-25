<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizActions extends Component
{
    public Quiz $quiz;

    public function togglePublic()
    {
        $this->quiz->update(['is_public' => !$this->quiz->is_public]);
        $this->dispatch('quiz-updated');
    }

    public function delete()
    {
        $this->quiz->delete();
        $this->dispatch('quiz-deleted');
    }

    public function render()
    {
        return view('livewire.quiz.quiz-actions');
    }
}