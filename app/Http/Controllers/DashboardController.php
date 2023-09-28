<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Question;
use App\Models\Scrumteam;
use App\Models\ScrumteamUser;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    public function index()
    {
        $classes = Classes::all()->toArray();
        $scrumteams = Scrumteam::all()->toArray();
        $scrumteamUser = ScrumteamUser::all()->toArray();
        $questions = Question::whereIn('status', [0])->get()->toArray();

        $scrumteamUserIds = ScrumteamUser::pluck('user_id')->toArray();
        $students = User::whereIn('id', $scrumteamUserIds)->get()->toArray();

        $classesJson = json_encode($classes);
        $scrumteamsJson = json_encode($scrumteams);
        $scrumteamUserJson = json_encode($scrumteamUser);
        $studentsJson = json_encode($students);

    
        
        return view('dashboard', compact('classesJson', 'scrumteamsJson', 'scrumteamUserJson', 'studentsJson'));
    }
    

    public function dashboardStudent()
    {
        $userRole = session('user_role'); // Retrieve 'user_role' from the session
        return view('dashboard-student', ['userRole' => $userRole]);
    }
    
}
