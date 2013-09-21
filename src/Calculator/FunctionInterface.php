<?php

namespace Calculator;

interface FunctionInterface
{
	public function getName();
	public function execute(Parser $parser, $expression);
	public function compute($expression);
}