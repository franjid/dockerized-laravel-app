<?php

namespace Project\Infrastructure\Interfaces\Database;

use Project\Domain\Entity\Collection\CommentCollection;
use Project\Domain\Entity\Collection\PostCollection;

interface PostRepositoryInterface
{
    public function getUserPosts(int $userId): PostCollection;
    public function getPostComments(int $postId): CommentCollection;
}
