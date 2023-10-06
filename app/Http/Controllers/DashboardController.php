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
        if(!isset(Auth::user()->role))
        {
            return redirect('login');
        }
        if (Auth::user()->role === 1){
            $classes = Classes::whereHas('scrumteams', function ($query) {
                $query->where('status', 0);
            })
            ->with('scrumteams.users.user')
            ->get();

            $classesJson = $classes->toJson();

            $workshops = Workshop::with(['applications'])->where('user_id', Auth::user()->id)->get();
            $questions = Question::with('user.class')->where('status', 0)->get();

            return view('dashboard', compact('classesJson', 'workshops', 'questions'));
        } 
        
        elseif (Auth::user()->role === 0){
            $workshops = Application::with(['workshop.user'])->where('user_id', Auth::user()->id)->get();
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
        // Populate and save the workshop data
    
        if (isset($request->question)){
            if (strlen($request->question) >= 255){
                return back()->with('error', 'Maximaal 255 karakters');
            }

            $question = new Question();
         
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
        } else {
            return back()->with('error', 'Vul een vraag in');
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
}
