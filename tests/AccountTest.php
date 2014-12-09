<?php
use accounting\model\Account;
use accounting\infrastructure\ids\AccountUuid;
use accounting\model\Money;

class AccountTest extends PHPUnit_Framework_TestCase
{
	public function testConstructor()
	{
		$uuid = "0d467a5f-3969-4728-b9ae-b9d6c6c191ac";
		$name = "Ac1";
		$creationDate = "2014-11-29 16:14:01";
		$modificationDate = "2014-11-30 01:35:16";
		$total = 340.2345;
		
		$account = new Account(
			AccountUuid::fromString($uuid),
			$name,
			new \DateTime($creationDate),
			new \DateTime($modificationDate),
			new Money($total)
		);

		$this->assertEquals(AccountUuid::fromString($uuid), $account->getId());
		$this->assertEquals($uuid, (string)$account->getId());
		$this->assertEquals($name, $account->getName());
		$this->assertEquals(new \DateTime($creationDate), $account->getCreationDate());
		$this->assertEquals($creationDate, $account->getCreationDate()->format('Y-m-d H:i:s'));
		$this->assertEquals(new \DateTime($modificationDate), $account->getModificationDate());
		$this->assertEquals($modificationDate, $account->getModificationDate()->format('Y-m-d H:i:s'));
		$this->assertEquals(new Money($total), $account->getTotal());
		$this->assertEquals($total, $account->getTotal()->getAmount());
	}
}