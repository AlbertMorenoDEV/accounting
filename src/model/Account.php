<?php
namespace accounting\model;

class Account
{
	private $id;
	private $name;

	public function __construct(AccountId $id, $name)
	{
		assert(is_string($name));
		$this->id = $id;
		$this->name = $name;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setName($newName)
	{
		$this->name = (string) $newName;
	}

	public function __toString()
	{
		return (string)$this->id;
	}
}