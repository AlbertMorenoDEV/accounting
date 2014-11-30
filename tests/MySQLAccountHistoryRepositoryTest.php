<?php
date_default_timezone_set('Europe/Madrid');
use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\infrastructure\ids\AccountUuid;
use accounting\infrastructure\persistence\MySQLAccountHistoryRepository;
use accounting\infrastructure\persistence\MySQLAccountRepository;
use accounting\model\Account;
use accounting\model\AccountHistory;
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
		$accountRepository = new MySQLAccountRepository($this->conn);
		$accountHistoryRepository = new MySQLAccountHistoryRepository($this->conn);
		$idAccount = AccountUuid::fromNamespace("unitest_account");
		$id = AccountHistoryUuid::fromNamespace("unitest_account_history");
		
		// Clean
		$accountHistoryRepository->delete($id);
		$this->assertEquals(null, $accountHistoryRepository->findById($id));
		$accountRepository->delete($idAccount);
		$this->assertEquals(null, $accountRepository->findById($idAccount));
		
		// Account creation
		$account = new Account(
			$idAccount,
			"Ac1",
			new \DateTime("2014-11-29 16:14:01"),
			new \DateTime("2014-11-30 01:35:16"),
			new Money(340.2345)
		);
		$accountRepository->add($account);
		$accountRepository->save();
		
		// Account history creation
		$accountHistory = new AccountHistory(
			$id,
			$account,
			new Money(10),
			new \DateTime("2014-11-29 16:17:01"),
			"PayPal"
		);
		
		$accountHistoryRepository->add($accountHistory);
		$accountHistoryRepository->save();
		$this->assertEquals($accountHistory, $accountHistoryRepository->findById($id));
		
		// delete
		$accountHistoryRepository->delete($id);
		$this->assertEquals(null, $accountHistoryRepository->findById($id));
		$accountRepository->delete($idAccount);
		$this->assertEquals(null, $accountRepository->findById($idAccount));
	}
}