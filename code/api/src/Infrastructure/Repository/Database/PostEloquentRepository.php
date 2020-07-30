<?php

namespace Project\Infrastructure\Repository\Database;

use App\Post;
use Project\Domain\Entity\Collection\PostCollection;
use Project\Domain\Entity\Post as PostEntity;
use Project\Infrastructure\Interfaces\Database\PostRepositoryInterface;

class PostEloquentRepository implements PostRepositoryInterface
{
    private Post $postModel;

    public function __construct(Post $postModel)
    {
        $this->postModel = $postModel;
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
}
