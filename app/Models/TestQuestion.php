<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $guarded = ['id'];

    public function testPage()
    {
        return $this->belongsTo(TestPage::class, 'test_page_id');
    }

    public function testReplies()
    {
        return $this->hasMany(TestReply::class, 'test_question_id');
    }
}
