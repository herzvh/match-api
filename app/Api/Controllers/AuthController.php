<?php

namespace App\Api\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;

class AuthController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request)
    {

        $fields = $request->validate();

        $responseData = $this->userService->getUserToken($fields);
        return response($responseData, 201);
    }
}
