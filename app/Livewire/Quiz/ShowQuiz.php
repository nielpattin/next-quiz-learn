<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Component;

class ShowQuiz extends Component
{
    public Quiz $quiz;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function render()
    {
        return view('livewire.quiz.show-quiz');
    }
}