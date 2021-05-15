<?php


namespace App\Services;



use App\Models\User;

class UserService
{
    public function getUserToken($fields)
    {
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
