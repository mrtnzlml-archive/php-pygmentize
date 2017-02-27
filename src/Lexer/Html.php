<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class Html implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'root' => [
				['[^<&]+', 'Text'],
				['&\S*?;', 'Name.Entity'],
				['\<\!\[CDATA\[.*?\]\]\>', 'Comment.Preproc'],
				['<!--', 'Comment', 'comment'],
				['<\?.*?\?>', 'Comment.Preproc'],
				['<![^>]*>', 'Comment.Preproc'],
//				[
//					'(<)(\s*)(script)(\s*)',
//					['Punctuation', 'Text', 'Name.Tag', 'Text'], //TODO: ('script-content', 'tag')
//				],
//				[
//					'(<)(\s*)(style)(\s*)',
//					['Punctuation', 'Text', 'Name.Tag', 'Text'], //TODO: ('script-content', 'tag')
//				],
				[
					'(<)(\s*)([\w:.-]+)',
					['Punctuation', 'Text', 'Name.Tag'],
					'tag',
				],
				[
					'(<)(\s*)(/)(\s*)([\w:.-]+)(\s*)(>)',
					['Punctuation', 'Text', 'Punctuation', 'Text', 'Name.Tag', 'Text', 'Punctuation'],
				],
			],
			'comment' => [
				['[^-]+', 'Comment'],
				['-->', 'Comment', '#pop'],
				['-', 'Comment'],
			],
			'tag' => [
				['\s+', 'Text'],
				[
					'([\w:-]+\s*)(=)(\s*)',
					['Name.Attribute', 'Operator', 'Text'],
					'attr',
				],
				['[\w:-]+', 'Name.Attribute'],
				[
					'(/?)(\s*)(>)',
					['Punctuation', 'Text', 'Punctuation'],
					'#pop',
				],
			],
			'attr' => [
				['".*?"', 'String', '#pop'],
				["'.*?'", 'String', '#pop'],
				['[^\s>]+', 'String', '#pop'],
			],
		];
	}

}
