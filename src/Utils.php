<?php declare(strict_types = 1);

namespace Adeira;

final class Utils
{

	public static function expandIncludes(array $array): array
	{
		$outputRoot = [];
		foreach ($array as $sectionName => $section) {
			$subsectionCopy = [];
			foreach ($section as $subsection) {
				if (is_string($subsection) && preg_match('~^@([\s\S]+)~', $subsection, $matching)) {
					foreach ($array[$matching[1]] as $includePart) {
						$subsectionCopy[] = $includePart;
					}
				} else {
					$subsectionCopy[] = $subsection;
				}
			}
			$outputRoot[$sectionName] = $subsectionCopy;
		}
		return $outputRoot;
	}

}
