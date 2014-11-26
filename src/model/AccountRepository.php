<?php
namespace accounting\model;

interface AccountRepository
{
	public function all();
	public function findById(AccountId $id);
	public function findByName($name);
	public function add(Account $item);
	public function save();
	public function delete(AccountId $id);
}