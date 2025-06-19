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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('category')->nullable()->after('is_active');
            $table->string('difficulty_level')->default('medium')->after('category');
            $table->integer('time_limit')->default(30)->after('difficulty_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('difficulty_level');
            $table->dropColumn('time_limit');
        });
    }
};
