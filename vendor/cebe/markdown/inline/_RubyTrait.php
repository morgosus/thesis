<?php
/**
 * @copyright Copyright (c) 2019 Martin Toms
 */

namespace cebe\markdown\inline;

/**
 * Adds a ruby inline elements
 */
trait _RubyTrait
{
    /**
     * syntax: ^[bottom](top)
     * as: <ruby>bottom<rt>top</rt></ruby>
     *
     * @marker ^[
     */
    protected function parseRuby($markdown)
    {
        // check whether the marker really represents a strikethrough (i.e. there is a closing ~~)
        if (preg_match('/\^\[(.*?)\]\((.*?)\)/', $markdown, $matches)) {
            return [
                // return the parsed tag as an element of the abstract syntax tree and call `parseInline()` to allow
                // other inline markdown elements inside this tag
                ['ruby', $this->parseInline($matches[1]), $this->parseInline($matches[2])],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing ~~ we just return the marker and skip 2 characters
        return [['text', '^['], 2];
    }
    
    protected function renderRuby($element)
    {
        return '<ruby>' . $this->renderAbsy($element[1]) . '<rt>&nbsp;('.$this->renderAbsy($element[2]).')&nbsp;</rt></ruby>';
    }
    
    abstract protected function parseInline($text);
    abstract protected function renderAbsy($blocks);
}
