<?php

declare(strict_types=1);
use Html\AppWebPage;

$webPage = new AppWebPage("Séries TV");

echo $webPage->toHTML();

