<?php
use accounting\aplication\CreateAccountHistory;
use accounting\infrastructure\persistence\InMemoryAccountHistoryRepository;
use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Account;
use accounting\model\Money;

class CreateAccountHistoryTest extends PHPUnit_Framework_TestCase
{
	public function testExecute()
	{
		$accountUuid = "0fc77d6d-cf05-4395-b579-9fe5a155ad04";
		$amount = 340.2345;
		$date = "2014-11-29 16:14:01";
		$concept = "PayPal";
		
		// Account creation
		$account = new Account(
			AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac"),
			"Ac1",
			new \DateTime("2014-11-29 16:14:01"),
			new \DateTime("2014-11-30 01:35:16"),
			new Money(340.2345)
		);
		
		$repo = new InMemoryAccountHistoryRepository();
		$usecase = new CreateAccountHistory($repo, new AccountHistoryUuid);
		$usecase->execute(
			$account,
			new Money($amount),
			new \DateTime($date),
			$concept
		);
		$accountHistory = $repo->all()[0];

		$this->assertInstanceOf('accounting\model\AccountHistory', $accountHistory);
		$this->assertEquals($account, $accountHistory->getAccount());
		$this->assertEquals(new Money($amount), $accountHistory->getAmount());
		$this->assertEquals($amount, $accountHistory->getAmount()->getAmount());
		$this->assertEquals(new \DateTime($date), $accountHistory->getDate());
		$this->assertEquals($date, $accountHistory->getDate()->format('Y-m-d H:i:s'));
		$this->assertEquals($concept, $accountHistory->getConcept());
	}
}