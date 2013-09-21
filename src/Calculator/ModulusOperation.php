<?php

namespace Calculator;

class ModulusOperation extends AbstractOperation
{
	protected $token = '%';
	protected $precedence = 1;

	public function execute($base, $subject)
	{
		return $base % $subject;
	}
}