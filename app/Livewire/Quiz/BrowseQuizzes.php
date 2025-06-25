<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Component;

class BrowseQuizzes extends Component
{
    public function render()
    {
        $quizzes = Quiz::where('is_public', true)->get();

        return view('livewire.quiz.browse-quizzes', [
            'quizzes' => $quizzes,
        ]);
    }
}