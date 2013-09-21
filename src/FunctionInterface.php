<?php

interface FunctionInterface
{
	public function getName();
	public function execute(Parser $parser, $expression);
}