<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Episode
{
    private ?int $id;
    private int $seasonId;
    private string $name;
    private string $overview;
    private int $episodeNumber;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSeasonId(): int
    {
        return $this->seasonId;
    }

    public function setSeasonId(int $seasonId): void
    {
        $this->seasonId = $seasonId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    public function getEpisodeNumber(): int
    {
        return $this->episodeNumber;
    }

    public function setEpisodeNumber(int $episodeNumber): void
    {
        $this->episodeNumber = $episodeNumber;
    }

    /**
     * Retrieves an episode by its ID from the database.
     *
     * This static method executes a SQL query to select all columns from the `episode` table
     * for a given episode ID. It returns the result as an `Episode` object if found, otherwise
     * it throws an exception.
     *
     * @param int $episodeId The ID of the episode to retrieve.
     * @return Episode The Episode object corresponding to the specified ID.
     */
    public static function findById(int $episodeId): Episode
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
    SELECT id, seasonId, name, overview, episodeNumber
    FROM episode
    WHERE id = {$episodeId}
    SQL
        );
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Episode::class);
        $result = $request->fetch();
        if (empty($result)) {
            throw new EntityNotFoundException('Episode', $episodeId);
        }
        return $result;
    }


}