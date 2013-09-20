<?php

class MinusOperation extends AbstractOperation
{
	protected $token = '-';

	public function execute($base, $subject)
	{
		return $base - $subject;
	}
}