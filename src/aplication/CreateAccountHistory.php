<?php
namespace accounting\aplication;

use accounting\model\AccountHistory;
use accounting\model\AccountHistoryId;
use accounting\model\AccountHistoryRepository;
use accounting\model\Money;

class CreateAccountHistory
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountHistoryRepository $repo, AccountHistoryId $accountHistoryId)
	{
		$this->repo = $repo;
		$this->idGenerator = $accountHistoryId;
	}

	public function execute(Account $account, Money $amount, \DateTime $date, $concept)
	{
		$idGenerator = $this->idGenerator;
		$uuid = $idGenerator::generate();
		$this->repo->add(new AccountHistory($uuid, $account, $amount, $date, $concept));
		$this->repo->save();
		return $uuid;
	}
}