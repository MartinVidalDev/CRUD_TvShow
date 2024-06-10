<?php

namespace Entity;
use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class TVShow
{
    private int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    private int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPosterId(): int
    {
        return $this->posterId;
    }

    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getHomepage(): string
    {
        return $this->homepage;
    }

    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }


    /**
     * Find a show with its ID
     * @param int $id
     * @return self|null
     */
    public static function findById(int $id): self
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                WHERE id = :id
            SQL);

        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $artist = $stmt->fetch();

        if (!$artist) {
            throw new EntityNotFoundException('Artist', $id);
        }

        return $artist;
    }
}