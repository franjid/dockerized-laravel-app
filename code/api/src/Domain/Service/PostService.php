<?php

namespace Project\Domain\Service;

use App\Comment;
use App\Post;
use GuzzleHttp\Exception\ClientException;
use Project\Domain\Entity\Collection\CommentCollection;
use Project\Domain\Entity\Collection\PostCollection;
use Project\Infrastructure\Exception\Database\PostNotFoundException;
use Project\Infrastructure\Interfaces\Api\JsonPlaceHolderRepositoryInterface;
use Project\Infrastructure\Interfaces\Database\PostRepositoryInterface;

class PostService
{
    private PostRepositoryInterface $postRepository;
    private JsonPlaceHolderRepositoryInterface $jsonPlaceHolderRepository;
    private Post $postModel;
    private Comment $commentModel;

    public function __construct(
        PostRepositoryInterface $postRepository,
        JsonPlaceHolderRepositoryInterface $jsonPlaceHolderRepository,
        Post $postModel,
        Comment $commentModel
    )
    {
        $this->postRepository = $postRepository;
        $this->jsonPlaceHolderRepository = $jsonPlaceHolderRepository;
        $this->postModel = $postModel;
        $this->commentModel = $commentModel;
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

    public function getPostComments(int $postId): CommentCollection
    {
        try {
            $dbPostComments = $this->postRepository->getPostComments($postId);

            if ($dbPostComments->count() >= 5) {
                return $dbPostComments;
            }

            $apiPostComments = $this->jsonPlaceHolderRepository->getPostComments($postId);

            foreach ($apiPostComments as $comment) {
                $this->commentModel::updateOrCreate([
                    'id' => $comment['id'],
                    'post_id' => $comment['postId'],
                    'name' => $comment['name'],
                    'email' => $comment['email'],
                    'body' => $comment['body'],
                ]);
            }

            return $this->postRepository->getPostComments($postId);
        } catch (PostNotFoundException $e) {
            try {
                $apiPost = $this->jsonPlaceHolderRepository->getPost($postId);

                $this->postModel::create([
                    'id' => $apiPost['id'],
                    'user_id' => $apiPost['userId'],
                    'title' => $apiPost['title'],
                    'body' => $apiPost['body'],
                ]);

                return $this->getPostComments($postId);
            } catch (ClientException $e) {
                throw new \Project\Infrastructure\Exception\Api\PostNotFoundException();
            }
        }
    }
}
