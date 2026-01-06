<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function createUser(array $data): User
    {
        //dd($data);
        return User::create([
            'full_name'  => $data['full_name'],
            'email'    => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => $data['password'],
        ]);
    }

    public function login(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $user = Auth::user();
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function logout(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user) {
            // delete current token only
            $user->currentAccessToken()->delete();
        }
    }
    public function me(): ?User
    {
        return Auth::user();
    }
}
