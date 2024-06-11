<?php

namespace Entity;
use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class TVShow
{
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    private int $posterId;

    private function __construct()
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

    public function getPosterId(): int
    {
        return $this->posterId;
    }

    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getHomepage(): string
    {
        return $this->homepage;
    }

    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }


    /**
     * Find a show with its ID
     * @param int $id
     * @return self|null
     */
    public static function findById(int $id): self
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                WHERE id = :id
            SQL);

        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $artist = $stmt->fetch();

        if (!$artist) {
            throw new EntityNotFoundException('Artist', $id);
        }

        return $artist;
    }

    /**
     * Deletes the current object from the Database (TVShow)
     * and set its identifier to null.
     *
     * @return TVShow Returns the current instance
     */
    public function delete(): TVShow
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
    DELETE FROM tvshow
    WHERE id = :id
SQL
        );
        $request->execute(['id' => $this->id]);
        $this->setId(null);
        return $this;
    }

    /**
     * Updates the current object (TVShow) in the "TVShow" table.
     *
     * @return TVShow Returns the current object
     */
    protected function update(): TVShow
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
    UPDATE tvshow
    SET name = :name, originalName = :originalName, homepage = :homepage, overview = :overview, posterId = :posterId
    WHERE id = :id
SQL
        );
        $request->execute([
            'name' => $this->name,
            'originalName' => $this->originalName,
            'homepage' => $this->homepage,
            'overview' => $this->overview,
            'posterId' => $this->posterId,
            'id' => $this->id
        ]);
        return $this;
    }

    /**
     * Allows inserting a new TVShow into the "TVShow" table.
     * The new id is auto-incremented.
     *
     * @return TVShow Returns the current instance
     */

    protected function insert(): TVShow
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
    INSERT INTO tvshow (name, originalName, homepage, overview, posterId) 
    VALUES (:name, :originalName, :homepage, :overview, :posterId)
SQL
        );
        $request->execute([
            'name' => $this->name,
            'originalName' => $this->originalName,
            'homepage' => $this->homepage,
            'overview' => $this->overview,
            'posterId' => $this->posterId
        ]);
        $this->setId((int) MyPdo::getInstance()->lastInsertId());
        return $this;
    }

    /**
     * Allows either inserting a new TVShow with the insert() method (id is null)
     * or updating the TVShow if its identifier already exists in the "TVShow" table.
     *
     * @return TVShow Returns the current instance
     */
    public function save(): TVShow
    {
        if ($this->id == null) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }

    /**
     * Creates a new instance of TVShow
     *
     * @param string $name Name of the new TVShow
     * @param string $originalName Original name of the new TVShow
     * @param string $homepage Homepage of the new TVShow
     * @param string $overview Overview of the new TVShow
     * @param int $posterId Poster ID of the new TVShow
     * @param ?int $id Identifier of the new TVShow
     *
     * @return TVShow Returns the current object
     */
    public static function create(string $name, string $originalName, string $homepage, string $overview, int $posterId, ?int $id = null): TVShow
    {
        $tvShow = new TVShow();
        $tvShow->setName($name);
        $tvShow->setOriginalName($originalName);
        $tvShow->setHomepage($homepage);
        $tvShow->setOverview($overview);
        $tvShow->setPosterId($posterId);
        $tvShow->setId($id);
        return $tvShow;
    }


}