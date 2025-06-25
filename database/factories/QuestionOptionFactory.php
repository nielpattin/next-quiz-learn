<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionOptionFactory extends Factory
{
    protected $model = QuestionOption::class;

    public function definition()
    {
        return [
            'question_id' => Question::factory(),
            'option_text' => $this->faker->sentence(4),
            'is_correct' => false,
        ];
    }
}