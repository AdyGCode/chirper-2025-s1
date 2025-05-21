<?php

namespace App\Livewire;

use App\Models\Chirp;
use App\Models\Vote;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LikeDislike extends Component
{
    public Chirp $chirp;
    public ?Vote $userVote = null;
    public int $lastUserVote = 0;
    public int $likes = 0;
    public int $dislikes = 0;

    public function mount(Chirp $chirp): void
    {
        $this->chirp = $chirp;
        $this->userVote = $chirp->userVotes;
        $this->lastUserVote = $this->userVote->vote ?? 0;
        $this->likes = $chirp->likesCount;
        $this->dislikes = $chirp->dislikesCount;
    }

    public function like()
    {
        $this->validateAccess();

        if ($this->hasVoted(1)) {
            // Update the vote (change value)
            $this->updateVote(0);

        } else {
            // update the vote (to 1)
            $this->updateVote(1);
        }
    }

    public function dislike()
    {
        $this->validateAccess();

        if ($this->hasVoted(-1)) {
            // Update the vote (change value)
            $this->updateVote(0);
        } else {
            // update the vote (to 1)
            $this->updateVote(-1);
        }
    }

    private function validateAccess(): bool
    {
        throw_if(
            auth()->guest(),
            ValidationException::withMessages([
                'unauthenticated' => 'You need to <a href="'
                    . route('login')
                    . '" class="underline">login</a> to click like/dislike'
            ])
        );
        return true;
    }


    public function render()
    {
        return view('livewire.like-dislike');
    }

    private function hasVoted(int $value): bool
    {
        return $this->userVote && $this->userVote->vote === $value;
    }

    private function updateVote(int $value): void
    {
        if ($this->userVote) {
            $this->chirp->votes()
                ->update(['user_id' => auth()->id(), 'vote' => $value]);
        } else {
            $this->userVote = $this->chirp->votes()
                ->create(['user_id' => auth()->id(), 'vote' => $value]);
        }

        $this->setLikesAndDislikesCount($value);

        $this->lastUserVote = $value;
    }

    private function setLikesAndDislikesCount(int $value): void
    {
        match (true) {
            $this->lastUserVote === 0 && $value === 1 => $this->likes++,
            $this->lastUserVote === 0 && $value === -1 => $this->dislikes++,
            $this->lastUserVote === 1 && $value === 0 => $this->likes--,
            $this->lastUserVote === -1 && $value === 0 => $this->dislikes--,

            $this->lastUserVote === 1 && $value === -1 => call_user_func(
                function () {
                    $this->dislikes++;
                    $this->likes--;
                }
            ),
            $this->lastUserVote === -1 && $value === 1 => call_user_func(
                function () {
                    $this->dislikes--;
                    $this->likes++;
                }
            ),


        };
    }
}
