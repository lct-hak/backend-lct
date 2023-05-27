<?php

namespace App\Http\Controllers\TestModule;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function createTest(Request $request)
    {
        // Валидация входных данных
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string|max:255',
            'questions.*.replies' => 'required|array',
            'questions.*.replies.*.reply' => 'required|string|max:255',
            'questions.*.replies.*.specifications' => 'required|array',
            'questions.*.replies.*.specifications.*' => 'required|integer|exists:specifications,id',
        ]);

        DB::beginTransaction();
        // Создание нового теста
        $test = Test::create(['name' => 'main']);

            // Создание страницы
            $page = $test->testPages()->create(['title' => $validatedData['title']]);
            foreach ($validatedData['questions'] as $questionData) {
                // Создание вопроса
                $question = TestQuestion::query()->create([
                    'test_page_id' => $page->id,
                    'question' => $questionData['question']
                ]);

                foreach ($questionData['replies'] as $replyData) {
                    $reply = TestReply::query()->create([
                        'test_question_id' => $question->id,
                        'test_id' => $test->id,
                        'reply' => $replyData['reply'],
                    ]);
                    $reply->specifications()->attach($replyData['specifications']);
                }
            }
        DB::commit();
        return response()->json($test, 201);
    }
}
