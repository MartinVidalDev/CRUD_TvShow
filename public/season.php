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

$webPage = new AppWebpage("{$show->getName()}");

$episodes = EpisodeCollection::findBySeasonId($season->getId());

$episodeList = '';
foreach ($episodes as $episode) {
    $name = $webPage->escapeString("{$episode->getName()}");
    $episodeList .= <<<HTML
        <div class='episode'>
            <div class="episode__name">
                <h4>{$episode->getEpisodeNumber()} - {$name}</h4>
            </div>
            <span class="episode__description">{$episode->getOverview()}</span>
        </div>
    HTML;
}

$webPage->appendContent(<<<HTML
<div class='season'>
        <img class='season__poster' alt='{$season->getName()}' src='poster.php?posterId={$season->getPosterId()}'>
        <div class='season__info'>
        <a class="link season__show__name" href="tvshow.php?showId={$show->getId()}">
            <h2>{$show->getName()}</h2>
        </a>
        <span class="season__season__name"><h3>{$season->getName()}</h3></span>
        </div>
</div>
<div class='episode__list'>
    {$episodeList}
</div>
HTML);

echo $webPage->toHTML();
