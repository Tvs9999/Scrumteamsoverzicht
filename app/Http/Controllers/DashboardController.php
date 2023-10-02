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

            $workshops = Workshop::where('user_id', Auth::user()->id)->get();
            $questions = Question::with('user.class')->where('status', 0)->get();

            return view('dashboard', compact('classesJson', 'scrumteamsJson', 'scrumteamUserJson', 'studentsJson', 'workshops', 'questions'));
        } 
        
        elseif (Auth::user()->role === 0){
            $workshops = Application::with(['workshop'])->where('user_id', Auth::user()->id)->get();
            $questions = Question::where('user_id', Auth::user()->id)->where('status', 0)->get();

            return view('dashboard', compact('workshops', 'questions'));
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
    }
    

    public function dashboardStudent()
    {
        $userRole = session('user_role'); // Retrieve 'user_role' from the session
        return view('dashboard-student', ['userRole' => $userRole]);
    }
    
}
