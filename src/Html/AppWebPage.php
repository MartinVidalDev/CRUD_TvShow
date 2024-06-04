<?php

declare(strict_types=1);

namespace Html;

use Html\Webpage;

class AppWebPage extends WebPage
{
    public function __construct($title = "")
    {
        parent::__construct($title);
        parent::appendCSSUrl('css/style.css');
    }

    public function toHTML($lang = "en"): string
    {

        return <<<HTML
        <!DOCTYPE html>
        <html lang='{$lang}'>
            <head>
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                <header class="header">
                    <h1>{$this->getTitle()}</h1>
                </header>
                <div class="content">
                    {$this->getBody()}
                </div>
            </body>
            <footer class="footer">
                Dernière modification : {$this->getLastModification()}
            </footer>
        </html>
        HTML;
    }
}
