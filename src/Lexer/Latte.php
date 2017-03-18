<?php declare(strict_types = 1);

namespace Adeira\Lexer;

/**
 * Latte in CSS, JS or HTML attributes is not supported.
 */
final class Latte implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		$latteTokens = [
			'root' => [
				['{\*[\s\S]*?\*}', 'Comment'],
				['({/?)([$_a-z]+)', ['Punctuation', 'Keyword'], 'macro'],
				// HTML:
				['<!--', 'Comment', 'comment'],
				[
					'(<)(\s*)([\w:.-]+)', // open tag
					['Punctuation', 'Text', 'Name.Tag'],
					'tag',
				],
				[
					'(<)(\s*)(/)(\s*)([\w:.-]+)(\s*)(>)', // close tag
					['Punctuation', 'Text', 'Punctuation', 'Text', 'Name.Tag', 'Text', 'Punctuation'],
				],
				['.+?', 'Text'], // unknown
			],
			'macro' => [
				['}', 'Punctuation', '#pop'],
				['\$+(?:[\\\\_a-zA-Z]|[^\x00-\x7f])(?:[\\\\\w]|[^\x00-\x7f])*', 'Name.Variable'],
				['(\|)([a-z_-]+)', ['Punctuation', 'Name.Attribute']],
				['(\d+\.\d*|\d*\.\d+)(e[+-]?[0-9]+)?', 'Number.Float'],
				['\d+e[+-]?[0-9]+', 'Number.Float'],
				['0[0-7]+', 'Number.Oct'],
				['0x[a-f0-9]+', 'Number.Hex'],
				['\d+', 'Number.Integer'],
				['0b[01]+', 'Number.Bin'],
				["'([^'\\\\]*(?:\\\\.[^'\\\\]*)*)'", 'String.Single'],
				['"([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)"', 'String.Single'],
				['[-\[\]=,>]', 'Punctuation'],
				['[a-z_-]', 'Keyword'],
				['[\s\S]+?', 'Text'],
			],
		];

		$htmlLexerTokens = (new Html)->getTokens();
		return $latteTokens + [
				'tag' => $htmlLexerTokens['tag'],
				'attr' => $htmlLexerTokens['attr'],
				'comment' => $htmlLexerTokens['comment'],
			];
	}

}
