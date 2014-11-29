<?php
use accounting\infrastructure\persistence\MySQLAccountRepository;
use accounting\model\Account;
use accounting\infrastructure\ids\AccountUuid;

class MySQLAccountRepositoryTest extends PHPUnit_Framework_TestCase
{
	private $conn;

	public function setUp()
	{
		$this->conn = new MySQLi("127.0.0.1", "accounting", "");
		$this->conn->select_db("accounting");
	}
	public function testSave()
	{
		$id = AccountUuid::fromNamespace("unitest");
		$account = new Account($id, "Account Tèst");

		$repo = new MySQLAccountRepository($this->conn);
		$repo->delete($id);
		$this->assertEquals(null, $repo->findById($id));

		$repo->add($account);
		$repo->save();
		$this->assertEquals($account, $repo->findById($id));

		$repo->delete($id);
		$repo = new MySQLAccountRepository($this->conn);
		$this->assertEquals(null, $repo->findById($id));
	}
}