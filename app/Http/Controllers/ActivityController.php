<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Auth;

class ActivityController extends Controller
{
    public function show()
    {
        return Activity::where('user_id', Auth::id())->get();
    }
}
