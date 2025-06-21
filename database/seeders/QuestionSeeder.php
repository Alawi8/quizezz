<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        for ($section = 1; $section <= 5; $section++) {
            $test = Test::firstOrCreate(
                ['title' => "Test Section $section - " . uniqid()],
                [
                    'description' => "Unique section $section created at " . $now,
                    'duration' => 15
                ]
            );

            for ($q = 1; $q <= 5; $q++) {
                $questionText = "[Section $section] What is the answer to question $q?";
                $question = $test->questions()->create([
                    'question_text' => $questionText,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                $correctIndex = rand(1, 4);

                for ($a = 1; $a <= 4; $a++) {
                    $answerText = "[S$section-Q$q-A$a] This is option $a";
                    $question->answers()->create([
                        'answer_text' => $answerText,
                        'is_correct' => $a === $correctIndex,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            }
        }

        echo "✅ Seeded 5 unique sections with 5 unique questions each (4 answers per question).\n";
    }
}
