<?php

declare(strict_types=1);

use Entity\TVShow;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\Form\TVShowForm;

try {
    // Check and validate the GET parameter showId
    $showId = null;
    if (isset($_GET['showId'])) {
        if (!ctype_digit($_GET['showId'])) {
            throw new ParameterException("The TV show ID is not valid");
        }
        $showId = (int)$_GET['showId'];
    }

    // Search for the TV show in the database if the ID is provided
    $tvShow = null;
    if ($showId !== null) {
        $tvShow = TVShow::findById($showId);
    }

    // Build an instance of TVShowForm
    $webPage = new \Html\AppWebPage("Insert");
    $form = new TVShowForm($tvShow);
    $webPage->appendContent($form->getHtmlForm('tvshow-save.php'));
    echo $webPage->toHTML();

} catch (ParameterException $e) {
    http_response_code(400);
    echo "Error: " . $e->getMessage();
    exit();
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    echo "Error: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
    exit();
}