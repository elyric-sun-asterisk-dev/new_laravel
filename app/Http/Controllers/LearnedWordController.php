<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\LearnedWord;


use Illuminate\Http\Request;

class LearnedWordController extends Controller
{
    public function show()
    {
        $learnedWords = LearnedWord::where('user_id', Auth::id())->get();
    
        return response()->json($learnedWords);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'learned_from' => 'required',
            'learned_word' => 'required',
            'learned_answer' => 'required',
        ]);
    
        $learned_words = $validatedData['learned_word'];
        $learned_answers = $validatedData['learned_answer'];
    
        foreach($learned_words as $index => $word) {
            LearnedWord::create([
                'learned_from' => $validatedData['learned_from'],
                'learned_word' => $word,
                'learned_answer' => $learned_answers[$index],
                'user_id' => Auth::id()
            ]);
        }
    
        return response()->json(['message' => 'Learned word stored successfully.']);
    }
    
}
