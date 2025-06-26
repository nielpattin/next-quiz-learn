<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionOption;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create specific users
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // You might want to use a more secure password in production
            'role' => 'admin',
            'credit' => 35,
        ]);

        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'), // You might want to use a more secure password in production
            'role' => 'user',
            'credit' => 35,
        ]);

        // Load quiz data from QuizSeedData.php
        $quizData = require __DIR__.'/QuizSeedData.php';

        $quizCounter = 0;
        foreach ($quizData as $quiz) {
            $ownerId = ($quizCounter < 2) ? $regularUser->id : $adminUser->id;

            $quizModel = Quiz::create([
                'title' => $quiz['title'],
                'description' => $quiz['description'],
                'created_by' => $ownerId,
                'is_public' => true,
                'is_pro' => $quiz['is_pro'] ?? false,
            ]);

            foreach ($quiz['questions'] as $q) {
                $questionModel = Question::create([
                    'quiz_id' => $quizModel->id,
                    'created_by' => $ownerId, // Questions also owned by the same user as the quiz
                    'question' => $q['question'],
                    'type' => 'multiple_choice',
                ]);

                foreach ($q['options'] as $opt) {
                    QuestionOption::create([
                        'question_id' => $questionModel->id,
                        'option_text' => $opt['option_text'],
                        'is_correct' => $opt['is_correct'],
                    ]);
                }
            }
            $quizCounter++;
        }
    }
}
