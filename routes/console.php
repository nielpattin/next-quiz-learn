<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('migrate:refresh-seed', function () {
    $this->call('migrate:refresh', ['--seed' => true]);
})->purpose('Refresh the database and seed it with data');

Schedule::command('migrate:refresh-seed')->hourly();
