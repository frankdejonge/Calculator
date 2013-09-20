<?php

class Output implements OutputInterface
{
	public function write($output = '', $newline = true)
	{
		if ( ! is_string($output))
		{
			$output = print_r($output, true);
		}

		if ($newline)
		{
			$output .= PHP_EOL;
		}

		fwrite(STDOUT, $output);
	}
}