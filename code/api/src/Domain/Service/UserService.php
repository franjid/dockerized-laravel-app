<?php

namespace Project\Domain\Service;

use App\User;
use GuzzleHttp\Exception\ClientException;
use Project\Domain\Entity\Collection\UserCollection;
use Project\Infrastructure\Exception\Database\UserNotFoundException;
use Project\Infrastructure\Interfaces\Api\JsonPlaceHolderRepositoryInterface;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;
use Project\Domain\Entity\User\User as UserEntity;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private JsonPlaceHolderRepositoryInterface $jsonPlaceHolderRepository;
    private User $userModel;

    public function __construct(
        UserRepositoryInterface $userRepository,
        JsonPlaceHolderRepositoryInterface $jsonPlaceHolderRepository,
        User $userModel
    )
    {
        $this->userRepository = $userRepository;
        $this->jsonPlaceHolderRepository = $jsonPlaceHolderRepository;
        $this->userModel = $userModel;
    }

    public function getUsers(): UserCollection
    {
        $dbUsers = $this->userRepository->getUsers();

        if ($dbUsers->getItems()) {
            return $dbUsers;
        }

        $apiUsers = $this->jsonPlaceHolderRepository->getUsers();

        foreach ($apiUsers as $user) {
            $this->userModel::create([
                'id' => $user['id'],
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
            ]);
        }

        return $this->userRepository->getUsers();
    }

    public function getUser(int $id): UserEntity
    {
        try {
            return $this->userRepository->getUser($id);
        } catch (UserNotFoundException $e) {
            try {
                $apiUser = $this->jsonPlaceHolderRepository->getUser($id);
            } catch (ClientException $e) {
                throw new \Project\Infrastructure\Exception\Api\UserNotFoundException();
            }

            $this->userModel::create([
                'id' => $apiUser['id'],
                'name' => $apiUser['name'],
                'username' => $apiUser['username'],
                'email' => $apiUser['email'],
            ]);

            return $this->userRepository->getUser($id);
        }
    }
}
