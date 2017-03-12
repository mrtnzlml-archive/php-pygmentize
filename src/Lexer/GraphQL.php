<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class GraphQL implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'root' => [
				['#.*', 'Comment.Single'],
				['\.\.\.', 'Operator'],
				['"[\x{0009}\x{000A}\x{000D}\x{0020}-\x{FFFF}]*"', 'String.Double'],
				['(-?0|-?[1-9][0-9]*)(\.[0-9]+[eE][+-]?[0-9]+|\.[0-9]+|[eE][+-]?[0-9]+)', 'Number.Float'],
				['(-?0|-?[1-9][0-9]*)', 'Number.Integer'],
				['\$+[_A-Za-z][_0-9A-Za-z]*', 'Name.Variable'],
				['[_A-Za-z][_0-9A-Za-z]+\s?:', 'Text'],
				['(type|query|mutation|@[a-z]+|on|true|false|null)\b', 'Keyword.Type'],
				['[!$():=@\[\]{|}]+?', 'Punctuation'],
				['[_A-Za-z][_0-9A-Za-z]*', 'Keyword'],
				['(\s|,)', 'Text'],
			],
		];
	}

}
