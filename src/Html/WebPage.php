<?php

declare(strict_types=1);

namespace Html;
use Html\StringEscaper;

class WebPage
{
    private string $head;
    private string $title;
    private string $body;


    /**
     * Webpage constructor.
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
        $this->head = "";
        $this->body = "";
    }

    /**
     * Head getter
     *
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Title getter
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Body getter
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Title setter
     *
     * @param string $title
     *
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Append content to the head
     *
     * @param string $content to be appended
     *
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Append CSS to the head
     *
     * @param string $css to be appended
     */
    public function appendCSS(string $css): void
    {
        $this->head .= "\n<style>$css</style>";
    }

    /**
     * Append a CSS url to the head
     *
     * @param string $url to be appended
     */
    public function appendCSSUrl(string $url): void
    {
        $this->head .= "\n<link rel='stylesheet' href='$url'>";
    }

    /**
     * Append JS to the head
     *
     * @param string $js to be appended
     */
    public function appendJS(string $js): void
    {
        $this->head .= "\n<script>$js</script>";
    }

    /**
     * Append a JS url to the head
     *
     * @param string $url to be appended
     */
    public function appendJSUrl(string $url): void
    {
        $this->head .= "\n<script src='$url'></script>";
    }

    /**
     * Append content to the body
     *
     * @param string $content to be appended
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Returns the webpage as a string
     *
     * @return string
     */
    public function toHTML($lang = "en"): string
    {

        return "<!DOCTYPE html>\n" . "<html lang='{$lang}'>\n<head>\n\t<title>" . $this->getTitle() . "</title>\n".
            $this->getHead() . "</head>\n<body>\n\t" . $this->getBody() . "</body>\n</html>";
    }

    use StringEscaper;

    /**
     * Returns the date and time of the last modification using getlastmod
     *
     * @return string
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
