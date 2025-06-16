<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Test;
use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use App\Models\Question;

class StatsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'users' => User::count(),
            'tests' => Test::count(),
            'answers' => Answer::count(),
            'questions' => Question::count(),
        ]);
    }
}
