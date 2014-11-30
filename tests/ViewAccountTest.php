<?php
use accounting\aplication\ViewAccount;
use accounting\model\Account;
use accounting\infrastructure\persistence\InMemoryAccountRepository;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Money;

class ViewAccountTest extends PHPUnit_Framework_TestCase
{
	private $repo;

	public function setUp()
	{
		$this->repo = new InMemoryAccountRepository();
		$id = AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac");
		$account1 = new Account($id, "Account1 Test Bla", "2014-11-29 16:14:01", "2014-11-30 01:35:16", new Money(340.2345));
		$this->repo->add($account1);
		$id = AccountUuid::fromString("8716297f-16c3-4b68-9357-2eaeaa224531");
		$account2 = new Account($id, "Account2 Test", "2014-11-29 16:14:01", "2014-11-30 01:35:16", new Money(340.2345));
		$this->repo->add($account2);
		$id = AccountUuid::fromString("a29d0e54-1b87-435b-91e7-61dce038374a");
		$account3 = new Account($id, "Account3 Test Bla", "2014-11-29 16:14:01", "2014-11-30 01:35:16", new Money(340.2345));
		$this->repo->add($account3);
		$this->repo->save();
	}

	public function testEjecutar()
	{
		$usecase = new ViewAccount($this->repo, new AccountUuid);
		$result = $usecase->execute("8716297f-16c3-4b68-9357-2eaeaa224531");
		$this->assertEquals("8716297f-16c3-4b68-9357-2eaeaa224531", (string)$result->getId());
		$result = $usecase->execute(AccountUuid::fromString("8716297f-16c3-4b68-9357-2eaeaa224531"));
		$this->assertEquals("8716297f-16c3-4b68-9357-2eaeaa224531", (string)$result->getId());
	}
}