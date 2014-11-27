<?php
namespace accounting\aplication;

use accounting\model\AccountId;
use accounting\model\AccountRepository;

class ViewAccount
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountRepository $repo, AccountId $accountId)
	{
		$this->repo = $repo;
		$this->idGenerator = $accountId;
	}

	public function execute($uuid)
	{
		if (is_string($uuid)) {
			$idGenerator = $this->idGenerator;
			$uuid = $idGenerator::fromString($uuid);
		}
		return $this->repo->findById($uuid);
	}
}