<?php

namespace App\Http\Controllers\TestModule;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestPage;
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
            'pages' => 'required|array',
            'pages.*.title' => 'required|string|max:255',
            'pages.*.questions' => 'required|array',
            'pages.*.questions.*.question' => 'required|string|max:255',
            'pages.*.questions.*.replies' => 'required|array',
            'pages.*.questions.*.replies.*.reply' => 'required|string|max:255',
            'pages.*.questions.*.replies.*.specifications' => 'required|array',
            'pages.*.questions.*.replies.*.specifications.*' => 'required|integer|exists:specifications,id',
        ]);

        DB::beginTransaction();
        Test::query()->delete();
        // Создание нового теста
        $test = Test::create(['name' => 'main']);
        foreach ($validatedData['pages'] as $pageItem) {
            // Создание страницы
            $page = TestPage::query()->create([
                'title' => $pageItem['title'],
                'test_id' => $test->id
            ]);
            foreach ($pageItem['questions'] as $questionData) {
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
        }
        DB::commit();
        return response()->json($test, 201);
    }
}
