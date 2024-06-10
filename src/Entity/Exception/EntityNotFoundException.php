<?php

declare(strict_types=1);

namespace Entity\Exception;

use OutOfBoundsException;

class EntityNotFoundException extends \OutOfBoundsException
{
    public function __construct(string $entity, int $id)
    {
        parent::__construct("{$entity} with ID {$id} not found");
    }
}
