<?php

namespace App\Http\Controllers;

use Project\Domain\Service\UserService;
use Project\Infrastructure\Exception\Api\UserNotFoundException;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json($this->userService->getUsers()->toArray());
    }

    public function getUserId(int $id, UserRepositoryInterface $userRepository)
    {
        try {
            return response()->json($this->userService->getUser($id)->toArray());
        } catch (UserNotFoundException $e) {
            return response()->json([], 404);
        }
    }
}
