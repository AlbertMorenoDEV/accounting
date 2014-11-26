<?php
namespace accounting\aplication;

use accounting\model\AccountId;
use accounting\model\AccountRepository;

class ChangeAccountName
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountRepository $repo, AccountId $accountId)
	{
		$this->repo = $repo;
		$this->idGenerator = $accountId;
	}

	public function execute($uuid, $newName)
	{
		if (is_string($uuid)) {
			$idGenerator = $this->idGenerator;
			$uuid = $idGenerator::fromString($uuid);
		}
		$account = $this->repo->findById($uuid);
		$account->setName($newName);
		$this->repo->add($account);
		$this->repo->save();
	}
}