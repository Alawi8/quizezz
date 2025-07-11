<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        return response()->json(Test::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1'
        ]);

        $test = Test::create($request->all());

        return response()->json($test, 201);
    }

    public function show($id)
    {
        return response()->json(Test::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        $test->update($request->all());

        return response()->json($test);
    }

    public function destroy($id)
    {
        Test::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الاختبار بنجاح']);
    }

    public function getQuestionsWithUserAnswers($test_id)
    {
        try {
            $userId = auth()->id();
            $questions = Question::with(['answers'])->where('test_id', $test_id)->get();

            $userAnswers = \App\Models\UserAnswer::where('user_id', $userId)
                ->whereIn('question_id', $questions->pluck('id'))
                ->pluck('answer_id', 'question_id');

            foreach ($questions as $question) {
                foreach ($question->answers as $answer) {
                    $answer->selected = isset($userAnswers[$question->id]) &&
                        $userAnswers[$question->id] == $answer->id;
                }
            }

            return response()->json(['data' => $questions]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to load questions with user answers',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}

