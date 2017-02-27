<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class Ini implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'root' => [
				['\s+', 'Text'],
				[';.*?(\n|$)', 'Comment'],
				['\[.*?\](\n|$)', 'Keyword'],
				[
					'(.*?)(\s*)(=)(\s*)(.*?\n|.*?$)',
					['Name.Attribute', 'Text', 'Operator', 'Text', 'String'],
				],
			],
		];
	}

}
