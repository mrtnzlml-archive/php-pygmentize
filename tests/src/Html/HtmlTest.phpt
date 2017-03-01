<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Html as HtmlLexer;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class HtmlTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new HtmlLexer, new NullFormatter))->highlight(__DIR__ . '/sample.html');
		Assert::same(file_get_contents(__DIR__ . '/sample.html'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new HtmlLexer, new Html))->highlight(__DIR__ . '/sample.html');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new HtmlLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.html');
		Assert::same(423, $highlighter->getComplexity());
	}

}

(new HtmlTest)->run();
