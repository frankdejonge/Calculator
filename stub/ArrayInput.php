<?php

class ArrayInput implements InputInterface
{
	public function setInput(array $input)
	{
		$this->input = $input;
	}

	public function read()
	{
		return array_shift($this->input);
	}
}