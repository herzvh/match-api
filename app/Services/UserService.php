<?php


namespace App\Services;



use App\Models\User;

class UserService
{
    public function createUser($fields)
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

    public function getUserToken()
    {
        $user = User::first();


        $token = $user->createToken('myapptoken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
