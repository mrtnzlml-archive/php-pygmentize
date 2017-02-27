<?php declare(strict_types = 1);

namespace Adeira;

final class Stack
{

	private $resolveLevel = ['root'];

	private $outputBuffer = '';

	private $cursorPosition = 0;

	public function push(string $levelName): void
	{
		$this->resolveLevel[] = $levelName;
	}

	public function pop(): void
	{
		if (count($this->resolveLevel) === 1) {
			return; //do not pop 'root' level
		}
		array_pop($this->resolveLevel);
	}

	/**
	 * Returns TOP of the stack (last inserted item).
	 */
	public function top(): string
	{
		return end($this->resolveLevel);
	}

	public function buffer(string $text): void
	{
		$this->outputBuffer .= $text;
	}

	public function getBufferContent(): string
	{
		return $this->outputBuffer;
	}

	public function increaseCursorPosition(int $steps = 1): void
	{
		$this->cursorPosition += $steps;
	}

	public function getCursorPosition(): int
	{
		return $this->cursorPosition;
	}

}
