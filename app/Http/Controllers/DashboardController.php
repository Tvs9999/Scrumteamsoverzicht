<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Question;
use App\Models\Scrumteam;
use App\Models\ScrumteamUser;
use App\Models\Application;

use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 1){
            // $scrumteams = Scrumteam::where('status', 0)->get();
            // $classedWithTeams = $scrumteams->pluck('class_id'); 
            // $classes = Classes::whereIn('id', $classedWithTeams)->get()->toArray();
            // $scrumteamUser = ScrumteamUser::all()->toArray();
    
            // $scrumteamUserIds = ScrumteamUser::pluck('user_id')->toArray();
            // $students = User::whereIn('id', $scrumteamUserIds)->get()->toArray();
    
            // $classesJson = json_encode($classes);
            // $scrumteamsJson = json_encode($scrumteams);
            // $scrumteamUserJson = json_encode($scrumteamUser);
            // $studentsJson = json_encode($students);

            // $scrumteams = Scrumteam::where('status', 0)->get();
            // $classIds = $scrumteams->pluck('class_id')->toArray();

            // Get classes that have scrum teams
            // $classes = Classes::whereIn('id', $classIds)->get();

            // Get all scrum team users
            // $scrumteamUser = ScrumteamUser::with('user')->get();

            // Get user IDs of all scrum team users
            // $scrumteamUserIds = $scrumteamUser->pluck('user_id')->toArray();

            // Get student users
            // $students = User::whereIn('id', $scrumteamUserIds)->get();

            $classes = Classes::whereHas('scrumteams', function ($query) {
                $query->where('status', 0);
            })
            ->with('scrumteams.users.user')
            ->get();

            // echo '<pre>';
            // print_r($classes);
            // echo '</pre>';
            // die;
            $classesJson = $classes->toJson();
            // $scrumteamsJson = $scrumteams->toJson();
            // $scrumteamUserJson = $scrumteamUser->toJson();
            // $studentsJson = $students->toJson();

            $workshops = Workshop::where('user_id', Auth::user()->id)->get();
            $questions = Question::with('user.class')->where('status', 0)->get();

            return view('dashboard', compact('classesJson', 'workshops', 'questions'));
        } 
        
        elseif (Auth::user()->role === 0){
            $workshops = Application::with(['workshop'])->where('user_id', Auth::user()->id)->get();
            $questions = Question::where('user_id', Auth::user()->id)->where('status', 0)->get();

            $scrumteam = ScrumteamUser::where('user_id', Auth::user()->id)
            ->whereHas('scrumteam', function ($query) {
                // Apply conditions to the 'scrumteam' relationship
                $query->where('status', '0');
            })
            ->with('scrumteam.users.user')
            ->first();

            return view('dashboard', compact('workshops', 'questions', 'scrumteam'));
        }
    }

    public function askQuestion(Request $request)
    {
        // Attempt to save the workshop
        $question = new Question();
        // Populate and save the workshop data
    
        $question->user_id = Auth::user()->id;
        $question->question = $request->question;
        $question->status = 0;

        if ($question->save()) {
            // Workshop saved successfully
            return back()->with('success', 'Vraag gesteld');
        } else {
            // Workshop save failed, log or dump errors
            return back()->with('error', 'Vraag stellen mislukt');
        }
    }

    public function completeQuestion(Request $request)
    {
        $question = Question::find($request->questionId);

        if ($question) {
            if($question->update(['status' => 1])){
                return back()->with('success', 'Vraag succesvol afgerond');
            } else {
                return back()->with('error', 'Vraag afronden mislukt');
            }
        } else {
            return back()->with('error', 'Vraag niet gevonden');
        }

        if (Auth::user()->role === 1) {


            return view('dashboard', compact('classesJson', 'scrumteamsJson', 'scrumteamUserJson', 'studentsJson'));
        } else {
            $scrumteamUser = ScrumteamUser::where('user_id', Auth::user()->id)->first();

            if ($scrumteamUser) {
                $scrumteamId = $scrumteamUser->scrumteam_id;
                $scrumteamMembers = ScrumteamUser::where('scrumteam_id', $scrumteamId)
                    ->pluck('user_id') 
                    ->toArray();
            
                $scrumteamMembers = User::whereIn('id', $scrumteamMembers)->get(); 
            } else {
                $scrumteamMembers = []; // You can set this to an empty array or handle it as needed.
            }
            
            return view('dashboard', compact('scrumteamMembers'));
        }
    }


    public function dashboardStudent()
    {
        $userRole = session('user_role'); // Retrieve 'user_role' from the session
        return view('dashboard-student', ['userRole' => $userRole]);
    }
}
