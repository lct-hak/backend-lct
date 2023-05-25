<?php

namespace App\Http\Controllers\TestModule;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createTest(Request $request)
    {
        // Валидация входных данных
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'pages' => 'required|array',
            'pages.*.title' => 'required|string|max:255',
            'pages.*.questions' => 'required|array',
            'pages.*.questions.*.question' => 'required|string|max:255',
            'pages.*.questions.*.replies' => 'required|array',
            'pages.*.questions.*.replies.*.reply' => 'required|string|max:255',
            'pages.*.questions.*.replies.*.specifications' => 'required|array',
            'pages.*.questions.*.replies.*.specifications.*' => 'required|integer|exists:specifications,id',
        ]);

        // Создание нового теста
        $test = Test::create(['name' => $validatedData['name']]);

        // Создание страниц, вопросов и ответов
        foreach ($validatedData['pages'] as $pageData) {
            // Создание страницы
            $page = $test->testPages()->create(['title' => $pageData['title']]);

            foreach ($pageData['questions'] as $questionData) {
                // Создание вопроса
                $question = $page->testQuestions()->create(['question' => $questionData['question']]);

                foreach ($questionData['replies'] as $replyData) {
                    // Создание ответа
                    $reply = $test->testReplies()->create([
                        'test_question_id' => $question->id,
                        'reply' => $replyData['reply'],
                    ]);

                    $reply->specifications()->attach($replyData['specifications']);
                }
            }
        }

        return response()->json($test, 201);
    }
}
