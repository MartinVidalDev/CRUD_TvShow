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
        <li class='season'>
            <a href="season.php?seasonId={$season->getId()}">
                <img class='season__poster' alt='{$name}' src='poster.php?posterId={$posterId}'>
                <span class='season__name'>{$name}</span>
            </a>
        </li>
    HTML;
}

$webPage->appendContent(<<<HTML
<div class='tvshow'>
        <img class='tvshow__poster' alt='{$show->getName()}' src='poster.php?posterId={$show->getPosterId()}' >
        <div class='tvshow__info'>
            <span class='tvshow__name'>{$show->getName()}</span>
            <span class='tvshow__originalName'>{$show->getOriginalName()}</span>
            <span class='tvshow__overview'>{$show->getOverview()}</span>
        </div>
</div>
    <ul class='list'>
    {$seasonList}
    </ul>
HTML);

echo $webPage->toHTML();