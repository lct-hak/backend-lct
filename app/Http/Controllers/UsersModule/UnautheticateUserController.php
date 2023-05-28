<?php

namespace App\Http\Controllers\UsersModule;

use App\Http\Controllers\Controller;
use App\Models\UnauthenticatedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnautheticateUserController extends Controller
{
    public function getOrCreate(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'patronymic' => 'nullable|string',
            'date_of_birth' => 'required|date',
        ]);

        $firstName = Str::lower($validatedData['first_name']);
        $lastName = Str::lower($validatedData['last_name']);
        $patronymic = $validatedData['patronymic'] ? Str::lower($validatedData['patronymic']) : null;
        $dateOfBirth = $validatedData['date_of_birth'];

        $user = UnauthenticatedUser::whereRaw('LOWER(first_name) = ? AND LOWER(last_name) = ? AND LOWER(patronymic) = ? AND date_of_birth = ?', [$firstName, $lastName, $patronymic, $dateOfBirth])->first();

        if (!$user) {
            $user = UnauthenticatedUser::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'patronymic' => $validatedData['patronymic'],
                'date_of_birth' => $validatedData['date_of_birth'],
            ]);
        }

        return response()->json($user, 200);
    }
}
