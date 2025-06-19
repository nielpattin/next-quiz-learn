<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizSession extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'status',
        'started_at',
        'completed_at',
        'paused_at',
        'time_remaining',
        'current_question_index',
        'score',
        'total_questions',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'paused_at' => 'datetime',
        'time_remaining' => 'integer',
        'current_question_index' => 'integer',
        'score' => 'integer',
        'total_questions' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questionAttempts(): HasMany
    {
        return $this->hasMany(QuestionAttempt::class);
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isPaused(): bool
    {
        return $this->status === 'paused';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getFormattedTimeRemainingAttribute(): string
    {
        $minutes = floor($this->time_remaining / 60);
        $seconds = $this->time_remaining % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getAccuracyPercentageAttribute(): float
    {
        if ($this->total_questions === 0) {
            return 0;
        }
        return round(($this->score / $this->total_questions) * 100, 2);
    }
}