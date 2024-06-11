<?php

declare(strict_types=1);
namespace Html\Form;
use Entity\Exception\ParameterException;
use Html\StringEscaper;
use Entity\TVShow;

class TVShowForm
{
    private ?TVShow $tvshow;

    use StringEscaper;

    public function construct(?TVShow $tvshow=null)
    {
        $this->tvshow = $tvshow;
    }

    public function getTVShow() {
        return clone($this->tvshow);
    }

    /**
     * Generates an HTML form for a TVShow object.
     *
     * @param string $action The URL where the form data will be sent when the form is submitted.
     * @return string The generated HTML form as a string.
     */
    public function getHtmlForm(string $action): string
    {
        $tvShow = $this->getTVShow();
        $tvShowName = $tvShow?->getName();
        $tvShowOriginalName = $tvShow?->getOriginalName();
        $tvShowHomepage = $tvShow?->getHomepage();
        $tvShowOverview = $tvShow?->getOverview();
        $tvShowPosterId = $tvShow?->getPosterId();

        if ($tvShowName) {
            $tvShowName = $this->escapeString($tvShowName);
        }
        if ($tvShowOriginalName) {
            $tvShowOriginalName = $this->escapeString($tvShowOriginalName);
        }
        if ($tvShowHomepage) {
            $tvShowHomepage = $this->escapeString($tvShowHomepage);
        }
        if ($tvShowOverview) {
            $tvShowOverview = $this->escapeString($tvShowOverview);
        }

        $form = <<<HTML
    <form method="post" action={$action}>
        <input type="hidden" name="id" value="{$tvShow?->getId()}" />
        <label>Name
            <input type="text" name="name" value="{$tvShowName}" required />
        </label>
        <label>Original Name
            <input type="text" name="originalName" value="{$tvShowOriginalName}" required />
        </label>
        <label>Homepage
            <input type="text" name="homepage" value="{$tvShowHomepage}" required />
        </label>
        <label>Overview
            <input type="text" name="overview" value="{$tvShowOverview}" required />
        </label>
        <label>Poster ID
            <input type="text" name="posterId" value="{$tvShowPosterId}"/>
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
        $tvShowId = null;
        if (isset($_POST['id']) && ctype_digit($_POST['id'])) {
            $tvShowId = (int)$_POST['id'];
        }

        if (empty($_POST['name'])) {
            throw new ParameterException("Nom de la série manquant");
        }
        if (empty($_POST['originalName'])) {
            throw new ParameterException("Nom original de la série manquant");
        }
        if (empty($_POST['homepage'])) {
            throw new ParameterException("Page d'accueil de la série manquante");
        }
        if (empty($_POST['overview'])) {
            throw new ParameterException("Aperçu de la série manquant");
        }


        $tvShowName = $this->stripTagsAndTrim($_POST['name']);
        $tvShowOriginalName = $this->stripTagsAndTrim($_POST['originalName']);
        $tvShowHomepage = $this->stripTagsAndTrim($_POST['homepage']);
        $tvShowOverview = $this->stripTagsAndTrim($_POST['overview']);
        $tvShowPosterId = isset($_POST['posterId']) ? (int)$_POST['posterId'] : null;

        $this->tvshow = TVShow::create($tvShowName, $tvShowOriginalName, $tvShowHomepage, $tvShowOverview, $tvShowPosterId, $tvShowId);
    }

}