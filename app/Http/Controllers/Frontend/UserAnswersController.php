<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\UserAnswer;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class userAnswersController extends Controller
{
    public function submitAnswer(Request $request)
    {
        try {
            $validated = $request->validate([
                'question_id' => 'required|uuid|exists:questions,id',
                'answer_id'   => 'required|uuid|exists:answers,id',
            ]);

            $answer = Answer::where('id', $validated['answer_id'])
                ->where('question_id', $validated['question_id'])
                ->first();

            if (!$answer) {
                return response()->json([
                    'message' => 'Invalid answer for this question.'
                ], 422);
            }

            $userId = Auth::id();
            if (!$userId) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            UserAnswer::updateOrCreate(
                [
                    'user_id'     => $userId,
                    'question_id' => $validated['question_id'],
                ],
                [
                    'answer_id'   => $answer->id,
                    'is_correct'  => $answer->is_correct,
                ]
            );

            return response()->json([
                'message' => 'Answer saved successfully.',
                'correct' => $answer->is_correct,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Exception',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    public function getUserAnswers()
    {
        $userId = Auth::id();

        $answers = UserAnswer::where('user_id', $userId)
            ->select('question_id', 'answer_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->question_id => $item->answer_id];
            });

        return response()->json($answers);
    }


    public function clearAnswers(Request $request)
    {
        $userId = Auth::id();
        UserAnswer::where('user_id', $userId)->delete();
        return response()->json(['message' => 'Answers cleared']);
    }
}
