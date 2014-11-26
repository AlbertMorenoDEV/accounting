<?php
namespace accounting\aplication;

use accounting\model\Account;
use accounting\model\AccountId;
use accounting\model\AccountRepository;

class CreateAccount
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountRepository $repo, AccountId $accountId)
	{
		$this->repo = $repo;
		$this->idGenerator = $accountId;
	}

	public function execute($name)
	{
		$idGenerator = $this->idGenerator;
		$uuid = $idGenerator::generate();
		$account = new Account($uuid, $name);
		$this->repo->add($account);
		$this->repo->save();
		return $uuid;
	}
}