<?php

namespace Project\Domain\Entity;

use DateTimeImmutable;

class Comment
{
    public const FIELD_ID = 'id';
    public const FIELD_POST_ID = 'postId';
    public const FIELD_NAME = 'name';
    public const FIELD_EMAIL = 'email';
    public const FIELD_BODY = 'body';
    public const FIELD_CREATED_AT = 'createdAt';
    public const FIELD_UPDATED_AT = 'updatedAt';

    private int $id;
    private int $postId;
    private string $name;
    private string $email;
    private string $body;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        int $postId,
        string $name,
        string $email,
        string $body,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->postId = $postId;
        $this->name = $name;
        $this->email = $email;
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
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
            $data[self::FIELD_POST_ID],
            $data[self::FIELD_NAME],
            $data[self::FIELD_EMAIL],
            $data[self::FIELD_BODY],
            (new DateTimeImmutable())->setTimestamp($data[self::FIELD_CREATED_AT]),
            (new DateTimeImmutable())->setTimestamp($data[self::FIELD_UPDATED_AT]),
        );
    }

    public function toArray(): array
    {
        return [
            self::FIELD_ID => $this->getId(),
            self::FIELD_POST_ID => $this->getPostId(),
            self::FIELD_NAME => $this->getName(),
            self::FIELD_EMAIL => $this->getEmail(),
            self::FIELD_BODY => $this->getEmail(),
            self::FIELD_CREATED_AT => $this->getCreatedAt()->getTimestamp(),
            self::FIELD_UPDATED_AT => $this->getUpdatedAt()->getTimestamp(),
        ];
    }
}
