<?php

namespace App\Http\Controllers\TestModule;

use App\Http\Controllers\Controller;
use App\Models\TestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestResponseController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'nullable|string',
            'test_id' => 'required|exists:tests,id',
            'user_id' => 'nullable|exists:unauthenticated_users,uuid',
            'answers' => 'required|array',
            'answers.*.test_question_id' => 'required|exists:test_questions,id',
            'answers.*.test_reply_id' => 'required|exists:test_replies,id',
        ]);


        // Если пользователь аутентифицирован, получаем его идентификатор
        if (Auth::check()) {
            $userId = Auth::id();
        }

        // Создаем новый ответ на тест с указанием пользователя или неаутентифицированного пользователя
        $testResponse = TestResponse::create([
            'uuid' => $validatedData['uuid'],
            'user_id' => $userId,
            'test_id' => $validatedData['test_id'],
        ]);

        // Привязываем выбранные варианты ответов к ответу на тест
        $testResponse->testReplies()->attach($validatedData['answers']);

        return response()->json(['message' => 'Test response created successfully', 'data' => $testResponse], 201);
    }
}
