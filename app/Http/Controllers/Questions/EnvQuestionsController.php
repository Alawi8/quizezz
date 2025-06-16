<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Test;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\Auth;
class EnvQuestionsController extends Controller
{
    public function finalResult(Test $test)
    {
        $userId = Auth::id();
    
        $questions = $test->questions()->with('answers')->get();
        $answered = \App\Models\UserAnswer::where('user_id', $userId)
            ->whereIn('question_id', $questions->pluck('id'))
            ->get()
            ->keyBy('question_id');
    
        $correctCount = 0;
        $total = $questions->count();
    
        foreach ($questions as $question) {
            $correctAnswer = $question->answers->firstWhere('is_correct', true);
            $userAnswer = $answered[$question->id] ?? null;
    
            if ($userAnswer && $correctAnswer && $userAnswer->answer_id == $correctAnswer->id) {
                $correctCount++;
            }
        }
    
        $score = $total > 0 ? round(($correctCount / $total) * 100) : 0;
    
        return response()->json([
            'correct' => $correctCount,
            'total' => $total,
            'score' => $score
        ]);
    }
    

    public function questionsByTest(Test $test)
    {
        return response()->json([
            'data' => $test->questions()->with('answers')->get(),
        ]);
    }
    
}
