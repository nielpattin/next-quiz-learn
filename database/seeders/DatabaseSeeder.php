<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();

        $users->each(function ($user) {
            $quizzes = \App\Models\Quiz::factory(1)->create(['created_by' => $user->id]);
            $quizzes->each(function ($quiz) use ($user) {
                $questions = \App\Models\Question::factory(3)->create([
                    'quiz_id' => $quiz->id,
                    'created_by' => $user->id,
                ]);
                $questions->each(function ($question) {
                    $options = \App\Models\QuestionOption::factory(4)->create([
                        'question_id' => $question->id,
                    ]);
                    // Mark one random option as correct
                    $options->random(1)->first()->update(['is_correct' => true]);
                });
            });
        });

        User::create([
            'name' => 'User01',
            'email' => 'test@gmail.com',
            'password' => Hash::make('123123asd'),
        ]);
    }
}
