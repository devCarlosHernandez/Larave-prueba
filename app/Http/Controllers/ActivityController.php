<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
{
    // Obtener todos los artículos
    $activity = Activity::paginate(50); 
    return view('activity-log.index', compact('activity')); 
}


    public function show(Activity $activity) 
    {
        return view('activity-log.show', compact('activity'));
    }
}