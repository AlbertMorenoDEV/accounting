<?php
use accounting\model\Account;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Money;

class AccountTest extends PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$uuid = AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac");
		$name = "Ac1";
		$creationDate = "2014-11-29 16:14:01";
		$modificationDate = "2014-11-30 01:35:16";
		$total = 340.2345;
		
		$account = new Account($uuid, $name, $creationDate, $modificationDate, new Money($total));

		$this->assertEquals($uuid, $account->getId());
		$this->assertEquals("0d467a5f-3969-4728-b9ae-b9d6c6c191ac", (string)$account->getId());
		$this->assertEquals($name, $account->getName());
		$this->assertEquals($creationDate, $account->getCreationDate());
		$this->assertEquals($modificationDate, $account->getModificationDate());
		$this->assertEquals($total, $account->getTotal()->getAmount());
	}
}