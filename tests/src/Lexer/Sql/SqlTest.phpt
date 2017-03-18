<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\Sql as SqlLexer;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class SqlTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new SqlLexer, new NullFormatter))->highlight(__DIR__ . '/sample.sql');
		Assert::same(file_get_contents(__DIR__ . '/sample.sql'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new SqlLexer, new Html))->highlight(__DIR__ . '/sample.sql');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new SqlLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.sql');
		Assert::same(1764, $highlighter->getComplexity());
	}

}

(new SqlTest)->run();
