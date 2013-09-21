<?php

class Calculator
{
	protected $operations = [];
	protected $input;
	protected $output;

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
			$this->output->write(' !! COULD NOT FIND OPERATION FOR TOKEN: ['.$token.'] !! ');
			exit(0);
		}

		return $this->operations[$token];
	}

	public function run()
	{
		$this->output->write('Enter a calculation and press enter to continue (empty line to quit):');
		$this->output->write();
		$this->output->write('CALCULATION: ', false);

		while ($input = $this->input->read())
		{
			$output = $this->execute($input);
			$this->output->write('RESULT = '.$output);
			$this->output->write();
			$this->output->write('CALCULATION: ', false);
		}

		$this->write('Bye!');
	}

	protected function execute($input)
	{
		$parser = new Parser($this, $input);

		return $parser->parse();
	}
}