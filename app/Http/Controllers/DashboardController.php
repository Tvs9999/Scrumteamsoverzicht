<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Question;
use App\Models\Scrumteam;
use App\Models\ScrumteamUser;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $classes = Classes::all(); //table with all classnames in it
        $scrumteams = Scrumteam::all(); //table that holds the name of the scrumteam and the klas_id foreign key to know what class it belongs to
        $scrumteamUser = ScrumteamUser::all(); //table that linkes a user to a scrumteam 
        $questions = Question::whereIn('status', [0])->get();

        $scrumteamUserIds = ScrumteamUser::pluck('user_id')->toArray(); // Get an array of user_ids

        $students = User::whereIn('id', $scrumteamUserIds)->get();


        return view('dashboard', compact('classes', 'scrumteams', 'scrumteamUser', 'students', 'questions'));
    }
}
