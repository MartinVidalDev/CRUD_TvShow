<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Episode;
use Html\StringEscaper;
use Entity\Exception\ParameterException;

class EpisodeForm
{
    use StringEscaper;
    private ?Episode $episode;

    /**
     * @param Episode|null $episode
     */
    public function __construct(?Episode $episode = null)
    {
        $this->episode = $episode;
    }

    public function getEpisode(): ?Episode
    {
        return $this->episode;
    }


    /**
     * Generates an HTML form for an Episode object.
     *
     * @param string $action The URL where the form data will be sent when the form is submitted.
     * @param int $season The seasonNumber of the Episode
     * @return string The generated HTML form as a string.
     */
    public function getHtmlForm(string $action, int $season): string
    {
        $episode = $this->getEpisode();
        $episodeName = $this->escapeString($episode->getName());
        $episodeNumber = $episode?->getEpisodeNumber();
        $episodeOverview = $this->escapeString($episode?->getOverview());


        $form = <<<HTML
<form method="post" action={$action}>
    <input type="hidden" name="id" value="{$episode?->getId()}" />
    <input type="hidden" name="seasonId" value="$season" />
    <label>Name
        <input type="text" name="name" value="{$episodeName}" required />
    </label>
    <label>Episode Number
        <input type="number" name="episodeNumber" value="{$episodeNumber}" required />
    </label>
    <label>Poster ID
        <input type="text" name="posterId" value="{$episodeOverview}"/>
    </label>
    <button type="submit" value="submit">Save</button>
</form>
HTML;
        return $form;
    }



}
