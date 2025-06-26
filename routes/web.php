<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Quiz management routes
    Volt::route('quizzes', 'quiz.list')->name('quizzes.index');
    Volt::route('quizzes/create', 'quiz.create')->name('quizzes.create');
    Volt::route('quizzes/{quiz}/edit', 'quiz.edit')->name('quizzes.edit');
    // Quiz browsing and playing
    Volt::route('quizzes/browse', 'quiz.browse-quizzes')->name('quizzes.browse');
    Volt::route('quizzes/{quiz}', 'quiz.show-quiz')->name('quiz.show');

    Route::get('/quizzes/{quiz}/play', \App\Livewire\Quiz\PlayQuiz::class)->name('quizzes.play');
    Route::get('/quiz-attempts/{quiz_attempt}', \App\Livewire\Quiz\ShowQuizAttemptReport::class)->name('quiz-attempts.report');
    // Question management routes
    Volt::route('quizzes/{quiz}/questions/create', 'question.create')->name('questions.create');
    Volt::route('quizzes/{quiz}/questions/{question}/edit', 'question.edit')->name('questions.edit');

    // Admin users management
    Route::get('/admin/users', \App\Livewire\Admin\ManageUsers::class)
        ->middleware(\App\Http\Middleware\AdminMiddleware::class)
        ->name('admin.users');

    // Settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Route::get('/subscription/join', function () {
    return view('subscription.join');
})->name('subscription.join');

require __DIR__.'/auth.php';
