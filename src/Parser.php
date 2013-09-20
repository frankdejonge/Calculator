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
		$input = $this->parseGroups($this->input);

		return $input;
	}

	public function parseGroups($input)
	{
		$segments = [];
		$parts = $this->parseString($input);

		foreach ($parts as $part)
		{
			$part = trim($part);

			if (preg_match('/\(.+\)/', $part))
			{
				$parser = new static($this->calculator, substr($part, 1, -1));

				$part = $parser->parse();
			}

			if (is_numeric($part))
			{
				$part = new Number($part);
			}
			else
			{
				$part = new Opperation($part);
			}

			$segments[] = $part;
		}

		return $this->compute($segments);
	}

	public function compute(array $segments)
	{
		$grouped = $this->groupByPrecedance($segments);

		return $this->executeGroup($grouped);
	}

	public function executeGroup($group)
	{
		$first = array_shift($group);
		$result = $first->getValue();

		foreach ($group as $part)
		{
			if ($part instanceof Opperation)
			{
				$opperation = $part;
				continue;
			}

			$result = $opperation->execute($result, $part->getValue());
		}

		return $result;
	}

	public function groupByPrecedance(array $segments)
	{
		$group = [];
		$precedance = false;

		foreach ($segments as $offset => $segment)
		{
			if ($precedance === false and $segment instanceof Opperation)
			{
				$precedance = $segment->getPrecedance();
			}

			if ($segment instanceof Number or $segment->getPrecedance() === $precedance)
			{
				$group[] = $segment;
				continue;
			}

			if ($segment->getPrecedance() > $precedance)
			{
				$last = array_shift($group);
				$offset--;
			}

			$tail = array_slice($segments, $offset);
			$group[] = $this->groupByPrecedance($tail);

			return $group;
		}

		return $group;
	}

	public function parseString($input) {
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