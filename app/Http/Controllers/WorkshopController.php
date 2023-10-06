<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;
use App\Models\Classes;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class WorkshopController extends Controller
{
    public function workshops()
    {
        // Check if the user is authenticated
        if (empty(Auth::user())) {
            return redirect()->route('login');
        }

        // Define the user's role and related query
        $role = Auth::user()->role;
        $classId = Auth::user()->class_id;
        $query = Workshop::query();

        if ($role == 1) {
            $userId = Auth::user()->id;
            // Filter workshops for a teacher
            $query->where('user_id', $userId)->with('applications');
        } elseif ($role == 0) {
            // Filter workshops for a student based on their class
            $query->where('class_id', $classId)->with('applications');
        }

        // Get the workshops
        $workshops = $query->get();

        return view('workshops', compact('workshops'));
    }

    public function showApplications($workshopId)
    {
        $workshop = Workshop::find($workshopId);

        if (!$workshop) {
            return response()->json(['error' => 'Workshop not found'], 404);
        }

        $workshopName = $workshop->name;

        $applications = $workshop->applications->load('user.class');

        $formattedApplications = $applications->map(function ($application) use ($workshop) {
            return [
                'first_name' => $application->user->firstname,
                'last_name' => $application->user->lastname,
                'class_name' => $application->user->class->name,
            ];
        });

        $response = [
            'workshop_name' => $workshopName,
            'applications' => $formattedApplications,
        ];

        return response()->json($response);
    }

    public function addWorkshop()
    {
        $classNumbers = Classes::select('id', 'name')->get();

        return view('addWorkshop', compact('classNumbers'));
    }

    public function addWorkshopPost(Request $request)
    {
        $request->validate([
            'class' => 'required|numeric|exists:classes,id',
            'name' => 'required|max:255',
            'datetime' => 'required|date_format:Y-m-d\TH:i|after_or_equal:now',
            'duration' => 'required|max:255',
            'minPers' => 'required|numeric|min:1',
            'maxPers' => 'required|numeric|gt:minPers|min:1',
            'location' => 'required|max:255',
        ], [
            'datetime.date_format' => 'Onjuist format',
            'datetime.after_or_equal' => 'Vul een datum in de toekomst in',
            'minPers.min' => 'maxVul 1 of hoger in',
            'minPers.min' => 'Vul 1 of hoger in',
            'class.exists' => 'Deze klas bestaat niet',
            'maxPers.gt' => 'Max. aanmeldingen moet meer zijn dan Min. aanmeldingen',
            'name.max' => 'Maximaal 255 karakters',
            'duration.max' => 'Maximaal 255 karakters',
            'location.max' => 'Maximaal 255 karakters',
            '*' => 'Dit veld is verplicht in te vullen.'
        ]);



        // Attempt to save the workshopA
        $workshop = new Workshop();
        $formattedDateTime = date('Y-m-d H:i:s', strtotime($request->datetime));

        // Populate and save the workshop data

        $workshop->class_id = $request->class;
        $workshop->user_id = Auth::user()->id;
        $workshop->name = $request->name;
        $workshop->description = $request->description;
        $workshop->date = $formattedDateTime;
        $workshop->duration = $request->duration;
        $workshop->min_pers = $request->minPers;
        $workshop->max_pers = $request->maxPers;
        $workshop->location = $request->location;

        if ($workshop->save()) {
            // Workshop saved successfully
            return back()->with('success', 'Workshop toegevoegd');
        } else {
            // Workshop save failed, log or dump errors
            dd($workshop->errors());
        }
    }

    public function getWorkshops($userId)
    {
        $workshops = Workshop::where("user_id", $userId)->get();

        if (!empty($workshops)) {
            return $workshops;
        }

        return false;
    }

    public function getWorkshopsByClass($classId)
    {
        $workshops = Workshop::where('class_id', $classId)->get();

        if (!empty($workshops)) {
            return $workshops;
        }

        return false;
    }

    public function getApplications($workshopId)
    {
        $applications = Application::where('workshop_id', $workshopId)->get();

        if (!empty($applications)) {
            return $applications;
        }

        return false;
    }

    public function signUp(Request $request)
    {
        // Attempt to save the workshop
        $application = new Application();
        // Populate and save the workshop data

        $application->workshop_id = $request->workshopId;
        $application->user_id = $request->userId;

        $workshop = Workshop::find($request->workshopId);

        if (!$workshop) {
            // Workshop with the given ID does not exist
            return back()->with('error', 'Workshop niet gevonden.');
        }

        if ($workshop->class_id != Auth::user()->class_id){
            return back()->with('error', 'Workshop is niet voor jouw klas.');
        }

        $currentApplicants = Application::where('workshop_id', $request->workshopId)->count();
        $ApplicantsLimit = Workshop::where('id', $request->workshopId)->first()->max_pers;


        if ($currentApplicants < $ApplicantsLimit) {
            if ($application->save()) {
                // Workshop saved successfully
                return back()->with('success', 'Succesvol aangemeld' . $ApplicantsLimit);
            } else {
                // Workshop save failed, log or dump errors
                dd($application->errors());
            }
        } else {
            return back()->with('error', 'Workshop zit vol, helaas.');
        }
    }
}
