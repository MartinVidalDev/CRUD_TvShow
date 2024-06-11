<?php

declare(strict_types=1);
use Entity\Collection\TVShowCollection;
use Html\AppWebPage;
use Entity\Genre;

if (!(isset($_GET['genreId'])) or !is_numeric($_GET['genreId'])) {
    header('Location: index.php');
    exit;
}

$genreId = (int)$_GET['genreId'];
$genre = Genre::findById($genreId);

$shows = TVShowCollection::findByGenre($genreId);
$webPage = new AppWebPage($genre->getName());

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
