<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'quiz_id' => Quiz::factory(),
            'created_by' => User::factory(),
            'question' => $this->faker->sentence(8),
            'type' => 'multiple_choice',
        ];
    }
}