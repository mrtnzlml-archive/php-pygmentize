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
		// JavaScript
		$result = (new Highlighter(new JavaScriptLexer, new NullFormatter))->highlight(__DIR__ . '/sample.js');
		Assert::same(file_get_contents(__DIR__ . '/sample.js'), $result);
		// JSON
		$result = (new Highlighter(new JavaScriptLexer, new NullFormatter))->highlight(__DIR__ . '/sample.json');
		Assert::same(file_get_contents(__DIR__ . '/sample.json'), $result);
	}

	public function testHtmlFormatter()
	{
		// JavaScript
		$result = (new Highlighter(new JavaScriptLexer, new Html))->highlight(__DIR__ . '/sample.js');
		Assert::same(file_get_contents(__DIR__ . '/expected.js.html'), $result);
		// JSON
		$result = (new Highlighter(new JavaScriptLexer, new Html))->highlight(__DIR__ . '/sample.json');
		Assert::same(file_get_contents(__DIR__ . '/expected.json.html'), $result);
	}

	public function testComplexityJavaScript()
	{
		$highlighter = new Highlighter(new JavaScriptLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.js');
		Assert::same(2191, $highlighter->getComplexity());
	}

	public function testComplexityJSON()
	{
		$highlighter = new Highlighter(new JavaScriptLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.json');
		Assert::same(1000, $highlighter->getComplexity());
	}

}

(new JavaScriptTest)->run();
