<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class TestResponse extends Model
{
    protected $fillable = ['user_id', 'unauthenticated_user_id', 'test_id'];

    protected static function boot()
    {
        parent::boot();

        // Генерация UUID перед созданием новой записи
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unauthenticatedUser()
    {
        return $this->belongsTo(UnauthenticatedUser::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function testReplies()
    {
        return $this->belongsToMany(TestReply::class);
    }
}
