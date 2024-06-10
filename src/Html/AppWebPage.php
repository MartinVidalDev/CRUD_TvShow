<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    private string $menu;
    private string $logo;
    private string $author;
    private string $header;

    /**
     * Constructor for the AppWebPage class.
     *
     * @param string $title The title of the web page.
     * @param string $logo The URL of the logo image (default is an empty string).
     * @param string $author The author of the web page (default is 'VIDAL&ARIDORY').
     * @param string $header The content for the header section (default is an empty string).
     */
    public function __construct(string $title, string $logo = 'image/icon-site.png', string $author = 'VIDAL&ARIDORY', string $header = '')
    {
        parent::__construct($title);
        $this->menu = '';
        $this->logo = $logo;
        $this->author = $author;
        $this->header = $header;
    }

    /**
     * Gets the author of the web page.
     *
     * @return string The author of the web page.
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Sets the author of the web page.
     *
     * @param string $author The new author.
     * @return AppWebPage The current instance for method chaining.
     */
    public function setAuthor(string $author): AppWebPage
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Sets the URL of the logo image.
     *
     * @param string $logoUrl The URL of the logo image.
     * @return void
     */
    public function setLogoUrl(string $logoUrl): void
    {
        $this->logo = $logoUrl;
    }

    /**
     * Gets the URL of the logo image.
     *
     * @return string The URL of the logo image.
     */
    public function getLogoUrl(): string
    {
        return $this->logo;
    }

    /**
     * Gets the menu content.
     *
     * @return string The menu content.
     */
    public function getMenu(): string
    {
        return $this->menu;
    }

    /**
     * Appends content to the menu.
     *
     * @param string $content The content to append.
     * @return void
     */
    public function appendToMenu(string $content): void
    {
        $this->menu .= <<<HTML
        <div class="menu">
                $content
        </div>
HTML;
    }

    /**
     * Gets the header content.
     *
     * @return string The header content.
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * Generates the complete HTML for the web page.
     *
     * @return string The HTML of the web page.
     * @throws \Exception
     */
    public function toHTML(): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="author" content="{$this->getAuthor()}">
        <link rel="icon" href="{$this->getLogoUrl()}" type="image/png">
        <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="/css/style.css">
        {$this->getHead()}
        <title>{$this->getTitle()}</title>
    </head>
    <body>
        <header class="header">
            {$this->getHeader()}
            <h1>{$this->getTitle()}</h1>
        </header>
        <main class="content">
            {$this->getMenu()}
            {$this->getBody()}
        </main>
        <footer class="footer">{$this->getLastModification()}</footer>
    </body>
</html>
HTML;
    }
}
