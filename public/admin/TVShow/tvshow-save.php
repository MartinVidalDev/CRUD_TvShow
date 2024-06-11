<?php

declare(strict_types=1);

use Entity\TVShow;
use Entity\Exception\ParameterException;
use Html\Form\TVShowForm;

try {
    // Create the form to handle the submission
    $form = new TVShowForm();
    $form->setEntityFromQueryString();

    // Save the TV show
    $tvShow = $form->getTVShow();
    $tvShow?->save();

    // Redirect after success
    header("Location: ../../index.php");
    exit();

} catch (ParameterException $e) {
    http_response_code(400);
    echo "Error: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
    exit();
}