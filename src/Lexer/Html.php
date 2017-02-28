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
				[
					'(<)(\s*)(script)(\s*)',
					['Punctuation', 'Text', 'Name.Tag', 'Text'],
					['script-content', 'tag'],
				],
				[
					'(<)(\s*)(style)(\s*)',
					['Punctuation', 'Text', 'Name.Tag', 'Text'],
					['style-content', 'tag'],
				],
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
			'script-content' => [
				[
					'(<)(\s*)(/)(\s*)(script)(\s*)(>)',
					['Punctuation', 'Text', 'Punctuation', 'Text', 'Name.Tag', 'Text', 'Punctuation'],
					'#pop',
				],
//				['.+?(?=<\s*/\s*script\s*>)', using(JavascriptLexer)], //TODO
				['[\s\S]+?(?=<\s*/\s*script\s*>)', 'Text'], //TODO: remove
			],
			'style-content' => [
				[
					'(<)(\s*)(/)(\s*)(style)(\s*)(>)',
					['Punctuation', 'Text', 'Punctuation', 'Text', 'Name.Tag', 'Text', 'Punctuation'],
					'#pop',
				],
//				['.+?(?=<\s*/\s*style\s*>)', using(CssLexer)], //TODO
				['[\s\S]+?(?=<\s*/\s*style\s*>)', 'Text'], //TODO: remove
			],
			'attr' => [
				['".*?"', 'String', '#pop'],
				["'.*?'", 'String', '#pop'],
				['[^\s>]+', 'String', '#pop'],
			],
		];
	}

}
