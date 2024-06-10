<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    /**
     * Retrieves all episodes from the database.
     *
     * This static method executes a SQL query to select all columns from the `season` table,
     * ordered by the name of the episode. It returns the results as an array of `Episode` objects.
     *
     * @return Episode[] An array of Episode objects.
     */
    public static function findAll(): array
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, seasonId, name, overview, episodeNumber
        FROM episode
        ORDER BY episodeNumber;
        SQL
        );
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Episode::class);
        return $request->fetchAll();
    }
}