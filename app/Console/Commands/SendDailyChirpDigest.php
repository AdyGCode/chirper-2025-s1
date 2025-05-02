<?php

namespace App\Console\Commands;

use App\Services\ChirpBatchService;
use Illuminate\Console\Command;

class SendDailyChirpDigest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-chirp-digest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Chirp Digests';

    /**
     * Execute the console command.
     */
    public function handle(ChirpBatchService $batchService): int
    {
        $this->info('Sending daily Chirp digest...');
        $batchService->sendEndOfDayBatch();
        $this->info('Daily Chirp digest sent!');

        return Command::SUCCESS;
    }
}
