<?php

declare(strict_types=1);

namespace Public\Admin;

use Entity\TVShow;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\Form\TVShowForm;

try {
    $showId = null;
    if (!isset($_GET['seasonId'])) {
        throw new ParameterException("ID de la saison requis");
    }
    if (!ctype_digit($_GET['seasonId'])) {
        throw new ParameterException("ID de la saison invalide");
    }

    $seasonId = (int)$_GET['seasonId'];
    $season = TVShow::findById($seasonId);
    $season->delete();
    header("Location: ../../index.php");

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
}