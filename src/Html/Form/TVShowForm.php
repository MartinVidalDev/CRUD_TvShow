<?php

declare(strict_types=1);
namespace Html\Form;
use Entity\Exception\ParameterException;
use Html\StringEscaper;
use Entity\TVShow;

class TVShowForm
{
    private ?TVShow $tvshow;

    public function construct(?TVShow $tvshow=null)
    {
        $this->tvshow = $tvshow;
    }

    public function getTVShow() {
        return clone($this->tvshow);
    }


}