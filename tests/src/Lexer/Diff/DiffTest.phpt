<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Diff;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class DiffTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new Diff, new NullFormatter))->highlight(__DIR__ . '/sample.diff');
		Assert::same(file_get_contents(__DIR__ . '/sample.diff'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new Diff, new Html))->highlight(__DIR__ . '/sample.diff');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new Diff, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.diff');
		Assert::same(47, $highlighter->getComplexity());
	}

}

(new DiffTest)->run();
