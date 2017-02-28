<?php declare(strict_types = 1);

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class Utils extends \Tester\TestCase
{

	public function testExpandIncludes()
	{
		Assert::same(
			[
				'root' => [
					['a', ['b']],
					['c', ['d']],
					['e', ['f']],
				],
				'section' => [
					['a', ['b']],
					['c', ['d']],
				],
			],
			\Adeira\Utils::expandIncludes([
				'root' => [
					'@section',
					['e', ['f']],
				],
				'section' => [
					['a', ['b']],
					['c', ['d']],
				],
			]));
	}

}

(new Utils)->run();
