<?php

namespace App\Services;

use App\Models\Chirp;
use App\Models\User;
use App\Notifications\ChirpBatchNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ChirpBatchService
{
    /**
     * The cache key for storing chirps in the batch.
     */
    protected const BATCH_CACHE_KEY = 'chirp_batch';

    /**
     * Add a chirp to the current batch.
     */
    public function addChirpToBatch(Chirp $chirp): void
    {
        $batch = $this->getCurrentBatch();
        $batch->push($chirp);

        Log::info('Added Chirp to batch', ['chirp_id' => $chirp->id, 'batch_size' => $batch->count()]);

        $this->storeBatch($batch);

        // If we've reached 10 chirps, send the notification
        if ($batch->count() >= 10) {
            $this->sendBatchNotification();
        }
    }

    /**
     * Get the current batch of chirps.
     */
    public function getCurrentBatch(): Collection
    {
        return Cache::get(self::BATCH_CACHE_KEY, collect());
    }

    /**
     * Store the batch of chirps.
     */
    protected function storeBatch(Collection $batch): void
    {
        Cache::put(self::BATCH_CACHE_KEY, $batch);
    }

    /**
     * Send notification for the current batch and reset.
     */
    public function sendBatchNotification(): void
    {
        $batch = $this->getCurrentBatch();

        if ($batch->isEmpty()) {
            Log::info('Batch is empty, no notifications sent');
            return;
        }

        // Get all users except those who created chirps in this batch
        $chirpAuthorIds = $batch->pluck('user_id')->unique()->toArray();
        $users = User::whereNotIn('id', $chirpAuthorIds)->get();

        // Send notification to each user
        foreach ($users as $user) {
            $user->notify(new ChirpBatchNotification($batch));
            Log::info('Sent batch notification', ['user_id' => $user->id, 'chirp_count' => $batch->count()]);
        }

        // Clear the batch
        $this->clearBatch();
    }

    /**
     * Clear the current batch.
     */
    public function clearBatch(): void
    {
        Cache::forget(self::BATCH_CACHE_KEY);
        Log::info('Batch cleared');
    }

    /**
     * Send any remaining chirps at the end of the day.
     */
    public function sendEndOfDayBatch(): void
    {
        Log::info('Sending end of day batch');
        $this->sendBatchNotification();
    }
}
