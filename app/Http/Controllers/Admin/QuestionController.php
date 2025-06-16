<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    // ✅ Get all questions (with test + answers)
    public function index(Request $request)
    {
        $query = Question::with(['test', 'answers'])->latest();

        if ($request->filled('test_id')) {
            $query->where('test_id', $request->test_id);
        }

        $paginated = $query->paginate(10);

        return response()->json($paginated);
    }





    // ✅ Store a new question



    public function store(Request $request)
    {
        $data = $request->validate([
            'question_text' => 'required|string|max:1000',
            'test_id' => 'required|exists:tests,id',
            'answers' => 'required|array|min:2',
            'answers.*.answer_text' => 'required|string|max:500',
            'answers.*.is_correct' => 'boolean',
        ]);

        $id = 'Q-' . strtoupper(Str::random(10));

        $question = Question::create([
            'id' => $id,
            'question_text' => $data['question_text'],
            'test_id' => $data['test_id'],
        ]);

        foreach ($data['answers'] as $answer) {
            $question->answers()->create($answer);
        }

        return response()->json([
            'message' => 'Question created successfully',
            'question' => $question->load('test', 'answers'),
        ], 201);
    }


    // ✅ Update existing question
    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'question_text' => 'required|string|max:1000',
            'test_id' => 'required|exists:tests,id',
            'answers' => 'required|array|min:2',
            'answers.*.answer_text' => 'required|string|max:500',
            'answers.*.is_correct' => 'boolean',
        ]);

        $question->update([
            'question_text' => $data['question_text'],
            'test_id' => $data['test_id'],
        ]);

        // Replace answers
        $question->answers()->delete();
        foreach ($data['answers'] as $answer) {
            $question->answers()->create($answer);
        }

        return response()->json(
            [
                'message' => 'Question updated successfully',
                'question' => $question->load('test', 'answers')
            ],
            200
        );
    }

    // ✅ Delete a question
    public function destroy(Question $question)
    {
        $question->answers()->delete();
        $question->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function destroyAll()
    {
        Question::query()->delete();

        return response()->json([
            'message' => '✅ All questions deleted successfully.',
        ]);
    }
}
