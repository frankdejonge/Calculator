<?php

class Calculator
{
	protected $operations = [];
	protected $functions = [];
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
			$token = preg_replace('/[0-9\.]/', '', $token);

			throw new LogicException('Could not find operation for token ['.$token.']');
		}

		return $this->operations[$token];
	}

	public function addFunction(FunctionInterface $function)
	{
		$this->functions[$function->getName()] = $function;

		return $this;
	}

	public function getFunction($token)
	{
		if ( ! isset($this->functions[$token]))
		{
			$token = preg_replace('/[0-9\.]/', '', $token);

			throw new LogicException('Could not find function for token ['.$token.']');
		}

		return $this->functions[$token];
	}

	public function getFunctionNames()
	{
		return array_keys($this->functions);
	}

	public function getOperationTokens()
	{
		return array_keys($this->operations);
	}

	public function run()
	{
		$this->output->write('Enter a calculation and press enter to continue (empty line to quit):');
		$this->output->write();
		$this->output->write('CALCULATION: ', false);

		while ($input = $this->input->read())
		{
			if ( ! $this->process($input))
			{
				break;
			}

			$this->output->write('CALCULATION: ', false);
		}

		$this->output->write('Bye!');
	}

	protected function process($input)
	{
		try
		{
			$output = $this->execute($input);
			$this->output->write('RESULT = '.$output);
			$this->output->write();
		}
		catch (Exception $e)
		{
			if ( ! ($e instanceof LogicException))
			{
				$this->output->write((string) $e);

				return false;
			}

			$this->output->write('Error: '.$e->getMessage());

			return false;
		}

		return true;
	}

	protected function execute($input)
	{
		$parser = new Parser($this);

		return $parser->parse($input);
	}
}