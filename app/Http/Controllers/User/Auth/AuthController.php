<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\UserService;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}


    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->createUser($data);

        return response()->json([
            'message' => 'User created successfully',
            'user'    => $user,
        ], 201);
    }


    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        return $this->respondWithSuccess($this->userService->login($data));

    }

    public function logout()
    {
        $this->userService->logout();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function me()
    {
        return response()->json(
            $this->userService->me()
        );
    }
}
