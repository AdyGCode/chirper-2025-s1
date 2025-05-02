<?php

namespace App\Console\Commands;

use App\Services\ChirpBatchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        Log::info('Daily digest command started');

        $batchSize = $batchService->getCurrentBatch()->count();
        $this->info("Current batch has {$batchSize} chirps");
        Log::info('Current batch size', ['count' => $batchSize]);

        $batchService->sendEndOfDayBatch();

        $this->info('Daily Chirp digest sent!');
        Log::info('Daily digest command completed');

        return Command::SUCCESS;
    }
}
