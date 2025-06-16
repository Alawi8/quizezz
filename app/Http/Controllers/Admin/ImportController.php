<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;
use App\Imports\SectionsImport;
use App\Imports\UsersImport;

class ImportController extends Controller
{
    public function importQuestions(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx|max:2048',
        ]);

        try {
            Excel::import(new QuestionsImport, $request->file('file'));
            return response()->json(['message' => '✅ Questions imported successfully']);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'message' => '❌ Import failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function importSections(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:csv,xlsx|max:2048',
    //     ]);

    //     try {
    //         Excel::import(new SectionsImport, $request->file('file'));
    //         return response()->json(['message' => '✅ Sections imported successfully']);
    //     } catch (\Throwable $e) {
    //         report($e);
    //         return response()->json([
    //             'message' => '❌ Import failed',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function importUsers(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:csv,xlsx|max:2048',
    //     ]);

    //     try {
    //         Excel::import(new UsersImport, $request->file('file'));
    //         return response()->json(['message' => '✅ Users imported successfully']);
    //     } catch (\Throwable $e) {
    //         report($e);
    //         return response()->json([
    //             'message' => '❌ Import failed',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}
