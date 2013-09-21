<?php

namespace Calculator;

class Input implements InputInterface
{
	public function read()
	{
		$output = trim(fgets(STDIN));

		if (empty($output))
		{
			$output = null;
		}

		return $output;
	}
}