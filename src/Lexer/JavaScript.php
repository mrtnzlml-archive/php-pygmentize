<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class JavaScript implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'commentsandwhitespace' => [
				['\s+', 'Text'],
				['<!--', 'Comment'],
				['//.*?\n', 'Comment.Single'],
				['/\*.*?\*/', 'Comment.Multilin'],
			],
			'slashstartsregex' => [
				'@commentsandwhitespace',
				['/(\\.|[^[/\\\n]|\[(\\.|[^\]\\\n])*])+/([gimuy]+\b|\B)', 'String.Regex', '#pop'],
				['(?=/)', 'Text', ['#pop', 'badregex']],
				['', 'Text', '#pop'],
			],
			'badregex' => [
				['\n', 'Text', '#pop'],
			],
			'root' => [
				['\A#! ?/.*?\n', 'Comment.Hashbang'], // recognized by node.js
				['^(?=\s|/|<!--)', 'Text', 'slashstartsregex'],
				'@commentsandwhitespace',
				['(\.\d+|[0-9]+\.[0-9]*)([eE][-+]?[0-9]+)?', 'Number.Float'],
				['0[bB][01]+', 'Number.Bin'],
				['0[oO][0-7]+', 'Number.Oct'],
				['0[xX][0-9a-fA-F]+', 'Number.Hex'],
				['[0-9]+', 'Number.Integer'],
				['(\.\.\.|=>)', 'Punctuation'],
				['(\+\+|--|~|&&|\?|:|\|\|\\\\(?=\n)|(<<|>>>?|==?|!=?|[-<>+*%&|^/])=?)', 'Operator', 'slashstartsregex'],
				['[{(\[;,]', 'Punctuation', 'slashstartsregex'],
				['[})\].]', 'Punctuation'],
				[
					'(for|in|while|do|break|return|continue|switch|case|default|if|else|throw|try|catch|finally|new|delete|typeof|instanceof|void|yield|this|of)\b',
					'Keyword',
					'slashstartsregex',
				],
				['(var|let|with|function)\b', 'Keyword.Declaration', 'slashstartsregex'],
				[
					'(abstract|boolean|byte|char|class|const|debugger|double|enum|export|extends|final|float|goto|implements|import|int|interface|long|native|package|private|protected|public|short|static|super|synchronized|throws|transient|volatile)\b',
					'Keyword.Reserved',
				],
				['(true|false|null|NaN|Infinity|undefined)\b', 'Keyword.Constant'],
				[
					'(Array|Boolean|Date|Error|Function|Math|netscape|Number|Object|Packages|RegExp|String|Promise|Proxy|sun|decodeURI|decodeURIComponent|encodeURI|encodeURIComponent|Error|eval|isFinite|isNaN|isSafeInteger|parseFloat|parseInt|document|this|window)\b',
					'Name.Builtin',
				],
				['[\pL\p{Nl}$_][\pL\p{Nl}$\p{Mn}\p{Mc}\p{Nd}\p{Pc}]*', 'Name.Other'],
				['"(\\\\|\\\\"|[^"])*"', 'String.Double'],
				["'(\\\\|\\\\'|[^'])*'", 'String.Single'],
				['`', 'String.Backtick', 'interp'],
			],
			'interp' => [
				['`', 'String.Backtick', '#pop'],
				['\\\\', 'String.Backtick'],
				['\\`', 'String.Backtick'],
				['\$\{', 'String.Interpol', 'interp-inside'],
				['\$', 'String.Backtick'],
				['[^`\\$]+', 'String.Backtick'],
			],
			'interp-inside' => [
				['\}', 'String.Interpol', '#pop'],
				'@root',
			],
		];
	}

}
