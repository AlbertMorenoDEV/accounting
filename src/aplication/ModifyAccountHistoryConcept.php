<?php
namespace accounting\aplication;

use accounting\model\AccountHistoryId;
use accounting\model\AccountHistoryRepository;
use accounting\model\Money;

class ModifyAccountHistoryConcept
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountHistoryRepository $repo, AccountHistoryId $accountHistoryId)
	{
		$this->repo = $repo;
		$this->idGenerator = $accountHistoryId;
	}

	public function execute($uuid, $newConcept)
	{
		if (is_string($uuid)) {
			$idGenerator = $this->idGenerator;
			$uuid = $idGenerator::fromString($uuid);
		}
		$accountHistory = $this->repo->findById($uuid);
		$accountHistory->setConcept($newConcept);
		$this->repo->add($accountHistory);
		$this->repo->save();
	}
}