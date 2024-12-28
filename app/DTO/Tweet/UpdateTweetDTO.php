<?php

declare(strict_types=1);

namespace App\DTO\Tweet;

class UpdateTweetDTO
{
    public function __construct(
        private int $id,
        private ?string $username,
        private ?string $content,
        private ?int $categoryId,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int|string $id): void
    {
        $this->id = (int)$id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

}
