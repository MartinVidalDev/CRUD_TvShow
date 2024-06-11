<?php

declare(strict_types=1);

use Entity\Season;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\Form\SeasonForm;

try {
    // Check and validate the GET parameter seasonId
    $seasonId = null;
    if (isset($_GET['seasonId'])) {
        if (!ctype_digit($_GET['seasonId'])) {
            throw new ParameterException("The season ID is not valid");
        }
        $seasonId = (int)$_GET['seasonId'];
    }

    // Search for the season in the database if the ID is provided
    $season = null;
    if ($seasonId !== null) {
        $season = Season::findById($seasonId);
    }

    // Build an instance of SeasonForm
    $webPage = new \Html\AppWebPage("Insert");
    $form = new SeasonForm($season);
    $webPage->appendContent($form->getHtmlForm('season-save.php'));

    // Adding a button to either delete the season or cancel the creation
    if (isset($_GET['seasonId'])) {
        $webPage->appendContent(
            <<<HTML

    <form class="cancel-form" action="season.php" method="get" onsubmit="return confirm('Voulez-vous vraiment annuler la modification de la saison ?');">
        <input type="hidden" name="seasonId" value="{$seasonId}" />
        <button type="submit">Annuler</button>
    </form>

    <form class="delete-form" action="season-delete.php" method="get" onsubmit="return confirm('Voulez-vous vraiment supprimer cette saison ?');">
        <input type="hidden" name="seasonId" value="{$seasonId}" />
        <button class="delete" type="submit">Supprimer</button>
    </form>

HTML
        );
    } else {
        $webPage->appendContent(
            <<<HTML

    <form class="cancel-form" action="../../index.php" method="get" onsubmit="return confirm('Voulez-vous vraiment annuler la création de la saison ?');">
        <button class="cancel" type="submit">Annuler</button>
    </form>
HTML
        );
    }

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
