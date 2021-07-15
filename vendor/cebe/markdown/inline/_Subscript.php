<?php
/**
 * @copyright Copyright (c) 2019 Martin Toms
 */

namespace cebe\markdown\inline;

/**
 * Adds subscript inline elements
 */
trait _Subscript
{
	/**
     * syntax: v(superscript)
     *
     * @marker v(
     */
    protected function parseSubscript($markdown)
    {
        // check whether the marker really represents a strikethrough (i.e. there is a closing ~~)
        if (preg_match('/v\((.*?)\)/', $markdown, $matches)) {
            return [
                // return the parsed tag as an element of the abstract syntax tree and call `parseInline()` to allow
                // other inline markdown elements inside this tag
                ['subscript', $this->parseInline($matches[1])],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing ~~ we just return the marker and skip 2 characters
        return [['text', 'v('], 2];
    }

    protected function renderSubscript($element)
    {
        return '<sub>' . $this->renderAbsy($element[1]) . '</sub>';
    }

    abstract protected function parseInline($text);
    abstract protected function renderAbsy($blocks);
}
