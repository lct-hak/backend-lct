<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UnauthenticatedUser extends Model
{
    protected $fillable = ['uuid', 'first_name', 'last_name', 'patronymic', 'date_of_birth'];

    protected static function boot()
    {
        parent::boot();

        // Создание UUID перед сохранением модели
        static::creating(function ($unauthenticatedUser) {
            $unauthenticatedUser->uuid = Uuid::uuid1();
        });
    }
}
