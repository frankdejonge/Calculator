<?php

include './autoloader.php';

$calculator = new Calculator(new Input, new Output);
$calculator->addOperation(new AddOperation);
$calculator->addOperation(new MinusOperation);
$calculator->addOperation(new TimesOperation);
$calculator->addOperation(new DivideOperation);
$calculator->addOperation(new ModulusOperation);
$calculator->run();