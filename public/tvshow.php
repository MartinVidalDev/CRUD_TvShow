<?php

declare(strict_types=1);
use Entity\TVShow;
use Entity\Collection\SeasonCollection;
use Entity\Exception\EntityNotFoundException;

if (!(isset($_GET['showId'])) or !is_numeric($_GET['showId'])) {
    header('Location: index.php');
    exit;
}

$showId = (int)$_GET['showId'];

try {
    $show = TVShow::findById($showId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit;
}
