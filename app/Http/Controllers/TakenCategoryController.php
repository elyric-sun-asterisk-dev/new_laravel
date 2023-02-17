<?php

namespace App\Http\Controllers;
use App\Models\TakenCategory;
use Auth;


use Illuminate\Http\Request;

class TakenCategoryController extends Controller
{
    public function isTaken(Request $request)
    {
        return TakenCategory::where('user_id', Auth::id())->get();
    }
}
