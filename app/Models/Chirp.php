<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chirp extends Model
{
    /** @use HasFactory<\Database\Factories\ChirpFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'message',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
        ];
    }


    /**
     * Events that will be triggered & dispatched
     */
    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];

    /**
     * A Chirp belongs to a User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votes() : HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function userVotes() : HasOne
    {
        return $this->votes() // look at the votes for this chirp
            ->one()           // retrieve ONE record
            ->where('user_id', auth()->id());
            // where the vote has the user_id of the currently logged-in user
            // returns either the vote value or null
    }

}
