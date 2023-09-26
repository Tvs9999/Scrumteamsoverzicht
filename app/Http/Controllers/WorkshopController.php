<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    public function workshops()
    {
        $userId = Auth::user()->id;
        $workshops = $this->getWorkshops($userId);

        return view('workshops');
    }

    public function addWorkshop()
    {
        return view('addWorkshop');
    }

    public function getWorkshops($userId)
    {
        $workshops = Workshop::where('user_id' == $userId);

        if ($workshops > 0)
        {
            return $workshops;
        }

        return false;
    }

    public function createWorkshop()
    {

    }
}
