<?php declare(strict_types = 1);

use Adeira\Formatter\Html;
use Adeira\Formatter\NullFormatter;
use Adeira\Highlighter;
use Adeira\Lexer\GraphQL as GraphQLLexer;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class GraphQLTest extends \Tester\TestCase
{

	public function testNullFormatter()
	{
		$result = (new Highlighter(new GraphQLLexer, new NullFormatter))->highlight(__DIR__ . '/sample.graphql');
		Assert::same(file_get_contents(__DIR__ . '/sample.graphql'), $result);
	}

	public function testHtmlFormatter()
	{
		$result = (new Highlighter(new GraphQLLexer, new Html))->highlight(__DIR__ . '/sample.graphql');
		Assert::same(file_get_contents(__DIR__ . '/expected.html'), $result);
	}

	public function testComplexity()
	{
		$highlighter = new Highlighter(new GraphQLLexer, new NullFormatter);
		$highlighter->highlight(__DIR__ . '/sample.graphql');
		Assert::same(1797, $highlighter->getComplexity());
	}

}

(new GraphQLTest)->run();
