<?php

class Opperation
{
	public function __construct($opperation)
	{
		$this->opperation = $opperation;
	}

	public function getPrecedance()
	{
		return in_array($this->opperation, ['*', '/']) ? 0 : 1;
	}

	public function execute($first, $second)
	{
		switch ($this->opperation) {
			case '*':
				return $first * $second;
			case '/':
				return $first / $second;
			case '^':
				return $first ^ $second;
			case '-':
				return $first - $second;
			case '+':
				return $first + $second;
		}
	}
}