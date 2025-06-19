<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'options',
        'correct_answer',
        'explanation',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the quiz that owns this question (direct relationship).
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    /**
     * Get all quizzes that this question belongs to through the pivot table.
     */
    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_question')
                    ->withPivot('order')
                    ->withTimestamps()
                    ->orderBy('quiz_question.order');
    }

    /**
     * Get the user who created this question.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}