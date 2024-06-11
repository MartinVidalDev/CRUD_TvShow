<?php

declare(strict_types=1);
namespace Html\Form;
use Entity\Episode;
use Html\StringEscaper;
use Entity\Exception\ParameterException;

class EpisodeForm
{
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




}