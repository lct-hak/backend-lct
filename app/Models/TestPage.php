<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPage extends Model
{
    protected $fillable = ['test_id', 'title'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function testQuestions()
    {
        return $this->hasMany(TestQuestion::class);
    }
}
