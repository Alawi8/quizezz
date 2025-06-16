<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Test;

class QuestionsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $defaultTest = Test::first(); // Get the first test as default
    
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; //skip header row
    
            $testIdFromExcel = $row[1] ?? null;
    
            $test = Test::where('id', $testIdFromExcel)->first();

    
            $testId = $test?->id ?? $defaultTest?->id;
    
            // create question
            $question = Question::create([
                'question_text' => $row[0],
                'test_id' => $testId,
            ]);
    
            // create 4 answers
            for ($i = 2; $i <= 5; $i++) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $row[$i],
                    'is_correct' => ($i - 1) == $row[6], // Assuming the correct answer is in the 6th column
                ]);
            }
        }
    } 
}