<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Component;

class BrowseQuizzes extends Component
{
    public string $search = '';

    public function render()
    {
        $quizzes = Quiz::where('is_public', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        return view('livewire.quiz.browse-quizzes', [
            'quizzes' => $quizzes,
        ]);
    }
}