<?php

namespace App\Console\Commands;

use App\Services\ChirpBatchService;
use Illuminate\Console\Command;

class TestChirpBatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-chirp-batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the chirp batch notification system';

    /**
     * Execute the console command.
     */
    public function handle(ChirpBatchService $batchService): int
    {
        $this->info('Testing chirp batch notification');

        // Force send whatever batch exists, even if it's not 10 chirps
        $batchService->sendBatchNotification();

        $this->info('Test complete!');

        return Command::SUCCESS;
    }
}
