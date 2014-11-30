<?php
namespace accounting\aplication;

use accounting\model\Account;
use accounting\model\AccountId;
use accounting\model\AccountRepository;
use accounting\model\Money;

class CreateAccount
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountRepository $repo, AccountId $accountId)
	{
		$this->repo = $repo;
		$this->idGenerator = $accountId;
	}

	public function execute($name, $total)
	{
		$idGenerator = $this->idGenerator;
		$uuid = $idGenerator::generate();
		$account = new Account($uuid, $name, date("Y-m-d h:i:s"), date("Y-m-d h:i:s"), new Money($total));
		$this->repo->add($account);
		$this->repo->save();
		return $uuid;
	}
}