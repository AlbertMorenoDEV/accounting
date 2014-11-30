<?php
namespace accounting\infrastructure\persistence;

use accounting\model\Account;
use accounting\model\AccountHistory;
use accounting\model\AccountId;
use accounting\model\AccountHistoryId;
use accounting\model\AccountHistoryRepository;

class InMemoryAccountHistoryRepository implements AccountHistoryRepository
{
	private $items = [];
	private $temp = [];
	
	public function all(Account $account)
	{
		$result = [];
		foreach ($this->items as $item) {
			if ($item->getAccount()->getId() == $account->getId()) {
				$result[] = $item;
			}
		}
		return $result;
	}

	public function findById(AccountHistoryId $id)
	{
		if (array_key_exists((string)$id, $this->items)) {
			return $this->items[(string)$id];
		} else {
			return null;
		}
	}

	public function findByConcept(Account $account, $concept)
	{
		$result = [];
		foreach ($this->items as $item) {
			if ($item->getAccount()->getId() == $account->getId() && ($concept === "" || strpos($item->getConcept(), $concept) !== false)) {
				$result[] = $item;
			}
		}
		return $result;
	}

	public function add(AccountHistory $account)
	{
		$this->temp[(string)$account->getId()] = $account;
	}

	public function save()
	{
		$this->items = array_merge($this->items, $this->temp);
		$this->temp = [];
	}

	public function delete(AccountHistoryId $id)
	{
		unset($this->temp[(string)$id]);
		unset($this->items[(string)$id]);
	}

}