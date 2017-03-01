<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class Css implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'root' => [
				'@basics',
			],
			'basics' => [
				['\s+', 'Text'], // white characters
				['/\*(?:.|\n)*?\*/', 'Comment'], // /* ... */
				['\{', 'Punctuation', 'content'], // {
				['(\:{1,2})([\w-]+)', ['Punctuation', 'Name.Decorator']], // ::after
				['(\.)([\w-]+)', ['Punctuation', 'Name.Class']], // .class
				['(\#)([\w-]+)', ['Punctuation', 'Name.Namespace']], // #id
				['(@)([\w-]+)', ['Punctuation', 'Keyword'], 'atrule'], // @media
				['[\w-]+', 'Name.Tag'], // body
				['[~^*!%&$\[\]()<>|+=@:;,./?-]', 'Operator'],
				['"(\\\\|\\\\"|[^"])*"', 'String.Double'],
				["'(\\\\|\\\\'|[^'])*'", 'String.Single'],
			],
			'atrule' => [
				['\{', 'Punctuation', 'atcontent'],
				[';', 'Punctuation', '#pop'],
				'@basics',
			],
			'atcontent' => [
				'@basics',
				['\}', 'Punctuation', '#pop:2'],
			],
			'content' => [
				['\s+', 'Text'],
				['\}', 'Punctuation', '#pop'],
				[';', 'Punctuation'],
				['^@.*?$', 'Comment.Preproc'],
				['([a-zA-Z_][\w-]*)(\s*)(\:)', ['Keyword', 'Text', 'Punctuation'], 'value-start'],
				['(--[a-zA-Z_][\w-]*)(\s*)(\:)', ['Name.Variable', 'Text', 'Punctuation'], 'value-start'], // --variable:
				['/\*(?:.|\n)*?\*/', 'Comment'],
			],
			'value-start' => [
				['\s+', 'Text'],
				'@urls',
				['([\w]+)(\()', ['Name.Builtin', 'Punctuation'], 'function-start'],
				['([a-zA-Z_][\w-]+)(\()', ['Name.Function', 'Punctuation'], 'function-start'],
				['[a-zA-Z_][\w-]+', 'Keyword.Constant'],
				['([a-zA-Z_][\w-]*)', 'Keyword'], // for transition-property etc.
				['\!important', 'Comment.Preproc'],
				['/\*(?:.|\n)*?\*/', 'Comment'],
				'@numeric-values',
				['[~^*!%&<>|+=@:./?-]+', 'Operator'],
				['[\[\](),]+', 'Punctuation'],
				['"(\\\\|\\"|[^"])*"', 'String.Double'],
				["'(\\\\|\\'|[^'])*'", 'String.Single'],
				['[a-zA-Z_][\w-]*', 'Name'],
				[';', 'Punctuation', '#pop'],
				['\}', 'Punctuation', '#pop:2'],
			],
			'function-start' => [
				['\s+', 'Text'],
				'@urls',
				['[a-zA-Z_][\w-]+', 'Keyword.Constant'],
				['--[a-zA-Z_][\w-]*', 'Name.Variable'], // --variable

				// function-start may be entered recursively
				['([\w]+)(\()', ['Name.Builtin', 'Punctuation'], 'function-start'],
				['([a-zA-Z_][\w-]+)(\()', ['Name.Function', 'Punctuation'], 'function-start'],

				['/\*(?:.|\n)*?\*/', 'Comment'],
				'@numeric-values',
				['[*+/-]', 'Operator'],
				['[,]', 'Punctuation'],
				['"(\\\\|\\"|[^"])*"', 'String.Double'],
				["'(\\\\|\\'|[^'])*'", 'String.Single'],
				['[a-zA-Z_-]\w*', 'Name'],
				['\)', 'Punctuation', '#pop'],
			],
			'urls' => [
				['(url)(\()(".*?")(\))', ['Name.Builtin', 'Punctuation', 'String.Double', 'Punctuation']],
				["(url)(\()('.*?')(\))", ['Name.Builtin', 'Punctuation', 'String.Single', 'Punctuation']],
				['(url)(\()(.*?)(\))', ['Name.Builtin', 'Punctuation', 'String.Other', 'Punctuation']],
			],
			'numeric-values' => [
				['\#[a-zA-Z0-9]{1,6}', 'Number.Hex'],
				['[+\-]?[0-9]*[.][0-9]+', 'Number.Float', 'numeric-end'],
				['[+\-]?[0-9]+', 'Number.Integer', 'numeric-end'],
			],
			'numeric-end' => [
				['[a-zA-Z]+', 'Keyword.Type'],
				['%', 'Keyword.Type'],
				['', 'Text', '#pop'],
			],
		];
	}

}
