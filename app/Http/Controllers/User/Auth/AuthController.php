<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\Auth\UserService;

class AuthController extends Controller
{

    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * POST /auth/register
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->createUser($data);

        return $this->successResponse(message:'User created successfully',data:$user,statusCode:201);
    }

    /**
     * POST /auth/login
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $result = $this->userService->login($data);

        return $this->successResponse($result,statusCode:200);
    }

    /**
     * POST /auth/logout
     */
    public function logout()
    {
        $this->userService->logout();

        return $this->successResponse(message: 'Logged out successfully',statusCode:204);
    }

    /**
     * GET /auth/me
     */
    public function me()
    {
        $user = $this->userService->me();

        return $this->successResponse(data:$user,statusCode:200);
    }
}
