<?php

use Calculator\AbstractOperation;


class InvalidOperation extends AbstractOperation
{
	public function execute($base, $subject)
	{
		return pow($base, $subject);
	}
}