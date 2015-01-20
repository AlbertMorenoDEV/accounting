<?php
namespace accounting\aplication;

use accounting\model\Account;
use accounting\model\AccountHistory;
use accounting\model\AccountHistoryId;
use accounting\model\AccountHistoryRepository;
use accounting\model\Money;

class CreateAccountHistory
{
	private $accountHistoryRepository;
	private $idGenerator;
	private $accountRepository;

	public function __construct(AccountHistoryRepository $accountHistoryRepository, AccountHistoryId $accountHistoryId)
	{
		$this->accountHistoryRepository = $accountHistoryRepository;
		$this->idGenerator = $accountHistoryId;
		$this->accountRepository = $accountRepository;
	}

	public function execute(Account $account, Money $amount, \DateTime $date, $concept)
	{
		$idGenerator = $this->idGenerator;
		$uuid = $idGenerator::generate();
		$this->accountHistoryRepository->add(new AccountHistory($uuid, $account, $amount, $date, $concept));
		$this->accountHistoryRepository->save();
		return $uuid;
	}
}