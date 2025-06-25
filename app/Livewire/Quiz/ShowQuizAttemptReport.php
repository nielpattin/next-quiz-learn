<?php

namespace App\Livewire\Quiz;

use Livewire\Component;
use App\Models\QuizAttempt;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class ShowQuizAttemptReport extends Component
{
    public ?QuizAttempt $quizAttempt = null;
    public $questionAttempts = [];

    public function mount($quiz_attempt)
    {
        $quizAttempt = QuizAttempt::with([
            'questionAttempts.selectedOption',
            'questionAttempts.question.questionOptions'
        ])->find($quiz_attempt);

        if (!$quizAttempt) {
            abort(404, 'Quiz attempt not found.');
        }

        $this->quizAttempt = $quizAttempt;

    }

    #[Computed]
    public function correctQuestionsCount()
    {
        return $this->quizAttempt->questionAttempts
            ->filter(function ($attempt) {
                $correctOption = $attempt->question->questionOptions->firstWhere('is_correct', true);
                return optional($attempt->selectedOption)->id === optional($correctOption)->id;
            })
            ->count();
    }

    #[Computed]
    public function totalQuestionsCount()
    {
        if (
            !$this->quizAttempt ||
            !$this->quizAttempt->quiz ||
            !$this->quizAttempt->quiz->questions
        ) {
            return 0;
        }
        return $this->quizAttempt->quiz->questions->count();
    }


    public function redirectToPlayQuiz()
    {
        if ($this->quizAttempt && $this->quizAttempt->quiz) {
            return redirect()->route('quizzes.play', ['quiz' => $this->quizAttempt->quiz->id]);
        }
        abort(404, 'Quiz not found.');
    }

    public function redirectToBrowseQuizzes()
    {
        return $this->redirectRoute('quizzes.browse');
    }

    public function render()
    {
        return view('livewire.quiz.show-quiz-attempt-report');
    }
}