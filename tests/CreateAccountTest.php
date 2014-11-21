<?php
use accounting\aplication\CreateAccount;
use accounting\infrastructure\persistence\InMemoryAccountRepository;
use accounting\infrastructure\ids\AccountUuid;

class CreateAccountTest extends PHPUnit_Framework_TestCase
{
	public function testExecute()
	{
		$repo = new InMemoryAccountRepository();
		$usecase = new CreateAccount($repo, new AccountUuid);
		$usecase->ejecutar("Ac1");
		$account = $repo->all()[0];

		$this->assertInstanceOf('accounting\model\Account', $account);
		$this->assertEquals("Ac1", $account->name);
	}
}