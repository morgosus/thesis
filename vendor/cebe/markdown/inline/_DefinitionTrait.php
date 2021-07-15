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
trait _DefinitionTrait
{
    /**
     * ⚚
     * Parses an inline definition (:MySQL Workbench|A graphical interface for sql:).
     * @marker (:
     */
    protected function parseDefinition($text)
    {
        if (preg_match('/\(:(.*?)\|(.*?):\)/', $text, $matches)) { // code with enclosed (: | :)
            return [
                [
                    'definition',
                    $matches[1],
                    $matches[2],
                ],
                strlen($matches[0])
            ];
        }
        
        return [['text', $text[0]], 2];
    }
    
    protected function renderDefinition($block)
    {
        return '<span title="Click to show the definition, double click to hide it." ondblclick="this.classList.remove(\'active\')" onclick="this.classList.add(\'active\')" class="fleur">⚜&nbsp;<dfn>' . htmlspecialchars($block[1], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</dfn><span class="tooltip"><span class="middle-fleur">&nbsp;⚜&nbsp;</span>' . htmlspecialchars($block[2], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</span>&nbsp;⚜</span>';
    }
}
