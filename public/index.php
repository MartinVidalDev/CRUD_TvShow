<?php

declare(strict_types=1);
use Entity\Collection\TVShowCollection;
use Html\AppWebPage;
use Entity\Genre;

$webPage = new AppWebPage("Séries TV");
$webPage->setNavLinks(["Home" => "/index.php", "Ajouter une série" => "/admin/TVShow/tvshow-form.php"]);

$genres = Genre::findAll();

// Genres dropdown
$webPage->appendContent(<<<HTML
<form method="get">
    <select name="genreId" onchange="this.form.submit()">
        <option value="">Tous</option>
HTML);

$currentGenreId = $_GET['genreId'] ?? '';

foreach ($genres as $genre) {
    $selected = $genre->getId() == $currentGenreId ? 'selected' : '';
    $webPage->appendContent(<<<HTML
        <option value="{$genre->getId()}" {$selected}>{$genre->getName()}</option>
HTML);
}

$webPage->appendContent(<<<HTML
    </select>
</form>
HTML);

if (isset($_GET['genreId']) && is_numeric($_GET['genreId'])) {
    // Display shows by genre
    $genreId = (int)$_GET['genreId'];
    $shows = TVShowCollection::findByGenre($genreId);
    $webPage->setTitle($genre->getName());
} else {
    // Display all shows
    $shows = TVShowCollection::findAll();
}

// Shows
foreach ($shows as $show) {
    $webPage->appendContent(
        <<<HTML
                        <div class="show">
                            <a class="link" href=tvshow.php?showId={$show->getId()}>
                                <img class="show__poster" src="poster.php?posterId={$show->getPosterId()}" alt="Poster de {$show->getName()}">
                                <div class="show__info">
                                    <span class="show__name"><h3>{$webPage->escapeString($show->getName())}</h3></span>
                                    <span class="show__desc">{$webPage->escapeString($show->getOverview())}</span>
                                </div>
                            </a>
                        </div>

        HTML
    );
}

echo $webPage->toHTML();