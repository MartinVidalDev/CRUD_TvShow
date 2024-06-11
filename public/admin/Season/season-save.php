<?php

declare(strict_types=1);

use Entity\Season;
use Entity\Exception\ParameterException;
use Html\Form\SeasonForm;

try {
    // Create the form to handle the submission
    $form = new SeasonForm();
    $form->setEntityFromQueryString();

    // Save the TV show
    $season = $form->getSeason();
    $season?->save();

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