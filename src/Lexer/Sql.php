<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class Sql implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'root' => [
				['\s+', 'Text'],
				['--.*\n?', 'Comment.Single'],
				['/\*', 'Comment.Multiline', 'multiline-comments'],
				['[A-Z]{2,}', 'Keyword'],
				['[+*/<>=~!@#%^&|`?-]', 'Operator'],
				['[0-9]+', 'Number.Integer'],
				["'(''|[^'])*'", 'String.Single'],
				['"(""|[^"])*"', 'String.Symbol'],
				['[a-zA-Z_][\w$]*', 'Name'],
				['[;:()\[\],.]', 'Punctuation'],
			],
			'multiline-comments' => [
				['/\*', 'Comment.Multiline', 'multiline-comments'],
				['\*/', 'Comment.Multiline', '#pop'],
				['[^/*]+', 'Comment.Multiline'],
				['[/*]', 'Comment.Multiline'],
			],
		];
	}

}
