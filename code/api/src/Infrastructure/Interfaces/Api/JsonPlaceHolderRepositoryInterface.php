<?php

namespace Project\Infrastructure\Interfaces\Api;

interface JsonPlaceHolderRepositoryInterface
{
    public function getUsers(): array;

    public function getUser(int $id): array;
}
