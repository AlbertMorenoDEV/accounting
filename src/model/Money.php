<?php
namespace accounting\model;

class Money
{
	private $amount;
	private $badge;

	public function __construct($amount, $badge="EUR")
	{
		assert(is_numeric($amount));
		assert(is_string($badge));
		$this->amount = $amount;
		$this->badge = $badge;
	}
	
	public function getAmount()
	{
		return $this->amount;
	}
	
	public function getBadge()
	{
		return $this->badge;
	}

	public function __toString()
	{
		return "{$this->amount} {$this->badge}";
	}
}