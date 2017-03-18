<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\JavaScript as JavaScriptLexer;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class JavaScriptTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new JavaScriptLexer, new NullFormatter))->highlight(__DIR__ . '/sample.js');
		Assert::same(file_get_contents(__DIR__ . '/sample.js'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new JavaScriptLexer, new Html))->highlight(__DIR__ . '/sample.js');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new JavaScriptLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.js');
		Assert::same(2191, $highlighter->getComplexity());
	}

}

(new JavaScriptTest)->run();
