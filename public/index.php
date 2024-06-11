<?php

declare(strict_types=1);
use Html\AppWebPage;
use Entity\Collection\TVShowCollection;
use Html\StringEscaper;
use Entity\TVShow;
use Entity\Genre;

$webPage = new AppWebPage("Séries TV");
$webPage->setNavLinks(["Home" => "/index.php", "Ajouter une série" => "/admin/TVShow/tvshow-form.php"]);

$shows = TVShowCollection::findAll();
$genres = Genre::findAll();

// Genres

$webPage->appendContent(<<<HTML
<form method="get" action="genre.php">
    <select name="genreId" onchange="this.form.submit()">
HTML);

foreach ($genres as $genre) {
    $webPage->appendContent(<<<HTML
        <option value="{$genre->getId()}">{$genre->getName()}</option>
HTML);
}

$webPage->appendContent(<<<HTML
    </select>
</form>
HTML);

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
