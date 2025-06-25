<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionOption extends Model
{
    use HasFactory;
    protected $table = 'question_options';

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}