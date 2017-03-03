<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class Neon implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'root' => [
				['[\t ]+', 'Text'], // whitespace
				['\n[\t ]*', 'Text'], // new line + indent
				['[,:=[\]{}()-]', 'Punctuation'],
				['([tT][rR][uU][eE]|[yY][eE][sS])\b', 'Keyword.Constant'],
				['([fF][aA][lL][sS][eE]|[nN][oO])\b', 'Keyword.Constant'],
				['([nN][uU][lL][lL])\b', 'Keyword.Constant'],
				['0b[0-1]+\n', 'Number.Bin'],
				['0o[0-7]+\n', 'Number.Oct'],
				['0x[0-9a-fA-F]+\n', 'Number.Hex'],
				['\d\d\d\d-\d\d?-\d\d?(?:(?:[Tt]| +)\d\d?:\d\d:\d\d(?:\.\d*+)? *+(?:Z|[-+]\d\d?(?::?\d\d)?)?)?\n', 'Literal.Date'],
				['([^#"\',:=[\]{}()\x00-\x20!`-]|[:-][^"\',\]})\s])+(?:[^,:=\]})(\x00-\x20]+|:(?![\s,\]})]|$)|[ \t]+[^#,:=\]})(\x00-\x20])*', 'Keyword.Pseudo'], // literal / boolean / integer / float
				['#.*', 'Comment'],
				["'''\n(?:(?:[^\n]|\n(?![\t ]*+'''))*\n)?[\t ]*'''", 'String.Single'],
				['"""\n(?:(?:[^\n]|\n(?![\t ]*+"""))*\n)?[\t ]*"""', 'String.Double'],
				["'[^'\n]*'", 'String.Single'],
				['"[^"\n]*"', 'String.Double'],
			],
		];
	}

}
