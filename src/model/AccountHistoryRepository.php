<?php
namespace accounting\model;

interface AccountHistoryRepository
{
	public function all();
	public function findById(AccountHistoryId $id);
	public function findByConcept($concept);
	public function findByAccountId(AccountId $id);
	public function add(AccountHistory $item);
	public function save();
	public function delete(AccountHistoryId $id);
}