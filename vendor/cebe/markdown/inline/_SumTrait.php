<?php
/**
 * @copyright Copyright (c) 2019 Martin Toms
 */

namespace cebe\markdown\inline;

/**
 * Adds ruby inline elements
 */
trait _SumTrait
{
    /**
     * syntax: s{toSum}(top)(bottom)
     *
     * @marker s{
     */
    protected function parseSum($markdown)
    {
        if (preg_match('/s{(.*?)}\((.*?)\)\((.*?)\)/', $markdown, $matches)) {
            return [
                ['sum', $this->parseInline($matches[1]), $this->parseInline($matches[2]), $this->parseInline($matches[3])],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        return [['text', 's{'], 2];
    }

    protected function renderSum($element)
    {
        return '<span class="sum"><span class="symbol">∑</span><span class="top">' . $this->renderAbsy($element[2]) .
            '</span><span class="bottom">' . $this->renderAbsy($element[3]) . '</span></span>'.
            '<span class="to-sum">' . $this->renderAbsy($element[1]) .
            '</span>';
    }

    abstract protected function parseInline($text);

    abstract protected function renderAbsy($blocks);
}
