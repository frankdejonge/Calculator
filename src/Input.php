<?php

class Input implements InputInterface
{
	public function read()
	{
		$output = trim(fgets(STDIN));

		if (empty($output))
		{
			return null;
		}

		return $output;
	}
}