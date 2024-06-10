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
        
                        <li><a href=tvshow.php?showId={$show->getId()}>{$webPage->escapeString($show->getName())}</a></li>
        HTML);
}
$webPage->appendContent("\n\t\t\t</ul>");

echo $webPage->toHTML();

