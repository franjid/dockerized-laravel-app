<?php

namespace Project\Domain\Entity\User;

use DateTimeImmutable;

class User
{
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_USERNAME = 'username';
    public const FIELD_EMAIL = 'email';
    public const FIELD_CREATED_AT = 'createdAt';
    public const FIELD_UPDATED_AT = 'updatedAt';

    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        int $id,
        string $name,
        string $username,
        string $email,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
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
            $data[self::FIELD_NAME],
            $data[self::FIELD_USERNAME],
            $data[self::FIELD_EMAIL],
            (new DateTimeImmutable())->setTimestamp($data[self::FIELD_CREATED_AT]),
            (new DateTimeImmutable())->setTimestamp($data[self::FIELD_UPDATED_AT]),
        );
    }

    public function toArray(): array
    {
        return [
            self::FIELD_ID => $this->getId(),
            self::FIELD_NAME => $this->getName(),
            self::FIELD_USERNAME => $this->getUsername(),
            self::FIELD_EMAIL => $this->getEmail(),
            self::FIELD_CREATED_AT => $this->getCreatedAt()->getTimestamp(),
            self::FIELD_UPDATED_AT => $this->getUpdatedAt()->getTimestamp(),
        ];
    }
}
