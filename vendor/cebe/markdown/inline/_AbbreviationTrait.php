<?php
/**
 * @copyright Copyright (c) 2014 Carsten Brandt
 * @license   https://github.com/cebe/markdown/blob/master/LICENSE
 * @link      https://github.com/cebe/markdown#readme
 */

namespace cebe\markdown\inline;

/**
 * Adds inline code elements
 */
trait _AbbreviationTrait
{
    /**
     * ⚚
     * Parses an inline abbreviation definition [:PHP|Hypertext Preprocessor:].
     * @marker [:
     */
    protected function parseAbbreviation($text)
    {
        if (preg_match('/\[:(.*?)\|(.*?):\]/', $text, $matches)) { // code with enclosed (: | :)
            return [
                [
                    'abbreviation',
                    $matches[1],
                    $matches[2],
                ],
                strlen($matches[0])
            ];
        }
        
        return [['text', $text[0]], 2];
    }
    
    protected function renderAbbreviation($block)
    {
        return '<span title="'.htmlspecialchars($block[2], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8').'" class="abbreviation"><dfn><abbr>' . htmlspecialchars($block[1], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</abbr></dfn></span>';
    }
}
