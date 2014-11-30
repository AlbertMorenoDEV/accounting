<?php
namespace accounting\aplication;

use accounting\model\AccountHistoryId;
use accounting\model\AccountHistoryRepository;

class ViewAccountHistory
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountHistoryRepository $repo, AccountHistoryId $accountId)
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