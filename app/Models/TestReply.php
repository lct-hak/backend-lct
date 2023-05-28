<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReply extends Model
{
    protected $table = 'test_replies';
    protected $guarded = ['id'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function testQuestion()
    {
        return $this->belongsTo(TestQuestion::class);
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'specification_test_reply');
    }

    public function testResponses()
    {
        return $this->belongsToMany(TestResponse::class, 'test_reply_test_response');
    }
}
