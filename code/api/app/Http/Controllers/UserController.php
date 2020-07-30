<?php

namespace App\Http\Controllers;

use Project\Domain\Service\PostService;
use Project\Domain\Service\UserService;
use Project\Infrastructure\Exception\Api\UserNotFoundException;

class UserController extends Controller
{
    public function index(UserService $userService)
    {
        return response()->json($userService->getUsers()->toArray());
    }

    public function getUserId(int $id, UserService $userService)
    {
        try {
            return response()->json($userService->getUser($id)->toArray());
        } catch (UserNotFoundException $e) {
            return response()->json([], 404);
        }
    }

    public function getUserPosts(int $userId, PostService $postService)
    {
        try {
            return response()->json($postService->getUserPosts($userId)->toArray());
        } catch (UserNotFoundException $e) {
            return response()->json([], 404);
        }
    }
}
