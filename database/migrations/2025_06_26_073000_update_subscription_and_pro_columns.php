<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('subscription')->default('Free')->after('password');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->boolean('is_pro')->default(false)->after('is_public');
            if (Schema::hasColumn('quizzes', 'time_limit')) {
                $table->dropColumn('time_limit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('subscription');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('is_pro');
            $table->integer('time_limit')->nullable();
        });
    }
};