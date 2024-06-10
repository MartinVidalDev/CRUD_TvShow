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


}
