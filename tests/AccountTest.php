<?php
use accounting\model\Account;
use accounting\infrastructure\ids\AccountUuid;

class AccountTest extends PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$uuid = AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac");
		$account = new Account($uuid, "Ac1");

		$this->assertEquals($uuid, $account->getId());
		$this->assertEquals("0d467a5f-3969-4728-b9ae-b9d6c6c191ac", (string)$account->getId());
		$this->assertEquals("Ac1", $account->getName());
	}
}