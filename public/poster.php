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

    $poster = Poster::findById((int)$_GET['posterId']);

    header('Content-Type: image/png');
    echo $poster->getJpeg();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    header("Content-Type: image/png");
    echo $poster;
} catch (Exception) {
    http_response_code(500);
}
