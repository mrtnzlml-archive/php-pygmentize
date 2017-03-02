<?php declare(strict_types = 1);

namespace Adeira;

final class Highlighter
{

	private $lexer;

	private $formatter;

	private $stack;

	private static $stepsCounter = 0;

	private $originalInput;

	public function __construct(ILexer $lexer, IFormatter $formatter)
	{
		$this->lexer = $lexer;
		$this->formatter = $formatter;
		$this->stack = new Stack;
	}

	public function highlight(string $file): string
	{
		$this->originalInput = $file;
		if (is_file($file)) {
			$this->originalInput = file_get_contents($file);
		}

		$tokens = \Adeira\Utils::expandIncludes($this->lexer->getTokens());
		$iteratorMax = mb_strlen($this->originalInput);

		while ($this->stack->getCursorPosition() < $iteratorMax) {
			$substring = mb_substr($this->originalInput, $this->stack->getCursorPosition());

			$match = $this->resolveState($substring, $tokens);
			if ($match === TRUE) {
				continue;
			}

			$unknowStatement = $this->formatter->format(mb_substr($substring, 0, 1, 'utf-8'), 'Error');
			$this->stack->buffer($unknowStatement);
			$this->stack->increaseCursorPosition(1);

			$this->stack->pop();
		}

		return $this->stack->getBufferContent();
	}

	public function getComplexity(): int
	{
		if (self::$stepsCounter === 0) {
			throw new \Exception("Call 'highlight' method first to get complexity.");
		}
		return self::$stepsCounter;
	}

	private function resolveState(string $input, array $tokens): bool
	{
		$stackLevel = $this->stack->top();
		if (!isset($tokens[$stackLevel])) {
			throw new \Exception("Section '$stackLevel' is missing in tokens.");
		}
		foreach ($tokens[$stackLevel] as $token) {
			self::$stepsCounter++;

			$pattern = preg_replace('`(~)`', '\\\\$1', $token[0]);
			if (preg_match("~^$pattern~", $input, $matches)) {

				if ($token[1] instanceof ILexer) {

					$nestedLexer = new self($token[1], $this->formatter);
					$this->stack->buffer($nestedLexer->highlight($matches[0]));

				} elseif (is_string($token[1])) {
					$this->stack->buffer($this->formatter->format($matches[0], $token[1]));
				} else { // multiple tokens at once
					foreach (array_slice($matches, 1) as $key => $fragment) {
						$this->stack->buffer($this->formatter->format($fragment, $token[1][$key]));
					}
				}

				$this->stack->increaseCursorPosition(mb_strlen($matches[0]));

				if (isset($token[2])) { // let's go deeper to the next resolver stage
					foreach ((array)$token[2] as $item) {
						if (preg_match('~#pop(:(\d+))?~', $item, $matches)) {
							$this->stack->pop((int)($matches[2] ?? 1));
						} else {
							$this->stack->push($item);
						}
					}
				}

				return TRUE;
			}
		}
		return FALSE;
	}

}
