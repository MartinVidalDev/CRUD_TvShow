<?php

declare(strict_types=1);

namespace Html;

/**
 * WebPage Class: This class facilitates the creation of HTML content without manually writing the HTML wrapper.
 */
class WebPage
{
    use StringEscaper;
    /**
     * @var string Text that will be between the <head> and </head> tags.
     */
    private string $head = "";

    /**
     * @var string Text that will be between the <title> and </title> tags.
     */
    private string $title;

    /**
     * @var string Text that will be between the <body> and </body> tags.
     */
    private string $body = "";


    /**
     * Constructor for the WebPage class. It assigns the content of the <title> tag to a web page.
     * If no content is provided when calling the constructor, the default value will be an empty string.
     *
     * @param string $title Title of the page. Default is an empty string.
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Accessor to get the content of the <head> tag of the current object.
     *
     * @return string Content of the <head> tag.
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Accessor to get the content of the <title> tag of the current object.
     *
     * @return string Content of the <title> tag.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Accessor to get the content of the <body> tag of the current object.
     *
     * @return string Content of the <body> tag.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Mutator to set the content of the $title variable in the <title> tag of the current object.
     *
     * @param string $title The title.
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Method to add content to the <head> tag of the current object.
     *
     * @param string $content The content to add.
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Method to add CSS to the <head> tag of the current object.
     *
     * @param string $css The CSS content to add.
     * @return void
     */
    public function appendCSS(string $css): void
    {
        $this->head .= <<<HTML
        <style>
            {$css}
        </style>
        HTML;
    }

    /**
     * Method to add the URL of a CSS script to the <head> tag of the current object
     * using the <link> tag.
     *
     * @param string $url The URL of the CSS script.
     * @return void
     */
    public function appendCSSUrl(string $url): void
    {
        $this->head .= <<<HTML
        <link rel='stylesheet' href='{$url}'>
        HTML;
    }

    /**
     * Method to add JavaScript to the <head> tag of the current object.
     *
     * @param string $js The JavaScript content to add.
     * @return void
     */
    public function appendJS(string $js): void
    {
        $this->head .= <<<HTML
        <script>
            {$js}
        </script>
        HTML;
    }

    /**
     * Method to add the URL of a JavaScript script to the <body> tag of the current object
     * using the <script> tag.
     *
     * @param string $url The URL of the JavaScript script.
     * @return void
     */
    public function appendJSUrl(string $url): void
    {
        $this->head .= <<<HTML
        <script src='{$url}'></script>

        HTML;
    }

    /**
     * Method to add content to the <body> tag of the current object.
     *
     * @param string $content The content to add.
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Method to generate the HTML code of the complete web page.
     *
     * @return string HTML code of the web page.
     */
    public function toHTML(): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                {$this->getBody()}
            </body>
        </html>
       HTML;
    }

    /**
     * Method to provide the date and time of the last modification
     * of the main content as a string.
     *
     * @return string The date and time of the last modification of the main content.
     * @throws \Exception
     */
    public function getLastModification(): string
    {
        // Create a DateTime object with the date of the last modification
        $date = new \DateTime('@' . getlastmod());

        // Create a date formatter in French
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern('EEEE d MMMM yyyy H:mm:ss');

        // Format the date
        $formattedDate = $formatter->format($date);

        return "Dernière modification : " . $formattedDate;
    }

    /**
     * Adds keywords to the page
     *
     * @param string $content the keywords to be appended to the head
     */
    public function addKeywords(string $content): void
    {
        $this->head .= "\n<meta name='keywords' content='{$content}'>";
    }
}
