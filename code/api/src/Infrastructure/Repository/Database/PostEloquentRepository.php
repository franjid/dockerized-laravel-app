<?php

namespace Project\Infrastructure\Repository\Database;

use App\Comment;
use App\Post;
use Project\Domain\Entity\Collection\CommentCollection;
use Project\Domain\Entity\Collection\PostCollection;
use Project\Domain\Entity\Post as PostEntity;
use Project\Domain\Entity\Comment as CommentEntity;
use Project\Infrastructure\Exception\Database\PostNotFoundException;
use Project\Infrastructure\Interfaces\Database\PostRepositoryInterface;

class PostEloquentRepository implements PostRepositoryInterface
{
    private Post $postModel;
    private Comment $commentModel;

    public function __construct(
        Post $postModel,
        Comment $commentModel
    )
    {
        $this->postModel = $postModel;
        $this->commentModel = $commentModel;
    }

    public function getUserPosts(int $userId): PostCollection
    {
        $results = $this->postModel::all();

        if (!$results) {
            return new PostCollection();
        }

        $users = [];

        foreach ($results as $result) {
            $users[] = PostEntity::buildFromArray([
                PostEntity::FIELD_ID => $result->id,
                PostEntity::FIELD_USER_ID => $result->user_id,
                PostEntity::FIELD_TITLE => $result->title,
                PostEntity::FIELD_BODY => $result->body,
                PostEntity::FIELD_CREATED_AT => $result->created_at->timestamp,
                PostEntity::FIELD_UPDATED_AT => $result->updated_at->timestamp,
            ]);
        }

        return new PostCollection(...$users);
    }

    public function getPostComments(int $postId): CommentCollection
    {
        $result = $this->postModel::find($postId);

        if (!$result) {
            throw new PostNotFoundException('Post id not found: ' . $postId);
        }

        $results = $this->postModel::find($postId)->comments;

        if (!$results) {
            return new CommentCollection();
        }

        $comments = [];

        foreach ($results as $result) {
            $comments[] = CommentEntity::buildFromArray([
                CommentEntity::FIELD_ID => $result->id,
                CommentEntity::FIELD_POST_ID => $result->post_id,
                CommentEntity::FIELD_NAME => $result->name,
                CommentEntity::FIELD_EMAIL => $result->email,
                CommentEntity::FIELD_BODY => $result->body,
                CommentEntity::FIELD_CREATED_AT => $result->created_at->timestamp,
                CommentEntity::FIELD_UPDATED_AT => $result->updated_at->timestamp,
            ]);
        }

        return new CommentCollection(...$comments);
    }
}
