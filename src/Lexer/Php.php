<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class Php implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		$_ident_char = '[\\\\\w]|[^\x00-\x7f]';
		$_ident_begin = '(?:[\\\\_a-zA-Z]|[^\x00-\x7f])';
		$_ident_end = '(?:' . $_ident_char . ')*';
		$_ident_inner = $_ident_begin . $_ident_end;

		return [
			'root' => [
				['<\?(php)?', 'Comment.Preproc', 'php'],
				['[^<]+', 'Other'],
				['<', 'Other'],
			],
			'php' => [
				['\?>', 'Comment.Preproc', '#pop'],
				[
					'(<<<)([\'"]?)(' . $_ident_inner . ')(\2\n.*?\n\s*)(\3)(;?)(\n)',
					['String', 'String', 'String.Delimiter', 'String', 'String.Delimiter', 'Punctuation', 'Text'],
				],
				['\s+', 'Text'],
				['(#|//).*?\n', 'Comment.Single'],
				['/\*\*/', 'Comment.Multiline'],
				['/\*\*[\s\S]*?\*/', 'String.Doc'],
				['/\*[\s\S]*?\*/', 'Comment.Multiline'],
				['(->|::)(\s*)(' . $_ident_inner . ')', ['Operator', 'Text', 'Name.Attribute']],
				['[~!%^&*+=|:.<>/@-]+', 'Operator'],
				['\?', 'Operator'], // don't add to the charclass above!
				['[\[\]{}();,]+', 'Punctuation'],
				['(class|extends|implements)(\s+)', ['Keyword', 'Text'], 'classname'],
				['(function)(\s*)(?=\()', ['Keyword', 'Text']],
				['(function)(\s+)(&?)(\s*)', ['Keyword', 'Text', 'Operator', 'Text'], 'functionname'],
				['(const)(\s+)(' . $_ident_inner . ')', ['Keyword', 'Text', 'Name.Constant']],
				['__[A-Z]+__', 'Name.Constant'],
				['[a-zA-Z_]+', 'Keyword'],
				['\$\{\$+' . $_ident_inner . '\}', 'Name.Variable'],
				['\$+' . $_ident_inner, 'Name.Variable'],
				['(\d+\.\d*|\d*\.\d+)(e[+-]?[0-9]+)?', 'Number.Float'],
				['\d+e[+-]?[0-9]+', 'Number.Float'],
				['0[0-7]+', 'Number.Oct'],
				['0x[a-f0-9]+', 'Number.Hex'],
				['\d+', 'Number.Integer'],
				['0b[01]+', 'Number.Bin'],
				["'([^'\\\\]*(?:\\\\.[^'\\\\]*)*)'", 'String.Single'],
				['`([^`\\\\]*(?:\\\\.[^`\\\\]*)*)`', 'String.Backtick'],
				['"', 'String.Double', 'string'],
			],
			'classname' => [
				[$_ident_inner, 'Name.Class', '#pop'],
			],
			'functionname' => [
				['__[a-zA-Z_]', 'Name.Function.Magic'],
				[$_ident_inner, 'Name.Function', '#pop'],
				['', 'Text', '#pop'],
			],
			'string' => [
				['"', 'String.Double', '#pop'],
	            ['[^{$"\\\\]+', 'String.Double'],
	            ['\\\\([nrt"$\\]|[0-7]{1,3}|x[0-9a-f]{1,2})', 'String.Escape'],
	            ['\$' . $_ident_inner . '(\[\S+?\]|->' . $_ident_inner . ')?', 'String.Interpol'],
	            ['(\{\$\{)(.*?)(\}\})', 'String.Interpol'],
	            ['(\{)(\$.*?)(\})', 'String.Interpol'],
	            ['(\$\{)(\S+)(\})', ['String.Interpol', 'Name.Variable', 'String.Interpol']],
	            ['[${\\\\]', 'String.Double'],
	        ],
		];
	}

}
