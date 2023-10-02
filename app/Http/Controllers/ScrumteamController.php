<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scrumteam;
use App\Models\ScrumteamUser;
use App\Models\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScrumteamController extends Controller
{
    public function scrumteam()
    {
        $classes = DB::table('classes')->get(); // Classesdata wordt uit de database gehaald
        foreach ($classes as $class){
            $classid = $class->id;
            $classnames = $class->name;
            
            $user = DB::table('users')->where('class_id',$classid); // usersdata wordt uit de database gehaald    
        }
        $users = DB::table('users')->where('role','=','1')->get();
        $scrumteams = DB::table('scrumteams')->get();
        foreach($scrumteams as $scrumteam){
            $scrumteamid = $scrumteam->id;
        }

        return view('addScrumteam',compact('classes','users','user','scrumteamid'));
    }

    public function addScrumteam()
    {

    }

    public function addScrumteamPost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'class_id' => 'required',
        ]);
    
        $scrumteam = new Scrumteam();
        $scrumteam->name = $request->input('name');
        $scrumteam->class_id = $request->input('class_id');
        $scrumteam->status = 1;

        $selectedUserIds = $request->input('user_id', []);

        // Ensure $selectedUserIds is an array
        if (!is_array($selectedUserIds)) {
            $selectedUserIds = [$selectedUserIds];
        }

        if ($scrumteam->save()) {
            foreach ($selectedUserIds as $userId) {
                $scrumteamUser = new ScrumteamUser();
                $scrumteamUser->team_id = $request->input('team_id') + 1;
                $scrumteamUser->user_id = $userId;
                $scrumteamUser->save();
            }

            // Move the return statement outside of the loop
            return back()->with('success', 'Scrumteam toegevoegd');
        } else {
            dd($scrumteam->errors());
        }
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
