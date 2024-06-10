<?php

namespace Entity\Collection;
use Entity\TVShow;
use PDO;
use Database\MyPdo;

class TVShowCollection
{
    /**
     * Find all artists
     *
     * @return TVShow[]
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT id, name, originalName, homepage, overview, posterId
        FROM tvshow
        ORDER BY name
    SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, TVShow::class);
    }

}