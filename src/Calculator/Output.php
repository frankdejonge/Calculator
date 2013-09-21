<?php

namespace Calculator;

class Output implements OutputInterface
{
	public function write($output = '', $newline = true)
	{
		if ($newline)
		{
			$output .= PHP_EOL;
		}

		fwrite(STDOUT, $output);
	}
}