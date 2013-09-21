<?php

class InvalidOperation extends AbstractOperation
{
	public function execute($base, $subject)
	{
		return pow($base, $subject);
	}
}