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
     * Cache duration in minutes.
     */
    protected const CACHE_DURATION = 120; // 2 hours

    /**
     * Add a chirp to the current batch.
     */
    public function addChirpToBatch(Chirp $chirp): void
    {
        // Get current IDs from cache
        $chirpIds = Cache::get(self::BATCH_CACHE_KEY, []);

        // Add the new ID if not already present
        if (!in_array($chirp->id, $chirpIds)) {
            $chirpIds[] = $chirp->id;
        }

        // Store updated IDs
        Cache::put(self::BATCH_CACHE_KEY, $chirpIds, self::CACHE_DURATION);

        Log::info('Added Chirp to batch', [
            'chirp_id' => $chirp->id,
            'batch_size' => count($chirpIds),
            'message' => $chirp->message,
            'all_ids' => $chirpIds
        ]);

        // If we've reached 3 chirps, send the notification
        if (count($chirpIds) >= 3) {
            Log::info('Batch threshold reached, sending notification', ['batch_size' => count($chirpIds)]);
            $this->sendBatchNotification();
        }
    }

    /**
     * Get the current batch of chirps.
     */
    public function getCurrentBatch(): Collection
    {
        $chirpIds = Cache::get(self::BATCH_CACHE_KEY, []);
        Log::debug('Retrieved chirp IDs from cache', ['ids' => $chirpIds]);

        // If we have IDs, load the fresh Chirp models
        if (!empty($chirpIds)) {
            $batch = Chirp::with('user')->whereIn('id', $chirpIds)->get();
            Log::debug('Loaded Chirp models from database', ['batch_size' => $batch->count()]);
            return $batch;
        }

        return collect();
    }

    /**
     * Store the batch of chirps.
     */
    protected function storeBatch(Collection $batch): void
    {
        Log::debug('Storing batch in cache', ['batch_size' => $batch->count()]);

        // Store IDs instead of full objects to avoid serialization issues
        $chirpIds = $batch->pluck('id')->toArray();
        Log::debug('Storing chirp IDs', ['ids' => $chirpIds]);

        Cache::put(self::BATCH_CACHE_KEY, $chirpIds, self::CACHE_DURATION);
    }

    /**
     * Send notification for the current batch and reset.
     */
    public function sendBatchNotification(): void
    {
        $batch = $this->getCurrentBatch();
        Log::info('Attempting to send batch notification', ['batch_size' => $batch->count()]);

        if ($batch->isEmpty()) {
            Log::info('Batch is empty, no notifications sent');
            return;
        }

        // Get all users except those who created chirps in this batch
        $chirpAuthorIds = $batch->pluck('user_id')->unique()->toArray();
        $users = User::whereNotIn('id', $chirpAuthorIds)->get();

        Log::info('Sending batch notifications', [
            'recipient_count' => $users->count(),
            'chirp_count' => $batch->count(),
            'author_ids' => $chirpAuthorIds
        ]);

        // Send notification to each user
        foreach ($users as $user) {
            $user->notify(new ChirpBatchNotification($batch));
            Log::info('Sent batch notification', ['user_id' => $user->id, 'user_name' => $user->name]);
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
