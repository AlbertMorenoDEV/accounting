<?php
date_default_timezone_set('Europe/Madrid');
use accounting\infrastructure\persistence\MySQLAccountRepository;
use accounting\infrastructure\persistence\MySQLAccountHistoryRepository;
use accounting\model\Account;
use accounting\model\AccountHistory;
use accounting\infrastructure\ids\AccountUuid;
use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\model\Money;

class MySQLAccountHistoryRepositoryTest extends PHPUnit_Framework_TestCase
{
	private $conn;

	public function setUp()
	{
		$this->conn = new MySQLi("127.0.0.1", "accounting", "");
		$this->conn->select_db("accounting");
	}
	public function testSave()
	{
		// Account creation
		$idAccount = AccountUuid::fromString("0d467a5f-3969-4728-b9ae-b9d6c6c191ac");
		$account = new Account(
			$idAccount,
			"Ac1",
			new \DateTime("2014-11-29 16:14:01"),
			new \DateTime("2014-11-30 01:35:16"),
			new Money(340.2345)
		);
		$accountRespository = new MySQLAccountRepository($this->conn);
		$accountRespository->add($account);
		$accountRespository->save();
		
		// Account history creation
		$id = AccountHistoryUuid::fromString("a2ca46ea-7f5b-41b8-850b-3d9609b0d2b9");
		$accountHistory = new AccountHistory(
			$id,
			$account,
			new Money(10),
			new \DateTime("2014-11-29 16:17:01"),
			"PayPal"
		);

		$repo = new MySQLAccountHistoryRepository($this->conn);

		$repo->add($accountHistory);
		$repo->save();
		$this->assertEquals($accountHistory, $repo->findById($id));
		
		$accountRespository->delete($idAccount);
		$repo->delete($id);
		$repo = new MySQLAccountHistoryRepository($this->conn);
		$this->assertEquals(null, $repo->findById($id));
	}
}