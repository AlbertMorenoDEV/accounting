<?php
namespace accounting\aplication;

use accounting\model\Account;
use accounting\model\AccountHistoryId;
use accounting\model\AccountHistoryRepository;

class ListAccountHistories
{
	private $repository;
	private $account;

	public function __construct(AccountHistoryRepository $repository, Account $account)
	{
		$this->repository = $repository;
		$this->account = $account;
	}

	public function execute($conceptFilter = "")
	{
		assert(is_string($conceptFilter), "Error in concept filter");

		return $this->repository->findByConcept($this->account, $conceptFilter);
	}
}