<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{

    public function testPage()
    {
        return $this->belongsTo(TestPage::class);
    }

    public function testReplies()
    {
        return $this->hasMany(TestReply::class);
    }
}
