<?php

class CalculatorTest extends PHPUnit_Framework_TestCase
{
	protected $calculator;
	protected $input;
	protected $output;

	public function setUp()
	{
		$this->input = new ArrayInput;
		$this->output = new ArrayOutput;
		$this->calculator = new Calculator($this->input, $this->output);
		$this->calculator->addOperation(new AddOperation);
		$this->calculator->addOperation(new MinusOperation);
		$this->calculator->addOperation(new TimesOperation);
		$this->calculator->addOperation(new DivideOperation);
		$this->calculator->addOperation(new ModulusOperation);
		$this->calculator->addOperation(new PowerOperation);
		$this->calculator->addFunction(new SqrtFunction);
	}

	public function testUnknownOperation()
	{
		$this->input->setInput([
			'undefined(1)',
		]);

		$this->calculator->run();
		$output = $this->output->getOutput();
		$this->assertContains("Error: Could not find operation for token [undefined]", $output);
	}

	public function testUnknownFunction()
	{
		$this->input->setInput([
			'10 # 10',
			'10 - 10',
			'10 + 10',
		]);

		$this->calculator->run();
		$output = $this->output->getOutput();
		$this->assertContains("Error: Could not find operation for token [#]", $output);

		// Check it didn't continue
		$this->assertNotContains("Error: Could not find operation for token [-]", $output);

		// Check it didn't insert on its own
		$this->assertNotContains("Error: Could not find operation for token [%]", $output);
	}

	public function provider()
	{
		return [
			['1 + 1', 2],
			['2 - 1', 1],
			['2 / 1', 2],
			['2 * 2', 4],
			['2 ^ 2', 4],
			['2 * 2.5', 5],
			['2 + (20 * 2)', 42],
			['10 * 20 - 2 / 2 + 2', 201],
			['(20*4/2)-((13)+14+(4/2))', 11],
			['2 % 3', 2],
			['sqrt(9)', 3],
			['sqrt(3 + 3 + sqrt(9))', 3],
		];
	}

	/**
	 * @dataProvider provider
	 */
	public function testCalculations($calculation, $result)
	{
		$this->input->setInput([$calculation]);
		$this->calculator->run();
		$output = $this->output->getOutput();
		$this->assertContains('RESULT = '.$result, $output, print_r($output, true));
	}

	/**
	 * @expectedException LogicException
	 */
	public function testInvalidFunction()
	{
		$function = new InvalidFunction();
		$function->getName();
	}

	/**
	 * @expectedException LogicException
	 */
	public function testInvalidOperation()
	{
		$operation = new InvalidOperation();
		$operation->getToken();
	}
}