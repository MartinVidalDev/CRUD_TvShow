<?php

namespace Entity\Collection;
use Entity\Exception\EntityNotFoundException;
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


    public static function findByGenre(int $genreId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT tvshow.*
                FROM tvshow
                INNER JOIN tvshow_genre ON tvshow.id = tvshow_genre.tvshowid
                INNER JOIN genre ON genre.id = tvshow_genre.genreid
                WHERE genre.id = :genre
            SQL);

        $stmt->execute(['genre' => $genreId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $tvShows = $stmt->fetchAll();

        if (!$tvShows) {
            throw new EntityNotFoundException('TV Show', $genreId);
        }

        return $tvShows;
    }



}