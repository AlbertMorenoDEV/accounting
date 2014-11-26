<?php
namespace accounting\infrastructure\persistence;

use accounting\model\Account;
use accounting\model\AccountId;
use accounting\model\AccountRepository;

class InMemoryAccountRepository implements AccountRepository
{
	private $items = [];
	private $temp = [];

	public function all()
	{
		return array_values($this->items);
	}

	public function findById(AccountId $id)
	{
		if (array_key_exists((string)$id, $this->items)) {
			return $this->items[(string)$id];
		} else {
			return null;
		}
	}

	public function findByName($name)
	{
		$resultado = [];
		foreach ($this->items as $account) {
			if ($name === "" || strpos($account->getName(), $name) !== false) {
				$resultado[] = $account;
			}
		}
		return $resultado;
	}

	public function add(Account $account)
	{
		$this->temp[(string)$account->getId()] = $account;
	}

	public function save()
	{
		$this->items = array_merge($this->items, $this->temp);
		$this->temp = [];
	}

	public function delete(AccountId $id)
	{
		unset($this->temp[(string)$id]);
		unset($this->items[(string)$id]);
	}

}