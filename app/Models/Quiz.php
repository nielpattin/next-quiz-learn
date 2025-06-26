<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Quiz extends Model
{
    use HasFactory;


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
        'is_public',
        'is_pro',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_public' => 'boolean',
        'is_pro' => 'boolean',
    ];

    /**
     * Get the user who created this quiz.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Get the questions directly associated with this quiz.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    /**
     * Get the quiz attempts for the quiz.
     */
    public function quizAttempts(): HasMany
    {
        if (Schema::hasTable('quiz_attempts')) {
            return $this->hasMany(QuizAttempt::class);
        }
        return $this->hasMany(QuizAttempt::class)->whereRaw('1=0');
    }
    public function getOrderedQuestions()
    {
        return $this->questions()->orderBy('created_at')->get();
    }

    public function removeQuestion($questionId)
    {
        $question = $this->questions()->find($questionId);
        if ($question) {
            // No action needed, as the question is deleted immediately after.
            // This method exists to satisfy the Livewire component call.
            return true;
        }
        return false;
    }
}