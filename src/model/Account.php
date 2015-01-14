<?php
namespace accounting\model;

class Account
{
	private $id;
	private $name;
	private $creationDate;
	private $modificationDate;
	private $total;

	public function __construct(AccountId $id, $name, \DateTime $creationDate, \DateTime $modificationDate, Money $total)
	{
		assert(is_string($name));
		$this->id = $id;
		$this->name = $name;
		$this->creationDate = $creationDate;
		$this->modificationDate = $modificationDate;
		$this->total = $total;
	}
	
	/**
	 * Getters
	 */
	public function getId() { return $this->id; }
	public function getName() { return $this->name; }
	public function getCreationDate() { return $this->creationDate; }
	public function getModificationDate() { return $this->modificationDate; }
	public function getTotal() { return $this->total; }
	public function __toString() { return (string)$this->id; }
	
	/**
	 * Setters
	 */
	public function setName($newName) { $this->name = (string) $newName; }
	public function setModificationDate($newModificationDate) { $this->modificationDate = $newModificationDate; }
	public function setTotal(Money $newTotal) { $this->total = $newTotal; }
}