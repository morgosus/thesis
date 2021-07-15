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
trait _ColorTrait
{
    /**
     * ⚚
     * Parses a colorful text {:blue|this text is blue:}.
     * @marker {:
     */
    protected function parseColor($text)
    {
        if (preg_match('/\{:(.*?)\|(.*?):\}/', $text, $matches)) { // code with enclosed (: | :)
            return [
                [
                    'color',
                    $matches[1],
                    $matches[2],
                ],
                strlen($matches[0])
            ];
        }
        
        return [['text', $text[0]], 2];
    }
    
    protected function renderColor($block)
    {
        return '<span style="color:'.htmlspecialchars($block[1], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8').' !important;">'.htmlspecialchars($block[2], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8').'</span>';
    }
}
