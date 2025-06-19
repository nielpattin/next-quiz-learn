<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('question_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_session_id')->constrained('quiz_sessions')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->integer('selected_answer')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamp('answered_at')->nullable();
            $table->integer('time_spent')->default(0);
            $table->timestamps();

            $table->unique(['quiz_session_id', 'question_id'], 'unique_session_question');
            $table->index('quiz_session_id', 'idx_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_attempts');
    }
};
