<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Quiz management routes
    Volt::route('quizzes', 'quiz.list')->name('quizzes.index');
    Volt::route('quizzes/create', 'quiz.create')->name('quizzes.create');
    Volt::route('quizzes/{quiz}/edit', 'quiz.edit')->name('quizzes.edit');
// Quiz browsing and playing
    
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
