<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// For testing, run the chirp digest every five minutes
Schedule::command('app:send-daily-chirp-digest')
    ->everyFiveMinutes()
    ->appendOutputTo(storage_path('logs/scheduler.log'));

// In production, use this instead:
// Schedule::command('app:send-daily-chirp-digest')
//     ->dailyAt('23:50')
//     ->appendOutputTo(storage_path('logs/scheduler.log'));
