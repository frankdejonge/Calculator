<?php

interface OperationInterface
{
	public function execute($base, $subject);
	public function getToken();
	public function getPrecedence();
}