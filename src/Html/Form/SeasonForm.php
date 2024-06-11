<?php

declare(strict_types=1);
namespace Html\Form;
use Entity\Exception\ParameterException;
use Html\StringEscaper;
use Entity\Season;

class SeasonForm
{
    use StringEscaper;
    private ?Season $season;

    public function __construct(?Season $season = null)
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
        $seasonName = $this->escapeString($season?->getName());
        $seasonNumber = $season?->getSeasonNumber();
        $seasonPosterId = $season?->getPosterId();


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
        <button type="submit" value="submit">Save</button>
    </form>
HTML;
        return $form;
    }

    /**
     * Method that controls the data transmitted by the form in order to not corrupt the database.
     *
     * @throws ParameterException If any of the required fields in the $_POST array are empty
     * @return void Does not return anything
     */
    public function setEntityFromQueryString(): void
    {
        $seasonId = null;
        if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $seasonId = (int)$_POST['id'];
        }

        if (empty($_POST['tvShowId'])) {
            throw new ParameterException("TV Show ID is missing");
        }
        if (empty($_POST['name'])) {
            throw new ParameterException("Season name is missing");
        }
        if (empty($_POST['seasonNumber'])) {
            throw new ParameterException("Season number is missing");
        }

        $seasonTvShowId = (int)$_POST['tvShowId'];
        $seasonName = $this->stripTagsAndTrim($_POST['name']);
        $seasonNumber = (int)$_POST['seasonNumber'];

        $this->season = Season::create($seasonTvShowId, $seasonName, $seasonNumber, null, $seasonId);
    }
}
