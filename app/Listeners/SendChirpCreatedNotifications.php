<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Services\ChirpBatchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendChirpCreatedNotifications implements ShouldQueue
{

    protected ChirpBatchService $batchService;


    /**
     * Create the event listener.
     */
    public function __construct(ChirpBatchService $batchService)
    {
        $this->batchService = $batchService;
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
//        foreach (User::whereNot('id', $event->chirp->user_id)->cursor() as $user) {
//            $user->notify(new NewChirp($event->chirp));
//        }

        Log::info('SendChirpCreatedNotifications triggered', ['chirp_id' => $event->chirp->id]);

        $this->batchService->addChirpToBatch($event->chirp);
    }
}
