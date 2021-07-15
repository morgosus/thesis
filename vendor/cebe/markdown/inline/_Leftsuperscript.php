<?php
/**
 * @copyright Copyright (c) 2019 Martin Toms
 */

namespace cebe\markdown\inline;

/**
 * Adds superscript inline elements
 */
trait _Leftsuperscript
{
	/**
     * syntax: l(superscript)
     *
     * @marker l(
     */
    protected function parseLeftsuperscript($markdown)
    {
        if (preg_match('/l\((.*?)\)/', $markdown, $matches)) {
            return [
                ['leftsuperscript', $this->parseInline($matches[1])],
                strlen($matches[0])
            ];
        }
        return [['text', 'l('], 2];
    }

    protected function renderLeftsuperscript($element)
    {
        return '<sup class="left-sup">' . $this->renderAbsy($element[1]) . '</sup>';
    }

    abstract protected function parseInline($text);
    abstract protected function renderAbsy($blocks);
}
