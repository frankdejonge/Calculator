<?php

namespace Calculator;

class Parser
{
	public $calculator;

	public function __construct(Calculator $calculator)
	{
		$this->calculator = $calculator;
	}

	public function parseFunctions($match)
	{
		$function = $this->calculator->getFunction($match[1]);

		return $function->execute($this, $match[2]);
	}

	public function parse($input)
	{
		$input = trim($input);
		$functions = $this->calculator->getFunctionNames();

		if ( ! empty($functions))
		{
			$regex = '#('.join('|', $functions).')\((.*)\)#';

			while (preg_match($regex, $input))
			{
				$input = preg_replace_callback($regex, [$this, 'parseFunctions'], $input);
			}
		}

		while (strpos($input, '(') !== false)
		{
			$input = preg_replace_callback('#\(((?![\(\)]).)+\)#u', [$this, 'parseNesting'], $input);
		}

		$output = $this->parseGroup($input);

		return $output;
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
		$map = $this->mapPrecedence($segments);

		foreach ($map as $precedence)
		{
			$segments = $this->executePrecedence($precedence, $segments);
		}

		return $segments[0]->getValue();
	}

	protected function executePrecedence($precedence, array $segments)
	{
		$result = [array_shift($segments)];
		$skip = false;
		foreach ($segments as $index => $segment)
		{
			if ($skip === true)
			{
				$skip = false;
				continue;
			}

			if ($segment instanceof AbstractOperation and $segment->getPrecedence() === $precedence)
			{
				$last = array_pop($result);
				$next = $segments[$index+1];
				$computed = $segment->execute(
					$last->getValue(),
					$next->getValue()
				);
				$skip = true;
				$result[] = new Number($computed);
				continue;
			}

			$result[] = $segment;
		}

		return $result;
	}

	protected function mapPrecedence(array $segments)
	{
		$map = [];

		foreach ($segments as $segment)
		{
			if ($segment instanceof AbstractOperation)
			{
				$map[] = $segment->getPrecedence();
			}
		}

		$map = array_unique($map);
		sort($map);
		return array_reverse($map);
	}

	public function parseNesting($match)
	{
		$partial = substr($match[0], 1, -1);
		return $this->parseGroup($partial);
	}

	public function parseString($input)
	{
		$input = str_replace(' ', '', $input);

		$replacer = function ($match) {
			return '__EXPLODE__'.$match[0].'__EXPLODE__';
		};

		$regex = $this->getOperationsRegex();
		$input = preg_replace_callback('/(?<=[0-9])['.$regex.']{1}/', $replacer, $input);

		return explode('__EXPLODE__', $input);
	}

	public function getOperationsRegex()
	{
		$tokens = $this->calculator->getOperationTokens();
		$tokens = join($tokens);

		return preg_quote($tokens, '/');
	}
}