<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionAttempt extends Model
{
    protected $fillable = [
        'quiz_session_id',
        'question_id',
        'selected_answer',
        'is_correct',
        'answered_at',
        'time_spent',
    ];

    protected $casts = [
        'selected_answer' => 'integer',
        'is_correct' => 'boolean',
        'answered_at' => 'datetime',
        'time_spent' => 'integer',
    ];

    public function quizSession(): BelongsTo
    {
        return $this->belongsTo(QuizSession::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
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