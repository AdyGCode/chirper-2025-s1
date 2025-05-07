<?php

namespace App\Console\Commands;

use App\Models\Chirp;
use App\Services\ChirpBatchService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TestChirpCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-chirp-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the chirp batch caching system';

    /**
     * Execute the console command.
     */
    public function handle(ChirpBatchService $batchService): int
    {
        $this->info('Testing chirp batch cache system...');

        // Clear the batch to start fresh
        $batchService->clearBatch();
        $this->info('Batch cleared');

        // Get a sample chirp
        $chirp = Chirp::with('user')->first();

        if (!$chirp) {
            $this->error('No chirps found in the database!');
            return Command::FAILURE;
        }

        $this->info("Using chirp ID: {$chirp->id} from user: {$chirp->user->name}");

        // Manually add to batch
        $batchService->addChirpToBatch($chirp);
        $this->info('Chirp added to batch');

        // Check cache directly
        $cacheKey = 'chirp_batch'; // Make sure this matches the const in ChirpBatchService
        $rawCacheData = Cache::get($cacheKey);
        $this->info("Raw cache data: " . json_encode($rawCacheData));

        // Check batch size
        $batchSize = $batchService->getCurrentBatch()->count();
        $this->info("Batch size after adding: {$batchSize}");

        if ($batchSize === 0) {
            $this->error('ERROR: Chirp was not properly stored in the cache!');

            // Test basic cache functionality
            $this->info('Testing basic cache functionality...');
            $testKey = 'test_cache_key';
            $testValue = 'test_value_' . time();

            Cache::put($testKey, $testValue, 60);
            $retrievedValue = Cache::get($testKey);

            $this->info("Stored: {$testValue}");
            $this->info("Retrieved: {$retrievedValue}");

            if ($testValue === $retrievedValue) {
                $this->info('Basic cache test PASSED');
            } else {
                $this->error('Basic cache test FAILED - Cache is not working properly!');
            }
        } else {
            $this->info('SUCCESS: Chirp was properly stored in the cache!');
        }

        // Add more complex objects
        $this->info('Now testing with multiple chirps...');
        $batchService->clearBatch();

        $chirps = Chirp::with('user')->take(3)->get();

        foreach ($chirps as $index => $chirp) {
            $i = $index + 1;
            $this->info("Adding chirp {$i} (ID: {$chirp->id}) to batch");
            $batchService->addChirpToBatch($chirp);

            // Check cache directly after each addition
            $currentCacheData = Cache::get($cacheKey);
            $i = $index + 1;
            $this->info("Cache data after adding chirp {$i}: " . json_encode($currentCacheData));

            // Check the returned batch size
            $currentBatchSize = $batchService->getCurrentBatch()->count();
            $i = $index + 1;
            $this->info("Batch size returned after adding chirp {$i}: {$currentBatchSize}");
        }

        // Final check
        $finalRawCache = Cache::get($cacheKey);
        $this->info("Final raw cache data: " . json_encode($finalRawCache));

        $newBatchSize = $batchService->getCurrentBatch()->count();
        $this->info("Final batch size: {$newBatchSize}");

        return Command::SUCCESS;
    }
}
