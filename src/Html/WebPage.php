<?php

declare(strict_types=1);

namespace Html;
use Html\StringEscaper;

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
        $this->head = "";
        $this->body = "";
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
        $this->head .= "\n<link rel='stylesheet' href='$url'>";
    }

    /**
     * Method to add JavaScript to the <head> tag of the current object.
     *
     * @param string $js The JavaScript content to add.
     * @return void
     */
    public function appendJS(string $js): void
    {
        $this->head .= "\n<script>$js</script>";
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
        $this->head .= "\n<script src='$url'></script>";
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
    public function toHTML($lang = "en"): string
    {

        return "<!DOCTYPE html>\n" . "<html lang='{$lang}'>\n<head>\n\t<title>" . $this->getTitle() . "</title>\n".
            $this->getHead() . "</head>\n<body>\n\t" . $this->getBody() . "</body>\n</html>";
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
        return date("F d Y H:i:s.", getlastmod());
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
