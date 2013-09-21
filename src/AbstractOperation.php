<?php

abstract class AbstractOperation implements OperationInterface
{
	protected $token = false;
	protected $precedence = 0;

	public function getToken()
	{
		if ( ! $this->token)
		{
			throw new LogicException(__CLASS__.' should define a token');
		}

		return $this->token;
	}

	public function getPrecedence()
	{
		return $this->precedence;
	}
}