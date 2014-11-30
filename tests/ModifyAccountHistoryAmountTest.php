<?php
use accounting\aplication\ModifyAccountHistoryAmount;
use accounting\model\Account;
use accounting\model\AccountHistory;
use accounting\infrastructure\persistence\InMemoryAccountHistoryRepository;
use accounting\infrastructure\ids\AccountUuid;
use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\model\Money;

class ModifyAccountHistoryAmountTest extends PHPUnit_Framework_TestCase
{
	private $repo;
	private $accountHistory;
	private $id;

	public function setUp()
	{
		$this->repo = new InMemoryAccountHistoryRepository();
		
		// Account creation
		$account = new Account(
			AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac"),
			"Ac1",
			new \DateTime("2014-11-29 16:14:01"),
			new \DateTime("2014-11-30 01:35:16"),
			new Money(340.2345)
		);
		
		// Account history creation
		$this->id = AccountHistoryUuid::fromString("ecc7663a-80f4-4b2e-84a0-4cbabdedb0bd");
		$this->accountHistory = new AccountHistory(
			$this->id,
			$account,
			new Money(10),
			new \DateTime("2014-11-29 16:17:01"),
			"PayPal"
		);
		$this->repo->add($this->accountHistory);
		
		$this->repo->save();
	}
	public function testExecute()
	{
		$usecase = new ModifyAccountHistoryAmount($this->repo, new AccountHistoryUuid);
		$usecase->execute($this->id, new Money(20));
		$this->assertEquals(new Money(20), $this->accountHistory->getAmount());
	}
}