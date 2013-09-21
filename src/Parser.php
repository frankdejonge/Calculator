<?php

class Parser
{
	public $input;
	public $calculator;

	public function __construct(Calculator $calculator, $input)
	{
		$this->calculator = $calculator;
		$this->input = trim($input);
	}

	public function parse()
	{
		$input = $this->parseGroup($this->input);

		return $input;
	}

	protected function parseGroup($input)
	{
		$segments = [];
		$parts = $this->parseString($input);

		foreach ($parts as $part)
		{
			$part = trim($part);

			if (is_numeric($part))
			{
				$part = new Number($part);
			}
			elseif ( ! is_object($part))
			{
				$part = $this->calculator->getOperation($part);
			}

			$segments[] = $part;
		}

		return $this->compute($segments);
	}

	protected function compute(array $segments)
	{
		$grouped = $this->groupByPrecedance($segments);

		return $this->executeGroup($grouped);
	}

	protected function executeGroup($group)
	{
		$first = array_shift($group);
		$result = is_object($first) ? $first->getValue() : $this->executeGroup($first);

		foreach ($group as $part)
		{
			if (is_array($part))
			{
				$part = $this->executeGroup($part);
			}

			if ($part instanceof AbstractOperation)
			{
				$operation = $part;
				continue;
			}

			if ($result === null)
			{
				$result = $part->getValue();
				continue;
			}

			$result = $operation->execute($result, $part->getValue());
		}

		return new Number($result);
	}

	protected function groupByPrecedance(array $segments)
	{
		$group = [];
		$precedance = false;

		foreach ($segments as $offset => $segment)
		{
			if ($precedance === false and $segment instanceof AbstractOperation)
			{
				$precedance = $segment->getPrecedence();
			}

			if ($segment instanceof Number or $segment->getPrecedence() === $precedance)
			{
				$group[] = $segment;
				continue;
			}

			if ($segment->getPrecedence() > $precedance)
			{
				array_pop($group);
				$tail = array_slice($segments, $index-3);
				$group[] = $this->groupByPrecedance($tail);

				return $group;
			}

			$precedance = $segment->getPrecedence();
			$group[] = $segment;
		}

		return $group;
	}

	public function parseSubstring($match)
	{
		$match = substr($match[0], 1, -1);

		return $this->parseGroup($match);
	}

	public function parseString($input)
	{
		while (strpos($input, '(') !== false)
		{
			$input = preg_replace_callback('#\(((?![\(\)]).+)\)#', [$this, 'parseSubstring'], $input);
		}

		$input = str_replace(' ', '', $input);
		$length = strlen($input);
		$parts = array();
		$level = 0;
		$current = '';

		for ($i = 0; $i < $length; $i++)
		{
			$char = $input[$i];

			if ($char === '(')
			{
				$level += 1;
			}
			elseif ($char === ')')
			{
				$level -= 1;
			}

			$current .= $char;

			if ($level === 0 and strlen($current))
			{
				if (is_numeric($current) and is_numeric(end($parts)))
				{
					$current = array_pop($parts).$current;
				}

				$parts[] = $current;
				$current = '';
			}
		}

		return $parts;
	}
}