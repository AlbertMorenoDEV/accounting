<?php
use accounting\aplication\ViewAccountHistory;
use accounting\model\Account;
use accounting\model\AccountHistory;
use accounting\infrastructure\persistence\InMemoryAccountHistoryRepository;
use accounting\infrastructure\ids\AccountUuid;
use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\model\Money;

class ViewAccountHistoryTest extends PHPUnit_Framework_TestCase
{
	private $repo;

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
		
		$accountHistory = new AccountHistory(
			AccountHistoryUuid::fromString("ecc7663a-80f4-4b2e-84a0-4cbabdedb0bd"),
			$account,
			new Money(10),
			new \DateTime("2014-11-29 16:17:01"),
			"PayPal 1"
		);
		$this->repo->add($accountHistory);
		
		$accountHistory = new AccountHistory(
			AccountHistoryUuid::fromString("718f86fa-ade9-44d7-b052-114e584ffc5f"),
			$account,
			new Money(-5),
			new \DateTime("2014-11-29 16:18:51"),
			"PayPal 2"
		);
		$this->repo->add($accountHistory);
		
		$accountHistory = new AccountHistory(
			AccountHistoryUuid::fromString("42b50eb0-35ad-4b1f-8671-648ef8ea4e3d"),
			$account,
			new Money(-5),
			new \DateTime("2014-11-29 16:19:31"),
			"PayPal 23"
		);
		$this->repo->add($accountHistory);
		
		$this->repo->save();
	}

	public function testEjecutar()
	{
		$usecase = new ViewAccountHistory($this->repo, new AccountHistoryUuid);
		$result = $usecase->execute("ecc7663a-80f4-4b2e-84a0-4cbabdedb0bd");
		$this->assertEquals("ecc7663a-80f4-4b2e-84a0-4cbabdedb0bd", (string)$result->getId());
		$result = $usecase->execute(AccountHistoryUuid::fromString("42b50eb0-35ad-4b1f-8671-648ef8ea4e3d"));
		$this->assertEquals("42b50eb0-35ad-4b1f-8671-648ef8ea4e3d", (string)$result->getId());
	}
}