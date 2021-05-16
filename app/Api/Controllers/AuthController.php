<?php

namespace App\Api\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $responseData = $this->userService->createUser($fields);
        return response($responseData, 201);
    }

    public function getToken()
    {
        $responseData = $this->userService->getUserToken();
        return response($responseData, 200);
    }
}
