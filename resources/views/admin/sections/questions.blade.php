<x-app-layout>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">🧾 Questions for: {{ $section->title }}</h1>

        @if ($section->questions->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                No questions found for this section.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($section->questions as $question)
                    <div class="p-4 bg-white border rounded shadow-sm space-y-2">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $question->text }}</h2>

                        @if ($question->answers && $question->answers->count())
                            <ul class="list-disc pl-5 text-sm text-gray-700">
                                @foreach ($question->answers as $answer)
                                    <li class="{{ $answer->is_correct ? 'text-green-600 font-bold' : '' }}">
                                        {{ $answer->answer_text }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No answers added.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
