<?php
/**
 * @copyright Copyright (c) 2014 Carsten Brandt
 * @license https://github.com/cebe/markdown/blob/master/LICENSE
 * @link https://github.com/cebe/markdown#readme
 */

namespace cebe\markdown\inline;

/**
 * Adds inline code elements
 */
trait CodeTrait
{
	/**
	 * Parses an inline code span `` ` ``.
	 * @marker `
	 */
	protected function parseInlineCode($text)
	{
		if (preg_match('/^(``+)\s(.+?)\s\1/s', $text, $matches)) { // code with enclosed backtick
			return [
				[
					'inlineCode',
					$matches[2],
				],
				strlen($matches[0])
			];
		} elseif (preg_match('/^`(.+?)`/s', $text, $matches)) {
			return [
				[
					'inlineCode',
					$matches[1],
				],
				strlen($matches[0])
			];
		}
		return [['text', $text[0]], 1];
	}

	protected function renderInlineCode($block)
	{
        $block[1] = explode(' ', $block[1], 2);
		return '<code class="inline-code-block '.htmlspecialchars($block[1][0], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8').'">' . htmlspecialchars($block[1][1], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</code>';
	}
}
