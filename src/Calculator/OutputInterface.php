<?php

namespace Calculator;

interface OutputInterface
{
	public function write($output = '', $newline = true);
}