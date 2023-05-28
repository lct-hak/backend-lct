<?php

namespace App\Http\Controllers\TestModule;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getTest()
    {
        $test = Test::with('testPages.testQuestions.testReplies')->where('name', '=','main')->firstOrFail();

        return response()->json(['data' => $test]);
    }
}
