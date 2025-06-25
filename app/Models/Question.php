<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\QuestionOption;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'explanation',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Eager load question options by default
    protected $with = ['questionOptions'];

    /**
     * Get the quiz that owns the question.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the user who created the question.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the options for the question.
     */
    public function questionOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    /**
     * Alias for questionOptions to support legacy or alternate naming.
     */
    public function quizQuestionOptions(): HasMany
    {
        return $this->questionOptions();
    }

    /**
     * Get the attempts for the question.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuestionAttempt::class);
    }
}