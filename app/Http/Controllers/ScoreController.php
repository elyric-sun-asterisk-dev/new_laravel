<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\TakenCategory;
use App\Models\Activity;
use Auth;

class ScoreController extends Controller
{
    public function calculateScore(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $answers = $request->input('answers');
        $correctAnswers = $request->input('correctAnswers');
        $answersQuestion = $request->input('answersQuestion');

        $isCorrect = [];
        $correctAnswerQuestionsOnly = [];
        $correctAnswersOnly = [];

        $score = 0;
        $totalQuestion = count($answers);
        $passingScore = 75;
        
        for ($i = 0; $i < count($answers); $i++) {
            if ($answers[$i] == $correctAnswers[$i]) {
                $score++;
                array_push($isCorrect, true);
                array_push($correctAnswerQuestionsOnly, $answersQuestion[$i]);
                array_push($correctAnswersOnly, $answers[$i]);
            } else {
                array_push($isCorrect, false);
            }
        }
        $result = $totalQuestion > 0?round(($score / $totalQuestion) * 100, 2):0;
        $isPassed = $result > $passingScore ? true : false;

        if($answers > 0){
            
            TakenCategory::create([
                "user_id" => Auth::id(),
                "category_id" => $categoryId,
                "taken" => 1,
                "score" => $score,
                "total" => $totalQuestion
            ]);

            $category = Category::find($categoryId);
            $title = $category->title;
            
            Activity::create([
                "user_id" => Auth::id(),
                "description" => "You learned {$score} of {$totalQuestion} in {$title}",
                "activitiable_id" => $categoryId,
                "activitiable_type" => "App\Models\Category"
            ]);
        }
        
        return $totalQuestion > 0
            ? response()->json([
                'result' => $result,
                'score' => $score,
                'isCorrect' => $isCorrect,
                'correctAnswersOnly' => $correctAnswersOnly,
                'correctAnswerQuestionsOnly' => $correctAnswerQuestionsOnly,
                'passed' => $isPassed])
            : response()->json(['error' => 'Cannot perform calculation with 0 total questions']);
    }
    
}
