<?php

class SqrtFunction extends AbstractFunction
{
	protected $name = 'sqrt';

	public function compute($expression)
	{
		return sqrt($expression);
	}
}