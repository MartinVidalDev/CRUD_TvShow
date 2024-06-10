<?php

declare(strict_types=1);

namespace Entity;

class Season
{
    private int $id;
    private int $tvShowId;
    private string $name;
    private int $seasonNumber;
    private int $posterId;
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }
    public function setTvShowId(int $tvShowId): void
    {
        $this->tvShowId = $tvShowId;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }
    public function setSeasonNumber(int $seasonNumber): void
    {
        $this->seasonNumber = $seasonNumber;
    }
    public function getPosterId(): int
    {
        return $this->posterId;
    }
    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }


}
