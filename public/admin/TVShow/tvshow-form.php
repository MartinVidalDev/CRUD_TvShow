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
    $webPage = new \Html\AppWebPage("Modifier");
    $webPage->appendCSSUrl("/css/style-form.css");
    $form = new TVShowForm($tvShow);
    $webPage->appendContent($form->getHtmlForm('tvshow-save.php'));

    // Adding a button to either delete the Show or cancel the creation
    if (isset($_GET['showId'])) {
        $webPage->appendContent(
            <<<HTML

    <form class="cancel-form" action="/tvshow.php" method="get" onsubmit="return confirm('Voulez-vous vraiment annuler la modification de série ?');">
        <input type="hidden" name="showId" value="{$showId}" />
        <div class="form__group">
            <button type="submit">Annuler</button>
        </div>
    </form>

    <form class="delete-form" action="tvshow-delete.php" method="get" onsubmit="return confirm('Voulez-vous vraiment supprimer cette série ?');">
        <input type="hidden" name="showId" value="{$showId}" />
        <div class="form__group">
            <button class="delete" type="submit">Supprimer</button>
        </div>
    </form>

    HTML
        );
    } else {
        $webPage->appendContent(
            <<<HTML
        <div class="form"
            <form class="cancel-form" action="../../index.php" method="get" onsubmit="return confirm('Voulez-vous vraiment annuler la création de série ?');">
                <div class="form__group">
                    <button class="cancel" type="submit">Annuler</button>
                </div>
            </form>
        </div>
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
