<?php

declare(strict_types=1);

namespace Html;

/**
 * Class AppWebPage
 *
 * Represents a web page with additional functionality for handling
 * menus, logos, authors, headers, and navigation links.
 */
class AppWebPage extends WebPage
{
    private string $menu;
    private string $logo;
    private string $author;
    private string $header;
    private array $navLinks;

    /**
     * Retrieves the navigation links.
     *
     * @return array The navigation links.
     */
    public function getNavLinks(): array
    {
        return $this->navLinks;
    }

    /**
     * Sets the navigation links.
     *
     * @param array $navLinks The navigation links.
     * @return void
     */
    public function setNavLinks(array $navLinks): void
    {
        $this->navLinks = $navLinks;
    }

    /**
     * Constructor for the AppWebPage class.
     *
     * @param string $title The title of the web page.
     * @param string $logo The URL of the logo image (default is 'image/icon-site.png').
     * @param string $author The author of the web page (default is 'VIDAL&ARIDORY').
     * @param string $header The content for the header section (default is an empty string).
     * @param array $navLinks The navigation links (default is an array with 'Home' => '/index.php').
     */
    public function __construct(
        string $title,
        string $logo = 'image/icon-site.png',
        string $author = 'VIDAL&ARIDORY',
        string $header = '',
        array $navLinks = ['Home' => '/index.php']
    ) {
        parent::__construct($title);
        $this->menu = '';
        $this->logo = $logo;
        $this->author = $author;
        $this->header = $header;
        $this->navLinks = $navLinks;
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
        $html = <<<HTML
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
            <nav>
                <div class="nav-bar">
                    <i class='bx bx-menu sidebarOpen'></i>
                    <span class="logo navLogo"><a href="/index.php">Série TV</a></span>
            
                    <div class="menu">
                        <div class="logo-toggle">
                            <span class="logo"><a href="/index.php">Série TV</a></span>
                            <i class='bx bx-x siderbarClose'></i>
                        </div>
            
                        <div class="nav-links">
HTML;
        foreach ($this->navLinks as $name => $path) {
            $html .= <<<HTML
                            <div class="nav-links__item"><a href="{$path}">{$name}</a></div>
HTML;
        }
        $html .= <<<HTML
                        </div>
                    </div>
            
                    <div class="darkLight-searchBox">
                        <div class="dark-light">
                            <i class='bx bx-moon moon'></i>
                            <i class='bx bx-sun sun'></i>
                        </div>
            
                        <div class="searchBox">
                            <div class="searchToggle">
                                <i class='bx bx-x cancel'></i>
                                <i class='bx bx-search search'></i>
                            </div>
            
                            <div class="search-field">
                                <input id="input-box" type="text" placeholder="Search a TVshow..." autocomplete="off">
                                <i class='bx bx-search'></i>
                            </div>
                            <div class="result__box">
                                   
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main class="content">
            {$this->getMenu()}
            {$this->getBody()}
        </main>
        <footer class="footer">{$this->getLastModification()}</footer>
        <script src="/js/nav-animation.js"></script>
    </body>
</html>
HTML;
        return $html;
    }
}
