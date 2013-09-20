<?php

spl_autoload_register(function ($class) {
	include __DIR__.'/src/'.$class.'.php';
});

$calculator = new Calculator(new Input, new Output);
$calculator->addOperation(new AddOperation);
$calculator->addOperation(new MinusOperation);
$calculator->addOperation(new TimesOperation);
$calculator->addOperation(new DevideOperation);
$calculator->run();