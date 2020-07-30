<?php

namespace Project\Domain\Entity\Collection;

use Project\Domain\Entity\Comment;

class CommentCollection
{
    /** @var Comment[] $comments */
    private array $comments;

    public function __construct(?Comment ...$comments)
    {
        $this->comments = $comments;
    }

    public function getItems(): array
    {
        return $this->comments;
    }

    public function count(): int
    {
        return count($this->getItems());
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->comments as $comment) {
            $result[] = $comment->toArray();
        }

        return $result;
    }
}
