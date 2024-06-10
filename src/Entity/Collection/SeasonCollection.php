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
     * @return Season[] An array of Season objects.
     */
    public static function findAllSeason(): array
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, tvShow, name, seasonNumber, posterId
        FROM season
        ORDER BY name
        SQL
        );
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Season::class);
        return $request->fetchAll();
    }
}
