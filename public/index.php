<?php

declare(strict_types=1);
use Html\AppWebPage;
use Entity\Collection\TVShowCollection;
use Html\StringEscaper;
use Entity\TVShow;

$webPage = new AppWebPage("Séries TV");

$shows = TVShowCollection::findAll();

$webPage->appendContent("<ul class='list'>");
foreach ($shows as $show) {
    $webPage->appendContent(
        <<<HTML
        
                        <li class="show">
                            <a href=tvshow.php?showId={$show->getId()}>
                                <img class="show__poster" src="poster.php?posterId={$show->getPosterId()}" alt="Poster de {$show->getName()}">
                                <div class="show__info">
                                    <span class="show__name">{$webPage->escapeString($show->getName())}</span>
                                    <span class="show__desc">{$webPage->escapeString($show->getOverview())}</span>
                                </div>
                            </a>
                        </li>
        HTML);
}
$webPage->appendContent("\n\t\t\t</ul>");

echo $webPage->toHTML();

