<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scrumteam;
use App\Models\User;
use App\Models\ScrumteamUser;
use App\Models\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScrumteamController extends Controller
{
    public function index(Request $request)
    {
        $includeArchived = false;

        // Check if the "archive" button is pressed
        if ($request->has('archive_button')) {
            // Include archived scrum teams
            $includeArchived = true;
        }

        $scrumteamsQuery = $includeArchived ? Scrumteam::where('status', 1)->get() : Scrumteam::where('status', 0)->get();
        $scrumteams = $scrumteamsQuery->toArray();

        $classedWithTeams = Scrumteam::pluck('class_id'); 
        $classes = Classes::whereIn('id', $classedWithTeams)->get()->toArray();        
        $scrumteamUser = ScrumteamUser::all()->toArray();
        $scrumteamUserIds = ScrumteamUser::pluck('user_id')->toArray();
        $students = User::whereIn('id', $scrumteamUserIds)->get()->toArray();

        $classesJson = json_encode($classes);
        $scrumteamsJson = json_encode($scrumteams);
        $scrumteamUserJson = json_encode($scrumteamUser);
        $studentsJson = json_encode($students);

        return view('scrumgroepen', compact('classesJson', 'scrumteamsJson', 'scrumteamUserJson', 'studentsJson'));
    }

    public function archiveScrumteam($id)
    {
        // Find the scrum team by ID
        $scrumteam = Scrumteam::findOrFail($id);

        // Archive the scrum team
        $scrumteam->status = 1;
        $scrumteam->save();

        // Redirect back to the scrum teams page with a success message
        return redirect()->route('scrumteams')->with('status', 'Scrum team archived successfully.');
    }

    public function scrumteam()
    {
        $classes = DB::table('classes')->get(); // Classesdata wordt uit de database gehaald
        foreach ($classes as $class) {
            $classid = $class->id;
            $classnames = $class->name;

            $user = DB::table('users')->where('class_id', $classid); // usersdata wordt uit de database gehaald    
        }
        $users = DB::table('users')->where('role', '=', '1')->get();
        $scrumteams = DB::table('scrumteams')->get();
        foreach ($scrumteams as $scrumteam) {
            $scrumteamid = $scrumteam->id;
        }

        return view('addScrumteam', compact('classes', 'users', 'user', 'scrumteamid'));
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
                $scrumteamUser->scrumteam_id = $request->input('scrumteam_id') + 1;
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

        if ($scrumteams > 0) {
            return $scrumteams;
        }

        return false;
    }

    public function createScrumteam()
    {
    }
}
