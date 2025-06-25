<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Add this line

class Quiz extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'difficulty_level',
        'category',
        'time_limit',
        'is_public', // Add this line
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'time_limit' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_public' => 'boolean', // Add this line
    ];

    /**
     * Get the user who created this quiz.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Get the questions associated with this quiz through the pivot table.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_question')
                    ->withPivot('order')
                    ->withTimestamps()
                    ->orderBy('quiz_question.order');
    }

    /**
     * Get questions in the order specified by the pivot table.
     */
    public function getOrderedQuestions()
    {
        return $this->questions;
    }

    /**
     * Add a question to this quiz with proper ordering.
     */
    public function addQuestion($questionId)
    {
        // Get the next order number
        $maxOrder = $this->questions()->max('quiz_question.order') ?? 0;
        $nextOrder = $maxOrder + 1;
        
        // Attach the question with the next order
        $this->questions()->attach($questionId, ['order' => $nextOrder]);
    }

    /**
     * Remove a question from this quiz.
     */
    public function removeQuestion($questionId)
    {
        $this->questions()->detach($questionId);
    }

    /**
     * Get the quiz sessions for the quiz.
     */
    public function quizSessions(): HasMany
    {
        return $this->hasMany(QuizSession::class);
    }
}