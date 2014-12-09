<?php
namespace accounting\model;

class AccountHistory
{
	private $id;
	private $account;
	private $amount;
	private $date;
	private $concept;

	public function __construct(AccountHistoryId $id, Account $account, Money $amount, \DateTime $date, $concept)
	{
		assert(is_string($concept) || is_null($concept));
		
		$this->id = $id;
		$this->account = $account;
		$this->amount = $amount;
		$this->date = $date;
		$this->concept = $concept;
	}
	
	/**
	 * Getters
	 */
	public function getId() { return $this->id; }
	public function getAccount() { return $this->account; }
	public function getAmount() { return $this->amount; }
	public function getDate() { return $this->date; }
	public function getConcept() { return $this->concept; }
	public function __toString() { return (string)$this->id; }
	
	/**
	 * Setters
	 */
	public function setAmount($new) { $this->amount = $new; }
	public function setDate($new) { $this->date = $new; }
	public function setConcept($new)
	{
		assert(is_string($newConcept) || is_null($newConcept));
		$this->concept = $new;
	}
}