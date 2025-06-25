<?php

namespace App\Livewire\Quiz;

use Livewire\Component;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuestionOption;
use App\Models\QuestionAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class PlayQuiz extends Component
{
    public Quiz $quiz;
    public $questions;
    public int $currentQuestionIndex = 0;
    public array $userAnswers = [];
    public bool $quizFinished = false;

    public ?int $selectedOptionId = null;
    public ?bool $isCorrect = null;
    public bool $answerLocked = false;

    public ?QuizAttempt $quizAttempt = null;
    public ?Carbon $questionStartTime = null;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
        if (Schema::hasTable('question_options')) {
            $this->questions = $quiz->questions()->with('questionOptions')->get();
        } else {
            $this->questions = $quiz->questions()->get();
        }
        $this->currentQuestionIndex = 0;
        $this->userAnswers = [];
        $this->quizFinished = false;
        $this->selectedOptionId = null;
        $this->isCorrect = null;
        $this->answerLocked = false;
        if (Schema::hasTable('quiz_attempts')) {
            $this->quizAttempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'user_id' => Auth::id(),
                'started_at' => now(),
            ]);
        } else {
            $this->quizAttempt = null;
        }
        $this->questionStartTime = now();
    }

    public function getCurrentQuestionProperty()
    {
        if ($this->questions->isEmpty() || $this->currentQuestionIndex < 0 || $this->currentQuestionIndex >= $this->questions->count()) {
            return null;
        }
        return $this->questions[$this->currentQuestionIndex];
    }

    public function nextQuestion()
    {
        $this->selectedOptionId = null;
        $this->isCorrect = null;
        $this->answerLocked = false;
        $this->questionStartTime = now();

        if ($this->questions->isEmpty() || $this->currentQuestionIndex >= $this->questions->count() - 1) {
            $this->quizFinished = true;
            $this->quizAttempt->update([
                'completed_at' => now(),
                'score' => $this->getScoreProperty(),
            ]);
        } else {
            $this->currentQuestionIndex++;
        }
    }

    public function selectAnswer(int $questionId, int $optionId)
    {
        if ($this->answerLocked) {
            return;
        }

        $this->selectedOptionId = $optionId;
        $question = $this->questions->firstWhere('id', $questionId);
        $option = $question && isset($question->questionOptions)
            ? $question->questionOptions->firstWhere('id', $optionId)
            : (isset($question->options) ? $question->options->firstWhere('id', $optionId) : null);
        $this->isCorrect = $option ? $option->is_correct : false;
        $this->userAnswers[$questionId] = $optionId;
        $this->answerLocked = true;

        $timeSpent = $this->questionStartTime ? now()->diffInSeconds($this->questionStartTime) : null;

        if (Schema::hasTable('question_attempts')) {
            QuestionAttempt::create([
                'quiz_attempt_id' => $this->quizAttempt ? $this->quizAttempt->id : null,
                'question_id' => $questionId,
                'question_option_id' => $optionId,
                'answered_at' => now(),
                'time_spent' => $timeSpent,
            ]);
        }

        $this->dispatch('$refresh');
    }

    public function getScoreProperty()
    {
        $score = 0;
        foreach ($this->questions as $question) {
            $qid = $question->id;
            $options = $question->options ?? $question->questionOptions ?? null;
            if (
                isset($this->userAnswers[$qid])
                && $options
                && $options->firstWhere('id', $this->userAnswers[$qid])?->is_correct
            ) {
                $score++;
            }
        }
        return $score;
    }

    public function getIsQuestionAnsweredProperty()
    {
        return $this->answerLocked === true;
    }

    public function render()
    {
        return view('livewire.quiz.play-quiz', [
            'currentQuestion' => $this->currentQuestion,
            'quiz' => $this->quiz,
            'quizFinished' => $this->quizFinished,
            'selectedOptionId' => $this->selectedOptionId,
            'isCorrect' => $this->isCorrect,
            'answerLocked' => $this->answerLocked,
            'isQuestionAnswered' => $this->isQuestionAnswered,
            'score' => method_exists($this, 'getScoreProperty') ? $this->getScoreProperty() : null,
        ])->layout('components.layouts.app');
    }
}