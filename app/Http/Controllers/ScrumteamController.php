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

        $activeClasses = Classes::whereHas('scrumteams', function ($query) {
            $query->where('status', 0);
        })
        ->with('scrumteams.users.user')
        ->get();

        $archivedClasses = Classes::whereHas('scrumteams', function ($query) {
            $query->where('status', 1);
        })
        ->with('scrumteams.users.user')
        ->get();

        $activeClassesJson = json_encode($activeClasses);

        
        $archivedClassesJson = json_encode($archivedClasses);

        return view('scrumgroepen', compact('activeClassesJson', 'archivedClassesJson'));
    }

    public function archiveScrumteam($id)
    {
        // Find the scrum team by ID
        $scrumteam = Scrumteam::find($id);

        if($scrumteam){
            // Archive the scrum team
            $scrumteam->status = 1;
            if($scrumteam->save()){
                // Redirect back to the scrum teams page with a success message
                return redirect()->route('scrumteams')->with('success', 'Scrumteam gearchiveerd.');
            }
    
            return back()->with('error', 'Scrumteam archiveren mislukt');
        } else {
            return back()->with('error', 'Scrumteam niet gevonden');
        }

        

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
        $users = DB::table('users')->where('role','=','0')->where('password','!=','Null')->get();
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
        // Haal alle studenten uit de user die geselecteerd zijn door de gebruiker, op basis van 
        // dat het wachtwoord niet null is (al geactiveerd) 
        $students = User::where('role', '=', '0')
            ->where('password', '!=', 'Null')
            ->where('class_id', '=', $classId)
            ->get();
    
        // studenten met of zonder actief scrumteam in array
        $studentsWithoutScrumTeam = [];
        $studentsWithScrumTeam = [];
    
        foreach ($students as $student) {
            $inScrumTeam = ScrumteamUser::where('user_id', $student->id)
                ->whereHas('scrumteam', function ($query) {
                    $query->where('status', 0);
                })
                ->count() > 0;
    
            if ($inScrumTeam) {
                // Voeg studenten met actief scrumteam in array
                $studentsWithScrumTeam[] = $student;
            } else {
                // Voeg studenten zonder actief scrumteam toe in array
                $studentsWithoutScrumTeam[] = $student;
            }
        }
    
        $html = '';
    
        // Als er geen studenten in die klas zitten
        if (empty($studentsWithoutScrumTeam) && empty($studentsWithScrumTeam)) {
            $html .= 'Er zit nog niemand in deze klas';
        } else {
            //  studenten zonder actief scrumteam
            foreach ($studentsWithoutScrumTeam as $student) {
                $html .= '<div>';
                $html .= '<input type="checkbox" value="' . $student->id . '" name="user_id[]">' . $student->firstname . ' ' . $student->lastname;
                $html .= '</div>';
            }
    
            // Daarna studenten met actief scrumteam
            foreach ($studentsWithScrumTeam as $student) {
                $html .= '<div class="clock">' . $student->firstname . ' ' . $student->lastname . ' <i class="fa-solid fa-lock"></i></div>';
            }
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
            'user_id.required' => 'De studenten moeten nog geselecteerd worden',
            'user_id.min' => 'Minimaal een student moet geselecteerd worden',
            '*' => 'Deze velden moeten ingevuld worden',
        ]);

        $scrumteam = new Scrumteam();
        $scrumteam->name = $request->input('name');
        $scrumteam->class_id = $request->input('class_id');
        $scrumteam->status = 0;

        $selectedUserIds = $request->input('user_id', []);

        // Check of de geselecteerde userid bestaat in user
        $bestaatUserIds = User::whereIn('id', $selectedUserIds)->pluck('id')->toArray();
        
        // Check of alle geselecteerde userids bestaan in user
        if (count($selectedUserIds) !== count($bestaatUserIds)) {
            $nietbestaatUserIds = array_diff($selectedUserIds, $bestaatUserIds);
            $nietbestaatUsername = User::whereIn('id', $nietbestaatUserIds)->pluck('firstname')->implode(', ');
            return back()->withErrors(['user_id' => "Deze student(en) bestaat/bestaan niet."]);
        }

        // verder met opslaan scrumteam en scrumteamuser
        if ($scrumteam->save()) {
            foreach ($selectedUserIds as $userId) {
                $scrumteamUser = new ScrumteamUser();
                $scrumteamUser->scrumteam_id = $scrumteam->id;
                $scrumteamUser->user_id = $userId;
                $scrumteamUser->save();
            }

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
