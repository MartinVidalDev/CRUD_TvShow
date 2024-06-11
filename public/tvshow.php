<?php

declare(strict_types=1);
use Entity\TVShow;
use Entity\Collection\SeasonCollection;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

if (!(isset($_GET['showId'])) or !is_numeric($_GET['showId'])) {
    header('Location: index.php');
    exit;
}

$showId = (int)$_GET['showId'];

try {
    $show = TVShow::findById($showId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit;
}

$webPage = new AppWebpage("{$show->getName()}");

$seasons = SeasonCollection::findByShowId($showId);

$seasonList = '';
foreach ($seasons as $season) {
    $posterId = (int)$webPage->escapeString("{$season->getPosterId()}");
    $name = $webPage->escapeString("{$season->getName()}");
    $seasonList .= <<<HTML
        <div class='season'>
            <a class="link__season" href="season.php?seasonId={$season->getId()}">
                <img class='season__poster' alt='{$name}' src='poster.php?posterId={$posterId}'>
                <span class='season__name'><h3>{$name}</h3></span>
            </a>
        </div>
    HTML;
}

$webPage->appendContent(<<<HTML
<div class='tvshow'">
        <img class='tvshow__poster' alt='{$show->getName()}' src='poster.php?posterId={$show->getPosterId()}' >
        <div class='tvshow__info'>
            <span class='tvshow__name tvshow__title'><h2>{$show->getName()}</h2></span>
            <span class='tvshow__originalName tvshow__title'><h4>{$show->getOriginalName()}</h4></span>
            <span class='tvshow__overview'>{$show->getOverview()}</span>
        </div>
</div>
    <div class='list__season'>
    {$seasonList}
    </div>
HTML
);

echo $webPage->toHTML();
