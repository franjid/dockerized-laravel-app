<?php

namespace App\Http\Controllers;

use Project\Infrastructure\Exception\Database\UserNotFoundException;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;

class UserController extends Controller
{
    public function index(UserRepositoryInterface $userRepository)
    {
        return response()->json($userRepository->getAll()->toArray());
    }

    public function getUserId(int $id, UserRepositoryInterface $userRepository)
    {
        try {
            $user = $userRepository->getUser($id);
        } catch (UserNotFoundException $e) {
            return response()->json([], 404);
        }

        return response()->json($user->toArray());
    }
}
