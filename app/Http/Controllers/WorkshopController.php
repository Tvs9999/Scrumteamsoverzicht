<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    public function workshops()
    {
        $workshops = [];
        
        if (empty(Auth::user())){
            return redirect()->route('login');
        }
        
        if (Auth::user()->role == 1){
            $userId = Auth::user()->id;
            $workshops = $this->getWorkshops($userId);
        } 
        elseif (Auth::user()->role == 0) {
            $workshops = $this->getWorkshopsByClass(Auth::user()->class_id);
        }

        return view('workshops', compact('workshops'));
    }

    public function addWorkshop()
    {
        return view('addWorkshop');
    }

    public function getWorkshops($userId)
    {
        $workshops = Workshop::where("user_id", $userId)->get();

        if (!empty($workshops))
        {
            return $workshops;
        }

        return false;
    }

    public function getWorkshopsByClass($classId)
    {
        $workshops = Workshop::where('class_id', $classId);

        if (!empty($workshops))
        {
            return $workshops;
        }

        return false;
    }

    public function createWorkshop()
    {

    }
}
