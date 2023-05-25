<?php

namespace App\Http\Controllers\TestModule;

use App\Http\Controllers\Controller;
use App\Models\TestResponse;
use Illuminate\Http\Request;

class TestResponseController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'unauthenticated_user_id' => 'nullable|exists:unauthenticated_users,id',
            'test_id' => 'required|exists:tests,id',
        ]);

        $testResponse = TestResponse::create($validatedData);

        // Связываем выбранные варианты ответов с ответом на тест
        $testResponse->testReplies()->sync($request->input('test_replies'));

        return response()->json(['message' => 'Test response created successfully', 'data' => $testResponse], 201);
    }
}
