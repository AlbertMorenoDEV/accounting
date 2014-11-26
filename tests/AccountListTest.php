<?php
use accounting\aplication\AccountList;
use accounting\model\Account;
use accounting\infrastructure\persistence\InMemoryAccountRepository;
use accounting\infrastructure\ids\AccountUuid;

class AccountListTest extends PHPUnit_Framework_TestCase
{
	private $repo;

	public function setUp()
	{
		$this->repo = new InMemoryAccountRepository();
		$id = AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac");
		$account1 = new Account($id, "Account1 Test Bla");
		$this->repo->add($account1);
		$id = AccountUuid::fromString("8716297f-16c3-4b68-9357-2eaeaa224531");
		$account2 = new Account($id, "Account2 Test");
		$this->repo->add($account2);
		$id = AccountUuid::fromString("a29d0e54-1b87-435b-91e7-61dce038374a");
		$account3 = new Account($id, "Account3 Test Bla");
		$this->repo->add($account3);
		$this->repo->save();
	}

	public function testNameSearch()
	{
		$result = $this->repo->findByName("Account");
		$this->assertCount(3, $result);
		$result = $this->repo->findByName("Bla");
		$this->assertCount(2, $result);
		$result = $this->repo->findByName("No");
		$this->assertCount(0, $result);
	}

	public function testExecute()
	{
		$usecase = new AccountList($this->repo);
		$result = $usecase->execute("Bla");
		$this->assertCount(2, $result);
		$result = $usecase->execute("Account3", false);
		$this->assertCount(1, $result);
		$this->assertEquals("Account3 Test Bla", $result[0]->getName());
	}
}