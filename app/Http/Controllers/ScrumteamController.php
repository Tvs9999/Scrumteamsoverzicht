<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scrumteam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScrumteamController extends Controller
{
    public function scrumteam()
    {
        return view('scrumteams');
    }

    public function addScrumteam(Request $request)
    {
        $classes = DB::table('classes')->get(); // Classesdata wordt uit de database gehaald
        $users = DB::table('users')->get(); // usersdata wordt uit de database gehaald 
        
        $name = $request->name;
        $class = $request->klas;
        $students = $request->students;
        

        return view('addScrumteam',compact('classes','users'));
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
