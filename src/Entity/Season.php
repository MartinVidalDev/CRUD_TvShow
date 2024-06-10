<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

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

    /**
     * Retrieves a season by its ID from the database.
     *
     * This static method executes a SQL query to select all columns from the `season` table
     * for a given season ID. It returns the result as a `Season` object if found, otherwise
     * it throws an exception.
     *
     * @param int $seasonId The ID of the season to retrieve.
     * @return Season The Season object corresponding to the specified ID.
     */
    public static function findById(int $seasonId): Season
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, tvShowId, name, seasonNumber, posterId
        FROM season
        WHERE id = :seasonId
        SQL
        );
        $request->execute(['seasonId' => $seasonId]);
        $request->setFetchMode(PDO::FETCH_CLASS, Season::class);
        $result = $request->fetch();
        if (empty($result)) {
            throw new EntityNotFoundException('Season', $seasonId);
        }
        return $result;
    }
}
