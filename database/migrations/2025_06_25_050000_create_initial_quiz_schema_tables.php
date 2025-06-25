<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->bigInteger('user_id')->nullable()->index();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->bigInteger('created_by')->unsigned();
            $table->string('category')->nullable();
            $table->string('difficulty_level')->default('medium');
            $table->integer('time_limit')->default(30);
            $table->timestamps();
            $table->index(['created_by', 'created_at']);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question');
            $table->string('type')->index();
            $table->bigInteger('quiz_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->text('explanation')->nullable();
            $table->timestamps();
            $table->index(['quiz_id', 'created_at']);
            $table->index('created_by');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quiz_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status', ['in_progress', 'completed', 'expired'])->default('in_progress');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('score')->default(0);
            $table->integer('total_questions')->default(0);
            $table->timestamps();
            $table->index(['quiz_id', 'user_id']);
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('question_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
            $table->index('question_id');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::create('question_attempts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quiz_attempt_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('selected_option_id')->unsigned()->nullable();
            $table->unsignedBigInteger('question_option_id')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamp('answered_at')->nullable();
            $table->float('time_spent')->default(0);
            $table->timestamps();
            $table->unique(['quiz_attempt_id', 'question_id']);
            $table->index('quiz_attempt_id');
            $table->foreign('quiz_attempt_id')->references('id')->on('quiz_attempts')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('selected_option_id')->references('id')->on('question_options')->onDelete('set null');
            $table->foreign('question_option_id')->references('id')->on('question_options')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_attempts');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};