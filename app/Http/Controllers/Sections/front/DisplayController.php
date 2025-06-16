<?php

namespace App\Http\Controllers\Sections\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class DisplayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
    
        if ($user->hasRole('super-admin')) {
            $tests = Test::select('id', 'title', 'description', 'duration')
                        ->withCount('questions')
                        ->get();
        } elseif ($user->hasRole('student')) {
            $tests = Test::select('id', 'title', 'description', 'duration')
                        ->withCount('questions')
                        ->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        return response()->json([
            'data' => $tests
        ]);
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
