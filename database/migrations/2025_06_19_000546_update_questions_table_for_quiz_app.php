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
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('title', 'question');
            $table->renameColumn('answer', 'correct_answer');
            $table->text('explanation')->nullable()->after('correct_answer');
            // Drop the 'content' column as it's replaced by 'explanation'
            $table->dropColumn('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('question', 'title');
            $table->renameColumn('correct_answer', 'answer');
            $table->dropColumn('explanation');
            // Re-add the 'content' column if needed for rollback, though it's better to manage data through 'explanation'
            $table->text('content')->nullable();
        });
    }
};
