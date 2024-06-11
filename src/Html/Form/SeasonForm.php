<?php

namespace Html\Form;

use Entity\Exception\ParameterException;
use Html\StringEscaper;
use Entity\Season;

class SeasonForm
{
    use StringEscaper;
    private ?Season $season;

    public function construct(?Season $season = null)
    {
        $this->season = $season;
    }

    public function getSeason()
    {
        return clone($this->season);
    }

    /**
     * Generates an HTML form for a Season object.
     *
     * @param string $action The URL where the form data will be sent when the form is submitted.
     * @return string The generated HTML form as a string.
     */
    public function getHtmlForm(string $action): string
    {
        $season = $this->getSeason();
        $seasonName = $season?->getName();
        $seasonNumber = $season?->getSeasonNumber();
        $seasonPosterId = $season?->getPosterId();

        if ($seasonName) {
            $seasonName = $this->escapeString($seasonName);
        }

        $form = <<<HTML
    <form method="post" action={$action}>
        <input type="hidden" name="id" value="{$season?->getId()}" />
        <input type="hidden" name="tvShowId" value="{$season?->getTvShowId()}" />
        <label>Name
            <input type="text" name="name" value="{$seasonName}" required />
        </label>
        <label>Season Number
            <input type="number" name="seasonNumber" value="{$seasonNumber}" required />
        </label>
        <label>Poster ID
            <input type="number" name="posterId" value="{$seasonPosterId}"/>
        </label>
        <button type="submit" value="submit">Save</button>
    </form>
HTML;
        return $form;
    }

}
