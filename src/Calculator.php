<?php

class Calculator
{
	public $operations = [];

	public function __construct(InputInterface $input, OutputInterface $output)
	{
		$this->input = $input;
		$this->output = $output;
	}

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
		return $this->input->read();
	}

	public function write($output = '', $newline = true)
	{
		return $this->output->write($output, $newline);
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