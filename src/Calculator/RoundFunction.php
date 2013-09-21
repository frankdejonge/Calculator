<?php

namespace Calculator;

class RoundFunction extends AbstractFunction
{
	protected $name = 'round';

	public function compute($expression)
	{
		return round($expression);
	}
}