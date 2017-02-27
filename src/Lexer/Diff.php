<?php declare(strict_types = 1);

namespace Adeira\Lexer;

final class Diff implements \Adeira\ILexer
{

	public function getTokens(): array
	{
		return [
			'root' => [
				[' .*(\n|$)', 'Text'],
				['\+.*(\n|$)', 'Generic.Inserted'],
				['-.*(\n|$)', 'Generic.Deleted'],
				['!.*(\n|$)', 'Generic.Strong'],
				['@.*(\n|$)', 'Generic.Subheading'],
				['([Ii]ndex|diff).*(\n|$)', 'Generic.Heading'],
				['=.*(\n|$)', 'Generic.Heading'],
				['.*(\n|$)', 'Text'],
			],
		];
	}

}
