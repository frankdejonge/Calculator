<?php

abstract class AbstractFunction implements FunctionInterface
{
	protected $name = false;

	public function getName()
	{
		if ( ! $this->name)
		{
			throw new LogicException(__CLASS__.' should define a name');
		}

		return $this->name;
	}

	public function execute(Parser $parser, $expression)
	{
		$expression = $this->stripDefinition($expression);

		return $this->compute($parser->parse($expression));
	}

	protected function stripDefinition($expression)
	{
		return preg_replace('#^'.$this->name.'\((.*)\)$#', '$1', $expression);
	}

	abstract public function compute($expression);
}