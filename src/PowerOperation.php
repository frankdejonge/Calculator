<?php

class PowerOperation extends AbstractOperation
{
	protected $token = '^';
	protected $precedence = 2;

	public function execute($base, $subject)
	{
		return pow($base, $subject);
	}
}