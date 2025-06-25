<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE quiz_attempts ALTER COLUMN status DROP DEFAULT");
        DB::statement("CREATE TYPE quiz_attempt_status_new AS ENUM ('in_progress', 'completed')");
        DB::statement("ALTER TABLE quiz_attempts ALTER COLUMN status TYPE quiz_attempt_status_new USING status::text::quiz_attempt_status_new");
        DB::statement("DROP TYPE IF EXISTS quiz_attempt_status");
        DB::statement("ALTER TYPE quiz_attempt_status_new RENAME TO quiz_attempt_status");
        DB::statement("ALTER TABLE quiz_attempts ALTER COLUMN status SET DEFAULT 'in_progress'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE quiz_attempts ALTER COLUMN status DROP DEFAULT");
        DB::statement("CREATE TYPE quiz_attempt_status_old AS ENUM ('in_progress', 'completed', 'expired')");
        DB::statement("ALTER TABLE quiz_attempts ALTER COLUMN status TYPE quiz_attempt_status_old USING status::text::quiz_attempt_status_old");
        DB::statement("DROP TYPE IF EXISTS quiz_attempt_status");
        DB::statement("ALTER TYPE quiz_attempt_status_old RENAME TO quiz_attempt_status");
        DB::statement("ALTER TABLE quiz_attempts ALTER COLUMN status SET DEFAULT 'in_progress'");
    }
};