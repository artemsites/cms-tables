<?php

namespace App\Service;

use Parsedown;

class MarkdownParserService
{
    public function toHtml(string $markdown): string
    {
        $ParsedownWithoutSquareBrackets = new ParsedownWithoutSquareBrackets();
        return $ParsedownWithoutSquareBrackets->text($markdown);
    }
}

class ParsedownWithoutSquareBrackets extends Parsedown
{
    protected function inlineLink($Excerpt)
    {

        $open = $_ENV["SHORTCODE_START_REGEXP"];
        $close = $_ENV["SHORTCODE_END_REGEXP"];

        if (preg_match("/^{$open}(.*?){$close}/", $Excerpt["context"], $matches)) {
            return array(
                "extent" => strlen($matches[0]),
                "element" => array(
                    "name" => "text",
                    "text" => $matches[0],
                ),
            );
        } else {
            return parent::inlineLink($Excerpt);
        }

    }
}
