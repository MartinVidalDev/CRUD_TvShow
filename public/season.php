<?php

declare(strict_types=1);
use Entity\Season;
use Entity\TVShow;
use Entity\Collection\EpisodeCollection;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

if (!(isset($_GET['seasonId'])) or !is_numeric($_GET['seasonId'])) {
    header('Location: index.php');
    exit;
}

$seasonId = (int)$_GET['seasonId'];

try {
    $season = Season::findById($seasonId);
    $show = TVShow::findById($season->getTvShowId());
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit;
}

$webPage = new AppWebpage("{$show->getName()} - {$season->getName()}");

$episodes = EpisodeCollection::findBySeasonId($season->getId());

$episodeList = '';
foreach ($episodes as $episode) {
    $name = $webPage->escapeString("{$episode->getName()}");
    $episodeList .= <<<HTML
        <li class='episode'>
            <span class='episode__name'>{$name}</span>
        </li>
    HTML;
}

$webPage->appendContent(<<<HTML
<div class='season'>
    <a href="tvshow.php?showId={$show->getId()}">
        <img class='season__poster' alt='{$season->getName()}' src='poster.php?posterId={$season->getPosterId()}'>
        <span class="show__name">{$show->getName()}</span>
        <span class="season__name">{$season->getName()}</span>
    </a>
</div>
<ul class='list'>
    {$episodeList}
</ul>
HTML);

echo $webPage->toHTML();