<?php

namespace Html\Form;
use Entity\Exception\ParameterException;
use Html\StringEscaper;
use Entity\Season;
class SeasonForm
{
    private ?Season $season;

    public function construct(?Season $season=null)
    {
        $this->season = $season;
    }

    public function getSeason() {
        return clone($this->season);
    }


}