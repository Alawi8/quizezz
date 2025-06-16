<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class StudentTestController extends Controller
{

    public function index(Request $request)
    {
        $testId = $request->query('test_id');

        if (!$testId) {
            return response()->json(['message' => 'Missing test_id'], 400);
        }

        $questions = Question::with('answers')
            ->where('test_id', $testId)
            ->select('id', 'question_text', 'test_id')
            ->get();

        return response()->json(['data' => $questions]);
    }
}

