<?php

namespace Project\Infrastructure\Interfaces\Database;

use Project\Domain\Entity\Collection\UserCollection;
use Project\Domain\Entity\User\User as UserEntity;

interface UserRepositoryInterface
{
    public function getUsers(): UserCollection;

    public function getUser(int $id): UserEntity;
}
