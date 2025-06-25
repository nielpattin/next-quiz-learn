<?php

use Illuminate\Support\Facades\Route;
use App\Models\Quiz;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    $totalQuizzes = Quiz::count();
    $publicQuizzes = Quiz::where('is_public', true)->count();
    $recentQuizzes = Quiz::latest()->take(5)->get();

    return view('dashboard', compact('totalQuizzes', 'publicQuizzes', 'recentQuizzes'));
})->middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->name('dashboard');

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

    // Settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
