<?php

class ArrayOutput implements OutputInterface
{
	protected $output = [];

	public function clear()
	{
		$this->output = [];
	}

	public function write($output = '', $newline = true)
	{
		if ( ! $newline and ! empty($this->output))
		{
			$output = array_pop($this->output).$output;
		}

		$this->output[] = $output;
	}

	public function getOutput()
	{
		return $this->output;
	}
}