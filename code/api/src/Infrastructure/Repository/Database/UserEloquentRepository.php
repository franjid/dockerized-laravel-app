<?php

namespace Project\Infrastructure\Repository\Database;

use App\User;
use Project\Domain\Entity\Collection\UserCollection;
use Project\Domain\Entity\User\User as UserEntity;
use Project\Infrastructure\Exception\Database\UserNotFoundException;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;

class UserEloquentRepository implements UserRepositoryInterface
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getAll(): UserCollection
    {
        $results = $this->userModel::all();

        if (!$results) {
            return new UserCollection();
        }

        $users = [];

        foreach ($results as $result) {
            $users[] = UserEntity::buildFromArray([
                UserEntity::FIELD_ID => $result->id,
                UserEntity::FIELD_NAME => $result->name,
                UserEntity::FIELD_USERNAME => $result->username,
                UserEntity::FIELD_EMAIL => $result->email,
                UserEntity::FIELD_CREATED_AT => $result->created_at->timestamp,
                UserEntity::FIELD_UPDATED_AT => $result->updated_at->timestamp,
            ]);
        }

        return new UserCollection(...$users);
    }

    public function getUser(int $id): UserEntity
    {
        $result = $this->userModel::find($id);

        if (!$result) {
            throw new UserNotFoundException('User id not found: ' . $id);
        }

        return UserEntity::buildFromArray([
            UserEntity::FIELD_ID => $result->id,
            UserEntity::FIELD_NAME => $result->name,
            UserEntity::FIELD_USERNAME => $result->username,
            UserEntity::FIELD_EMAIL => $result->email,
            UserEntity::FIELD_CREATED_AT => $result->created_at->timestamp,
            UserEntity::FIELD_UPDATED_AT => $result->updated_at->timestamp,
        ]);
    }
}
