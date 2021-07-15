<?php
/**
 * @copyright Copyright (c) 2019 Martin Toms
 */

namespace cebe\markdown\inline;

/**
 * Adds superscript inline elements
 */
trait _Superscript
{
	/**
     * syntax: u(superscript)
     *
     * @marker u(
     */
    protected function parseSuperscript($markdown)
    {
        // check whether the marker really represents a strikethrough (i.e. there is a closing ~~)
        if (preg_match('/u\((.*?)\)/', $markdown, $matches)) {
            return [
                // return the parsed tag as an element of the abstract syntax tree and call `parseInline()` to allow
                // other inline markdown elements inside this tag
                ['superscript', $this->parseInline($matches[1])],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing ~~ we just return the marker and skip 2 characters
        return [['text', 'u('], 2];
    }

    protected function renderSuperscript($element)
    {
        return '<sup>' . $this->renderAbsy($element[1]) . '</sup>';
    }

    abstract protected function parseInline($text);
    abstract protected function renderAbsy($blocks);
}
