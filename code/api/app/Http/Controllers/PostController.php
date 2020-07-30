<?php

namespace App\Http\Controllers;

use Project\Domain\Service\PostService;
use Project\Infrastructure\Exception\Database\PostNotFoundException;

class PostController extends Controller
{
    public function getPostComments(int $postId, PostService $postService)
    {
        try {
            return response()->json($postService->getPostComments($postId)->toArray());
        } catch (PostNotFoundException $e) {
            return response()->json([], 404);
        } catch (\Project\Infrastructure\Exception\Api\PostNotFoundException $e) {
            return response()->json([], 404);
        }
    }
}
