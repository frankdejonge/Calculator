<?php

class Number
{
	public $value;

	public function __construct($value)
	{
		if (strpos($value, '.') !== false)
		{
			$this->value = floatval($value);
		}
		else
		{
			$this->value = intval($value);
		}
	}

	public function getValue()
	{
		return $this->value;
	}
}