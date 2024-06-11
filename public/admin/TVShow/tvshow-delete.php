<?php

declare(strict_types=1);

namespace Public\Admin;

use Entity\TVShow;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\Form\TVShowForm;

try {
    $showId = null;
    if (!isset($_GET['showId'])) {
        throw new ParameterException("The TV show ID is required");
    }
    if (!ctype_digit($_GET['showId'])) {
        throw new ParameterException("The TV show ID is not valid");
    }

    $showId = (int)$_GET['showId'];
    $tvShow = TVShow::findById($showId);
    $tvShow->delete();
    header("Location: ../../index.php");

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
}