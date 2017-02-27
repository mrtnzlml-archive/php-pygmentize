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
		$this->originalInput = file_get_contents($file);

		$iteratorMax = mb_strlen($this->originalInput);
		while ($this->stack->getCursorPosition() < $iteratorMax) {
			$substring = mb_substr($this->originalInput, $this->stack->getCursorPosition());

			$tokens = $this->lexer->getTokens();
			$resolvedLength = $this->resolveState($substring, $tokens);
			if ($resolvedLength === TRUE) { // match
				continue;
			}

			$unknowStatement = $this->formatter->format($this->originalInput[$this->stack->getCursorPosition()], 'Error');
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
		foreach ($tokens[$this->stack->top()] as $token) {
			$pattern = $token[0];

			self::$stepsCounter++;
			if (preg_match("~^$pattern~", $input, $matches)) {

				if (is_string($token[1])) {
					$this->stack->buffer($this->formatter->format($matches[0], $token[1]));
				} else { // multiple tokens at once
					foreach (array_slice($matches, 1) as $key => $fragment) {
						$this->stack->buffer($this->formatter->format($fragment, $token[1][$key]));
					}
				}

				$this->stack->increaseCursorPosition(mb_strlen($matches[0]));
				$input = mb_substr($this->originalInput, $this->stack->getCursorPosition());

				if (isset($token[2])) { // let's go deeper
					if ($token[2] === '#pop') {
						$this->stack->pop();
					} else {
						$this->stack->push($token[2]);
					}
					return $this->resolveState($input, $tokens);
				}

				return TRUE;
			}
		}
		return FALSE;
	}

}
