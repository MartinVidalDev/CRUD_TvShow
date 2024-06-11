<?php

declare(strict_types=1);

use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    $poster = file_get_contents('image/default-poster.png');
    if (!isset($_GET['posterId']) || !ctype_digit($_GET['posterId'])) {
        throw new ParameterException();
    }

    $posterEntity = Poster::findById((int)$_GET['posterId']);

    header('Content-Type: image/jpeg');
    echo $posterEntity->getJpeg();

} catch (ParameterException | EntityNotFoundException $e) {
    header('Content-Type: image/png');
    echo $poster;
} catch (Exception $e) {
    http_response_code(500);
}
