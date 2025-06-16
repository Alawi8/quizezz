<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tests = Test::withCount('questions')->get();
        return response()->json($tests);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);

        $section = Test::create($validated);

        return response()->json($section, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);

        $section = Test::create($validated);

        return response()->json($section, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $section)
    {
        return response()->json($section);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);

        $section->update($validated);

        return response()->json($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $section)
    {
        $section->delete();
        return response()->json(['message' => 'Section deleted']);
    }
    // display question by use test
    public function questions(Test $section)
    {
        $section->load('questions'); // eager load
        return view('admin.sections.questions', compact('section'));
    }
}
