<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Season;
use PDO;

class SeasonCollection
{
    /**
     * Retrieves all seasons from the database.
     *
     * This static method executes a SQL query to select all columns from the `season` table,
     * ordered by the name of the season. It returns the results as an array of `Season` objects.
     *
     * @param int $showId the ID of the show the season is from
     *
     * @return Season[] An array of Season objects.
     */
    public static function findByShowId(int $showId): array
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, tvShow, name, seasonNumber, posterId
        FROM season
        WHERE tvShow = :showId
        ORDER BY seasonNumber
        SQL
        );
        $request->execute(['showId' => $showId]);
        $request->setFetchMode(PDO::FETCH_CLASS, Season::class);
        return $request->fetchAll();
    }
}
