<?php
namespace accounting\model;

class Account
{
	private $id;
	private $name;
	private $creationDate;

	public function __construct(AccountId $id, $name, $creationDate)
	{
		assert(is_string($name));
		$this->id = $id;
		$this->name = $name;
		$this->creationDate = $creationDate;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getCreationDate()
	{
		return $this->creationDate;
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