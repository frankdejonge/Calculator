<?php

class Calculator
{
	public $operations = [];

	public function addOperation(OperationInterface $operation)
	{
		$this->operations[$operation->getToken()] = $operation;

		return $this;
	}

	public function getOperation($token)
	{
		if ( ! isset($this->operations[$token]))
		{
			$this->write(' !! COULD NOT FIND OPERATION FOR TOKEN: '.$token.' !! ');
			exit(0);
		}

		return $this->operations[$token];
	}

	public function read()
	{
		$output = trim(fgets(STDIN));

		if (empty($output))
		{
			return null;
		}

		return $output;
	}

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

	public function run()
	{
		$this->write('Enter a calculation and press enter to continue (empty line to quit):');
		$this->write();
		$this->write('CALCULATION: ', false);

		while ($input = $this->read())
		{
			$output = $this->execute($input);
			$this->write('RESULT = '.$output);
			$this->write();
			$this->write('CALCULATION: ', false);
		}

		$this->write('Bye!');
	}

	public function execute($input)
	{
		$parser = new Parser($this, $input);

		return $parser->parse();
	}
}