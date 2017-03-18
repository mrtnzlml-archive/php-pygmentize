<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Php as PhpLexer;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class PhpTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new PhpLexer, new NullFormatter))->highlight(__DIR__ . '/sample.php');
		Assert::same(file_get_contents(__DIR__ . '/sample.php'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new PhpLexer, new Html))->highlight(__DIR__ . '/sample.php');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new PhpLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.php');
		Assert::same(1121, $highlighter->getComplexity());
	}

}

(new PhpTest)->run();
