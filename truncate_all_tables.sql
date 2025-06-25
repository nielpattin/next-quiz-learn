-- SQL script to truncate all tables in the Laravel Quiz application (PostgreSQL)
-- WARNING: This will delete ALL data from ALL tables!
-- Make sure to backup your data before running this script.

-- PostgreSQL approach: Use CASCADE to handle foreign key constraints
-- This will truncate tables and all dependent data

-- Truncate application-specific tables (with CASCADE to handle foreign keys)
TRUNCATE TABLE question_attempts CASCADE;
TRUNCATE TABLE quiz_attempts CASCADE;
TRUNCATE TABLE quiz_question_options CASCADE;
TRUNCATE TABLE quiz_question CASCADE;
TRUNCATE TABLE questions CASCADE;
TRUNCATE TABLE quizzes CASCADE;

-- Truncate user-related tables
TRUNCATE TABLE password_reset_tokens CASCADE;
TRUNCATE TABLE sessions CASCADE;
TRUNCATE TABLE users CASCADE;

-- Truncate Laravel system tables
TRUNCATE TABLE cache CASCADE;
TRUNCATE TABLE cache_locks CASCADE;
TRUNCATE TABLE failed_jobs CASCADE;
TRUNCATE TABLE job_batches CASCADE;
TRUNCATE TABLE jobs CASCADE;

-- Note: We typically don't truncate the migrations table as it tracks which migrations have been run
-- TRUNCATE TABLE migrations CASCADE;

-- Optional: Reset sequences (PostgreSQL equivalent of AUTO_INCREMENT) to 1
-- ALTER SEQUENCE users_id_seq RESTART WITH 1;
-- ALTER SEQUENCE quizzes_id_seq RESTART WITH 1;
-- ALTER SEQUENCE questions_id_seq RESTART WITH 1;
-- ALTER SEQUENCE quiz_question_id_seq RESTART WITH 1;
-- ALTER SEQUENCE quiz_question_options_id_seq RESTART WITH 1;
-- ALTER SEQUENCE quiz_attempts_id_seq RESTART WITH 1;
-- ALTER SEQUENCE question_attempts_id_seq RESTART WITH 1;
-- ALTER SEQUENCE jobs_id_seq RESTART WITH 1;
-- ALTER SEQUENCE failed_jobs_id_seq RESTART WITH 1;