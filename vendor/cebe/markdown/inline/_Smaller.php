<?php
/**
 * @copyright Copyright (c) 2019 Martin Toms
 */

namespace cebe\markdown\inline;

/**
 * Adds superscript inline elements
 */
trait _Smaller
{
	/**
     * syntax: 7(smaller text)7
     *
     * @marker 7(
     */
    protected function parseSmaller($markdown)
    {
        if (preg_match('/7\((.*?)\)7/', $markdown, $matches)) {
            return [
                ['smaller', $this->parseInline($matches[1])],
                strlen($matches[0])
            ];
        }
        return [['text', '7('], 2];
    }

    protected function renderSmaller($element)
    {
        return '<span class="text-75">' . $this->renderAbsy($element[1]) . '</span>';
    }

    abstract protected function parseInline($text);
    abstract protected function renderAbsy($blocks);
}
