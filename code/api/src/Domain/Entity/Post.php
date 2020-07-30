<?php

namespace Project\Domain\Entity;

use DateTimeImmutable;

class Post
{
    public const FIELD_ID = 'id';
    public const FIELD_USER_ID = 'userId';
    public const FIELD_TITLE = 'title';
    public const FIELD_BODY = 'body';
    public const FIELD_CREATED_AT = 'createdAt';
    public const FIELD_UPDATED_AT = 'updatedAt';

    private int $id;
    private int $userId;
    private string $title;
    private string $body;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        int $userId,
        string $title,
        string $body,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            $data[self::FIELD_ID],
            $data[self::FIELD_USER_ID],
            $data[self::FIELD_TITLE],
            $data[self::FIELD_BODY],
            (new DateTimeImmutable())->setTimestamp($data[self::FIELD_CREATED_AT]),
            (new DateTimeImmutable())->setTimestamp($data[self::FIELD_UPDATED_AT]),
        );
    }

    public function toArray(): array
    {
        return [
            self::FIELD_ID => $this->getId(),
            self::FIELD_USER_ID => $this->getUserId(),
            self::FIELD_TITLE => $this->getTitle(),
            self::FIELD_BODY => $this->getBody(),
            self::FIELD_CREATED_AT => $this->getCreatedAt()->getTimestamp(),
            self::FIELD_UPDATED_AT => $this->getUpdatedAt()->getTimestamp(),
        ];
    }
}
