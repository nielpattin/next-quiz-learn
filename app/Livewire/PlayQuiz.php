<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\QuizSession;
use App\Models\Question;
use App\Models\QuestionAttempt;
use Illuminate\Support\Collection;
use Livewire\Component;

class PlayQuiz extends Component
{
    // Core quiz data
    public Quiz $quiz;
    public Collection $questions;
    public QuizSession $session;

    // Current state
    public int $currentQuestionIndex = 0;
    public ?string $selectedAnswer = null;
    public array $userAnswers = [];

    // Timer and progress
    public int $timeRemaining;
    public bool $isPaused = false;
    public bool $isCompleted = false;

    // Results state
    public int $score = 0;
    public int $correctAnswersCount = 0;
    public int $incorrectAnswersCount = 0;

    // UI state
    public bool $showResults = false;
    public bool $canResume = false;
    public bool $showConfirmSubmit = false;
    public bool $isAnswerChecked = false;
    public array $feedback = [];

public function getCurrentQuestionProperty(): ?Question
    {
        return $this->questions->get($this->currentQuestionIndex);
    }

    public function getProgressProperty(): float
    {
        if ($this->questions->isEmpty()) {
            return 0.0;
        }
        return round((count($this->userAnswers) / $this->questions->count()) * 100, 2);
    }
    // Lifecycle methods
    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz;
        $this->questions = $quiz->questions; // Assuming a 'questions' relationship on the Quiz model

        // Find or create a QuizSession
        $this->session = QuizSession::firstOrCreate(
            [
                'quiz_id' => $this->quiz->id,
                'user_id' => auth()->id(),
                'status' => 'in_progress',
            ],
            [
                'total_questions' => $this->questions->count(),
                'time_remaining' => $this->quiz->time_limit * 60, // Convert minutes to seconds
                'started_at' => now(),
            ]
        );

        // If an existing session was found, load its state
        if ($this->session->wasRecentlyCreated === false) {
            $this->currentQuestionIndex = $this->session->current_question_index;
            $this->timeRemaining = $this->session->time_remaining;
            $this->isPaused = $this->session->isPaused();
            $this->isCompleted = $this->session->isCompleted();

            // Load user answers from question attempts
            $this->userAnswers = $this->session->questionAttempts
                ->pluck('selected_answer', 'question_id')
                ->toArray();
        } else {
            // New session, initialize time remaining
            $this->timeRemaining = $this->quiz->time_limit * 60;
        }

        // Ensure selectedAnswer is set for the current question if already answered
        $currentQuestionModel = $this->questions->get($this->currentQuestionIndex);
        if ($currentQuestionModel && isset($this->userAnswers[$currentQuestionModel->id])) {
            $this->selectedAnswer = $this->userAnswers[$currentQuestionModel->id];
        }
    }
    public function hydrate(): void
    {
        // Placeholder
    }

    // Quiz flow control
    public function startQuiz(): void
    {
        // Placeholder
    }
    public function resumeQuiz(): void
    {
        // Placeholder
    }
    public function pauseQuiz(): void
    {
        // Placeholder
    }
    public function submitQuiz(): void
    {
        if ($this->isCompleted) {
            return;
        }

        // Calculate results
        $totalQuestions = $this->questions->count();
        $this->correctAnswersCount = 0;
        $this->incorrectAnswersCount = 0;

        foreach ($this->userAnswers as $questionId => $selectedAnswer) {
            $question = $this->questions->firstWhere('id', $questionId);
            if ($question && $selectedAnswer === $question->correct_answer) {
                $this->correctAnswersCount++;
            } else {
                $this->incorrectAnswersCount++;
            }
        }

        $this->score = $totalQuestions > 0 ? round(($this->correctAnswersCount / $totalQuestions) * 100) : 0;

        $this->session->update([
            'status' => 'completed',
            'completed_at' => now(),
            'score' => $this->score,
            'correct_answers_count' => $this->correctAnswersCount,
            'incorrect_answers_count' => $this->incorrectAnswersCount,
        ]);

        $this->isCompleted = true;
        $this->showResults = true;
        $this->saveProgress();
    }

    
    public function restartQuiz(): void
    {
        // Placeholder
    }

    // Question navigation
    public function selectAnswer($questionId, $selectedOption): void
    {
        if ($this->isAnswerChecked) {
            return; // Prevent changing answer after it's been checked
        }
        

        if ($this->session->isCompleted()) {
            throw new \Exception('Cannot modify completed quiz session');
        }

        $question = $this->questions->firstWhere('id', $questionId);

        if (!$question) {
            return;
        }

        $this->userAnswers[$question->id] = $selectedOption;
        $this->selectedAnswer = $selectedOption;

        // Save to question_attempts table
        QuestionAttempt::updateOrCreate(
            [
                'quiz_session_id' => $this->session->id,
                'question_id' => $question->id,
            ],
            [
                'selected_answer' => $selectedOption,
                'is_correct' => ($selectedOption === $question->correct_answer),
                'answered_at' => now(),
                // time_spent will be calculated later or in a separate method
            ]
        );
        $this->saveProgress();
    }

    public function checkAnswer(): void
    {
        if (is_null($this->selectedAnswer)) {
            // Optionally, add a flash message or error state if no answer is selected
            return;
        }

        $currentQuestion = $this->currentQuestion;
        $isCorrect = ($this->selectedAnswer == $currentQuestion->correct_answer);

        $this->feedback = [
            'correct' => $isCorrect,
            'correct_option' => $currentQuestion->correct_answer,
            'selected_option' => $this->selectedAnswer,
        ];

        $this->isAnswerChecked = true;

        // Save the attempt immediately after checking
        QuestionAttempt::updateOrCreate(
            [
                'quiz_session_id' => $this->session->id,
                'question_id' => $currentQuestion->id,
            ],
            [
                'selected_answer' => $this->selectedAnswer,
                'is_correct' => $isCorrect,
                'answered_at' => now(),
            ]
        );
        $this->saveProgress();
    }

    public function nextQuestion(): void
    {
        $this->isAnswerChecked = false;
        $this->selectedAnswer = null;
        $this->feedback = [];

        if ($this->currentQuestionIndex < $this->questions->count() - 1) {
            $this->currentQuestionIndex++;
            $this->selectedAnswer = $this->userAnswers[$this->currentQuestion->id] ?? null;
            $this->saveProgress();
        }
    }

    public function previousQuestion(): void
    {
        // Placeholder
    }
    public function goToQuestion(int $index): void
    {
        // Placeholder
    }

public function decrementTimer(): void
    {
        if ($this->isCompleted || $this->isPaused) {
            return;
        }

        $this->timeRemaining--;

        if ($this->timeRemaining <= 0) {
            $this->timeRemaining = 0;
            $this->submitQuiz();
            return;
        }

        // Save time remaining to database every 5 seconds
        if ($this->timeRemaining % 5 === 0) {
            $this->saveProgress();
        }
    }
    // Timer management
    public function updateTimer(): void
    {
        // Placeholder
    }
    public function handleTimerExpired(): void
    {
        // Placeholder
    }

    // Progress management
    private function saveProgress(): void
    {
        $this->session->update([
            'current_question_index' => $this->currentQuestionIndex,
            'time_remaining' => $this->timeRemaining,
            'status' => $this->isCompleted ? 'completed' : ($this->isPaused ? 'paused' : 'in_progress'),
        ]);
    }
    private function loadExistingSession(): ?QuizSession
    {
        return null; // Placeholder
    }
    
    private function canAccessQuiz(Quiz $quiz): bool
    {
        return false; // Placeholder
    }

    public function render()
    {
        return view('livewire.play-quiz');
    }
}