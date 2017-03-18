<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Ini;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class IniTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new Ini, new NullFormatter))->highlight(__DIR__ . '/sample.ini');
		Assert::same(file_get_contents(__DIR__ . '/sample.ini'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new Ini, new Html))->highlight(__DIR__ . '/sample.ini');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new Ini, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.ini');
		Assert::same(31, $highlighter->getComplexity());
	}

}

(new IniTest)->run();
