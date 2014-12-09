<?php
namespace accounting\model;

interface AccountHistoryRepository
{
	public function all(Account $account);
	public function findById(AccountHistoryId $id);
	public function findByConcept(Account $account, $concept);
	public function add(AccountHistory $item);
	public function save();
	public function delete(AccountHistoryId $id);
}