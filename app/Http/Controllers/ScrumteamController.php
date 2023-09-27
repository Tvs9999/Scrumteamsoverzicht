<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scrumteam;
use Illuminate\Support\Facades\Auth;

class ScrumteamController extends Controller
{
    public function scrumteam()
    {
        return view('scrumteams');
    }

    public function addScrumteam()
    {
        return view('addScrumteam');
    }

    public function getScrumteams($userId)
    {
        $scrumteams = scrumteam::where('user_id' == $userId);

        if ($scrumteams > 0)
        {
            return $scrumteams;
        }

        return false;
    }

    public function createScrumteam()
    {

    }
}
