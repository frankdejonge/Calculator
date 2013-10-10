<?php

namespace Calculator;

class PiFunction extends AbstractFunction
{
	protected $name = 'pi';

	public function compute($expression)
	{
		return M_PI;
	}
}