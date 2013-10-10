<?php

namespace Calculator;

include __DIR__.'/autoloader.php';



$calculator = new Calculator(new Input, new Output);
$calculator->addOperation(new AddOperation);
$calculator->addOperation(new MinusOperation);
$calculator->addOperation(new TimesOperation);
$calculator->addOperation(new DivideOperation);
$calculator->addOperation(new ModulusOperation);
$calculator->addOperation(new PowerOperation);
$calculator->addFunction(new RoundFunction);
$calculator->addFunction(new SqrtFunction);
$calculator->run();