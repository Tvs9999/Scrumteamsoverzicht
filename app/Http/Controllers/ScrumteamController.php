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

        $classes = Classes::whereHas('scrumteams', function ($query) {
            $query->where('status', 0);
        })
        ->with('scrumteams.users.user')
        ->get();

        $classesJson = json_encode($classes);

        return view('scrumgroepen', compact('classesJson'));
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
        //Alle klasnames in een selectoptie
        $classes = DB::table('classes')->get(); // Classesdata wordt uit de database gehaald
        foreach ($classes as $class){
            $classesid = $class->id;
            $classesnames = $class->name;
            $user = DB::table('users')->where('class_id',$classesid); // usersdata wordt uit de database gehaald   
        }

        //studentgegevens van de usertable
        $users = DB::table('users')->where('role','=','0')->get();
        foreach($users as $user)
        {
            $classid = $user->class_id;
            $class = DB::table('classes')->where('id','=',$classid)->get(); // Classesdata wordt uit de database gehaald
            foreach ($class as $classnames)
                $classnames = $classnames->name;

            }

        $scrumteams = DB::table('scrumteams')->get();
        if(count($scrumteams) > 0)
        foreach($scrumteams as $scrumteam){
            $scrumteamid = $scrumteam->id;
        }else{
            $scrumteamid = -1;
        }

        return view('addScrumteam',compact('classes','classnames','users','user','scrumteams','scrumteamid'));
    }

    public function fetchStudents($classId) {
        // Fetch students based on the $classId
        $students = DB::table('users')
            ->where('role', '=', '0')
            ->where('class_id', '=', $classId)
            ->get();
    
        // Fetch students who are in a scrum team
        $studentsInScrumTeam = DB::table('scrumteam_user')->pluck('user_id')->toArray();
    
        // Generate HTML for the students with a disabled checkbox for those in a scrum team
        $html = '';

        if (count($students) === 0) {
            return 'Er zit nog niemand in deze klas';
        }

        foreach ($students as $student) {
            $isInScrumTeam = in_array($student->id, $studentsInScrumTeam);
            $disabledAttribute = $isInScrumTeam ? 'disabled' : '';
            
            $html .= '<input required type="checkbox" value="'.$student->id.'" name="user_id[]" '.$disabledAttribute.'>'.$student->firstname.' '.$student->lastname.'<br>';
        }
    
        return $html;
    }    


    public function addScrumteam()
    {
    }

    public function addScrumteamPost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'class_id' => 'required|int',
            'user_id' => 'required|array|min:1',
        ], [
            'name.required' => 'Het teamnaam is verplicht',
            'class_id.required' => 'Het klas moet geselecteerd worden',
            'user_id.required' => 'De studenten moeten geselecteerd worden',
            'user_id.min' => 'De studenten moeten geselecteerd worden', // Custom message for minimum validation
            '*' => 'Deze velden moeten ingevuld worden',
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
                $scrumteam = DB::table('scrumteams')->get();
                $lastTeamId = DB::table('scrumteams')->latest('id')->value('id');
                
                $scrumteamUser->scrumteam_id = $lastTeamId;
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
