<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Neon as NeonLexer;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class NeonTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new NeonLexer, new NullFormatter))->highlight(__DIR__ . '/sample.neon');
		Assert::same(file_get_contents(__DIR__ . '/sample.neon'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new NeonLexer, new Html))->highlight(__DIR__ . '/sample.neon');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new NeonLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.neon');
		Assert::same(530, $highlighter->getComplexity());
	}

}

(new NeonTest)->run();
