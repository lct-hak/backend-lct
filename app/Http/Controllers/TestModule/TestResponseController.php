<?php

namespace App\Http\Controllers\TestModule;

use App\Http\Controllers\Controller;
use App\Models\TestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestResponseController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'test_id' => 'required|exists:tests,id',
            'user_id' => 'nullable|exists:unauthenticated_users,uuid',
            'answers' => 'required|array',
            'answers.*.test_reply_id' => 'required|exists:test_replies,id',
        ]);

        $data = [
            'test_id' => $validatedData['test_id'],
        ];

        // Если пользователь аутентифицирован, получаем его идентификатор
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } elseif($request->input('user_id')) {
            $data['unauthenticated_user_id'] = $request->input('user_id');
        } else {
            $request->validate([
                'user_id' => 'required'
            ]);
        }
        DB::beginTransaction();
        // Создаем новый ответ на тест с указанием пользователя или неаутентифицированного пользователя
        $testResponse = TestResponse::create($data);

        // Привязываем выбранные варианты ответов к ответу на тест
        $testResponse->testReplies()->attach($validatedData['answers']);
        DB::commit();
        return response()->json(['message' => 'Test response created successfully', 'data' => $testResponse], 201);
    }
}
