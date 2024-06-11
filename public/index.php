<?php

declare(strict_types=1);
use Html\AppWebPage;
use Entity\Collection\TVShowCollection;
use Html\StringEscaper;
use Entity\TVShow;

$webPage = new AppWebPage("Séries TV");

$shows = TVShowCollection::findAll();

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
