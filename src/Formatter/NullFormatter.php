<?php declare(strict_types = 1);

namespace Adeira\Formatter;

final class NullFormatter implements \Adeira\IFormatter
{

	public function format(string $fragment, string $type)
	{
		return $fragment;
	}

}
