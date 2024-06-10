<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;
    private string $jpeg;

    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public static function findById(int $id): self
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, jpeg
            FROM poster
            WHERE id = :id
            SQL
        );
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $poster = $stmt->fetch();

        if (!$poster) {
            throw new EntityNotFoundException('Poster', $id);
        }

        return $poster;

    }


}
