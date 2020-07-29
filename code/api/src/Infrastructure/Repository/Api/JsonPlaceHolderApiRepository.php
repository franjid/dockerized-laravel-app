<?php

namespace Project\Infrastructure\Repository\Api;

use GuzzleHttp\Client;
use Project\Domain\Entity\User\Type\ApiRequestTypeEnum;
use Project\Infrastructure\Interfaces\Api\JsonPlaceHolderRepositoryInterface;

class JsonPlaceHolderApiRepository implements JsonPlaceHolderRepositoryInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getUsers(): array
    {
        return $this->request(new ApiRequestTypeEnum(ApiRequestTypeEnum::GET), '/users');
    }

    public function getUser(int $id): array
    {
        return $this->request(new ApiRequestTypeEnum(ApiRequestTypeEnum::GET), '/users/' . $id);
    }

    private function request(ApiRequestTypeEnum $type, string $url)
    {
        $response = $this->client->request($type->getValue(), $url);

        return $this->formatResponse($response->getBody()->getContents());
    }

    private function formatResponse(string $response): array
    {
        if ($response && $response !== '') {
            return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        }

        return [];
    }
}
