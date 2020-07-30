<?php

namespace Project\Domain\Service;

use App\Post;
use Project\Domain\Entity\Collection\PostCollection;
use Project\Infrastructure\Interfaces\Api\JsonPlaceHolderRepositoryInterface;
use Project\Infrastructure\Interfaces\Database\PostRepositoryInterface;

class PostService
{
    private PostRepositoryInterface $postRepository;
    private JsonPlaceHolderRepositoryInterface $jsonPlaceHolderRepository;
    private Post $postModel;

    public function __construct(
        PostRepositoryInterface $postRepository,
        JsonPlaceHolderRepositoryInterface $jsonPlaceHolderRepository,
        Post $postModel
    )
    {
        $this->postRepository = $postRepository;
        $this->jsonPlaceHolderRepository = $jsonPlaceHolderRepository;
        $this->postModel = $postModel;
    }

    public function getUserPosts(int $userId): PostCollection
    {
        $dbUserPosts = $this->postRepository->getUserPosts($userId);

        if ($dbUserPosts->count() >= 50) {
            return $dbUserPosts;
        }

        $apiUserPosts = $this->jsonPlaceHolderRepository->getUserPosts($userId);

        foreach ($apiUserPosts as $post) {
            $this->postModel::updateOrCreate([
                'id' => $post['id'],
                'user_id' => $post['userId'],
                'title' => $post['title'],
                'body' => $post['body'],
            ]);
        }

        return $this->postRepository->getUserPosts($userId);
    }
}
