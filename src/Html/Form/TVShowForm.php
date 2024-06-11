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
            <input type="text" name="posterId" value="{$tvShowPosterId}" required />
        </label>
        <button type="submit" value="submit">Save</button>
    </form>
HTML;
        return $form;
    }


}