<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Latte as LatteLexer;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class LatteTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new LatteLexer, new NullFormatter))->highlight(__DIR__ . '/sample.latte');
		Assert::same(file_get_contents(__DIR__ . '/sample.latte'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new LatteLexer, new Html))->highlight(__DIR__ . '/sample.latte');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new LatteLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.latte');
		Assert::same(1400, $highlighter->getComplexity());
	}

}

(new LatteTest)->run();
