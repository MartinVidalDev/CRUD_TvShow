<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Season
{
    private ?int $id;
    private int $tvShowId;
    private string $name;
    private int $seasonNumber;
    private int $posterId;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(?int $id): void
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

    /**
     * Deletes the current object from the Database (Season)
     * and set its identifier to null.
     *
     * @return Season Returns the current instance
     */
    public function delete(): Season
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
    DELETE FROM season
    WHERE id = :id
SQL
        );
        $request->execute(['id' => $this->id]);
        $this->setId(null);
        return $this;
    }

    /**
     * Updates the current object (Season) in the "Season" table.
     *
     * @return Season Returns the current object
     */
    protected function update(): Season
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
    UPDATE season
    SET tvShowId = :tvShowId, name = :name, seasonNumber = :seasonNumber, posterId = :posterId
    WHERE id = :id
SQL
        );
        $request->execute([
            'tvShowId' => $this->tvShowId,
            'name' => $this->name,
            'seasonNumber' => $this->seasonNumber,
            'posterId' => $this->posterId,
            'id' => $this->id
        ]);
        return $this;
    }

    /**
     * Allows inserting a new Season into the "Season" table.
     * The new id is auto-incremented.
     *
     * @return Season Returns the current instance
     */
    protected function insert(): Season
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
    INSERT INTO season (tvShowId, name, seasonNumber, posterId) 
    VALUES (:tvShowId, :name, :seasonNumber, :posterId)
SQL
        );
        $request->execute([
            'tvShowId' => $this->tvShowId,
            'name' => $this->name,
            'seasonNumber' => $this->seasonNumber,
            'posterId' => $this->posterId
        ]);
        $this->setId((int) MyPdo::getInstance()->lastInsertId());
        return $this;
    }

    /**
     * Allows either inserting a new Season with the insert() method (id is null)
     * or updating the Season if its identifier already exists in the "Season" table.
     *
     * @return Season Returns the current instance
     */
    public function save(): Season
    {
        if ($this->id == null) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }

    /**
     * Creates a new instance of Season
     *
     * @param int $tvShowId TV Show ID of the new Season
     * @param string $name Name of the new Season
     * @param int $seasonNumber Season number of the new Season
     * @param int $posterId Poster ID of the new Season
     * @param ?int $id Identifier of the new Season
     *
     * @return Season Returns the current object
     */
    public static function create(int $tvShowId, string $name, int $seasonNumber, int $posterId, ?int $id = null): Season
    {
        $season = new Season();
        $season->setTvShowId($tvShowId);
        $season->setName($name);
        $season->setSeasonNumber($seasonNumber);
        $season->setPosterId($posterId);
        $season->setId($id);
        return $season;
    }

}
