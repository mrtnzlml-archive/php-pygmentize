<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Css as CssLexer;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class CssTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new CssLexer, new NullFormatter))->highlight(__DIR__ . '/sample.css');
		Assert::same(file_get_contents(__DIR__ . '/sample.css'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new CssLexer, new Html))->highlight(__DIR__ . '/sample.css');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new CssLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.css');
		Assert::same(631, $highlighter->getComplexity());
	}

}

(new CssTest)->run();
