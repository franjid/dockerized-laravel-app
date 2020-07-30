<?php

namespace Project\Infrastructure\Interfaces\Api;

interface JsonPlaceHolderRepositoryInterface
{
    public function getUsers(): array;

    public function getUser(int $id): array;

    public function getUserPosts(int $userId): array;

    public function getPost(int $postId): array;

    public function getPostComments(int $postId): array;
}
