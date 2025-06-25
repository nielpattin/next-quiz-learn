<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class QuestionAttempt extends Model
{
    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'question_option_id',
        'answered_at',
        'time_spent',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'time_spent' => 'integer',
    ];

    public function quizAttempt(): BelongsTo
    {
        if (Schema::hasTable('quiz_attempts')) {
            return $this->belongsTo(QuizAttempt::class);
        }
        return $this->belongsTo(QuizAttempt::class)->whereRaw('1=0');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'question_option_id');
    }

    // Legacy, keep for compatibility if needed elsewhere
    public function questionOption(): BelongsTo
    {
        if (Schema::hasTable('question_options')) {
            return $this->belongsTo(QuestionOption::class);
        }
        return $this->belongsTo(QuestionOption::class)->whereRaw('1=0');
    }

    public function getFormattedTimeSpentAttribute(): string
    {
        if ($this->time_spent < 60) {
            return $this->time_spent . 's';
        }
        
        $minutes = floor($this->time_spent / 60);
        $seconds = $this->time_spent % 60;
        return sprintf('%dm %ds', $minutes, $seconds);
    }
}