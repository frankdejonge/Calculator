<?php

class InvalidFunction extends AbstractFunction
{
	public function compute($expression)
	{
		return sqrt($expression);
	}
}