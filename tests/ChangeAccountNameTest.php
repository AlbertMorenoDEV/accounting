<?php
use accounting\aplication\ChangeAccountName;
use accounting\model\Account;
use accounting\infrastructure\persistence\InMemoryAccountRepository;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Money;

class ChangeAccountNameTest extends PHPUnit_Framework_TestCase
{
	private $repo;
	private $account;
	private $id;

	public function setUp()
	{
		$this->repo = new InMemoryAccountRepository();
		$this->id = AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac");
		$this->account = new Account($this->id, "Cat1", "2014-11-29 16:14:01", "2014-11-30 01:35:16", new Money(340.2345));
		$this->repo->add($this->account);
		$this->repo->save();
	}
	public function testExecute()
	{
		$usecase = new ChangeAccountName($this->repo, new AccountUuid);
		$usecase->execute($this->id, "New!!!");
		$this->assertEquals("New!!!", $this->account->getName());
	}
}