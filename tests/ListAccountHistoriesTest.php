<?php
use accounting\aplication\ListAccountHistories;
use accounting\model\Account;
use accounting\model\AccountHistory;
use accounting\infrastructure\persistence\InMemoryAccountHistoryRepository;
use accounting\infrastructure\ids\AccountUuid;
use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\model\Money;

class ListAccountHistoriesTest extends PHPUnit_Framework_TestCase
{
	private $respository;
	private $account;

	public function setUp()
	{
		$this->respository = new InMemoryAccountHistoryRepository();
		
		// Account creation
		$this->account = new Account(
			AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac"),
			"Ac1",
			new \DateTime("2014-11-29 16:14:01"),
			new \DateTime("2014-11-30 01:35:16"),
			new Money(340.2345)
		);
		
		$accountHistory = new AccountHistory(
			AccountHistoryUuid::fromString("ecc7663a-80f4-4b2e-84a0-4cbabdedb0bd"),
			$this->account,
			new Money(10),
			new \DateTime("2014-11-29 16:17:01"),
			"PayPal 1"
		);
		$this->respository->add($accountHistory);
		
		$accountHistory = new AccountHistory(
			AccountHistoryUuid::fromString("718f86fa-ade9-44d7-b052-114e584ffc5f"),
			$this->account,
			new Money(-5),
			new \DateTime("2014-11-29 16:18:51"),
			"PayPal 2"
		);
		$this->respository->add($accountHistory);
		
		$accountHistory = new AccountHistory(
			AccountHistoryUuid::fromString("42b50eb0-35ad-4b1f-8671-648ef8ea4e3d"),
			$this->account,
			new Money(-5),
			new \DateTime("2014-11-29 16:19:31"),
			"PayPal 23"
		);
		$this->respository->add($accountHistory);
		
		$this->respository->save();
	}

	public function testConceptSearch()
	{
		$result = $this->respository->findByConcept($this->account, "PayPal");
		$this->assertCount(3, $result);
		$result = $this->respository->findByConcept($this->account, "PayPal 2");
		$this->assertCount(2, $result);
		$result = $this->respository->findByConcept($this->account, "No");
		$this->assertCount(0, $result);
	}

	public function testExecute()
	{
		$usecase = new ListAccountHistories($this->respository, $this->account);
		$result = $usecase->execute("PayPal 2");
		$this->assertCount(2, $result);
		$result = $usecase->execute("PayPal 1", false);
		$this->assertCount(1, $result);
		$this->assertEquals("PayPal 1", $result[0]->getConcept());
	}
}