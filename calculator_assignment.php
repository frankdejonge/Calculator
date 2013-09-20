<?php

$classes = glob(__DIR__.'/src/*.php');

foreach ($classes as $class)
{
	include $class;
}

$calculator = new Calculator();
$calculator->run();