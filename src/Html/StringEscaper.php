<?php

namespace Html;

trait StringEscaper {
    /**
     * Protects from special characters affecting the HTML webpage
     *
     * @param string $string to be protected
     * @return string protected
     */
    public function escapeString(?string $string): string
    {
        if ($string)
            return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        else
            return "";
    }

    public function stripTagsAndTrim(?string $string): string
    {
        if ($string) {
            $string = strip_tags($string);
            return trim($string);
        } else {
            return "";
        }
    }
}