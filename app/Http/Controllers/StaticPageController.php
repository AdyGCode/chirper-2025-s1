<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('userVotes')
            ->withCount(['votes as likesCount' =>
                fn(Builder $query) => $query->where('vote', '>', 0)], 'vote')
            ->withCount(['votes as dislikesCount' =>
                fn(Builder $query) => $query->where('vote', '<', 0)], 'vote')
            ->latest()
            ->limit(3)
            ->get();

        return view('static.welcome')
            ->with('chirps', $chirps);
    }

    /**
     * Show the Dashboard
     */
    public function dashboard()
    {
        $chirpCount = Chirp::count();
        $userCount = User::count();
        $voteCount = Vote::count();
        return view('static.dashboard')
            ->with('chirpCount', $chirpCount)
            ->with('voteCount', $voteCount)
            ->with('userCount', $userCount);
    }

    /**
     * Show Contact page
     */
    public function contact()
    {
        //
    }

    /**
     * Show Privacy Policy
     */
    public function privacy()
    {
        //
    }

}
