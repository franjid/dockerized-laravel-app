<?php

namespace Project\Domain\Entity\Collection;

use Project\Domain\Entity\Post;

class PostCollection
{
    /** @var Post[] $posts */
    private array $posts;

    public function __construct(?Post ...$posts)
    {
        $this->posts = $posts;
    }

    public function getItems(): array
    {
        return $this->posts;
    }

    public function count(): int
    {
        return count($this->getItems());
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->posts as $post) {
            $result[] = $post->toArray();
        }

        return $result;
    }
}
