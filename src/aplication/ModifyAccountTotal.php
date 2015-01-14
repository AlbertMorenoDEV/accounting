<?php
namespace accounting\aplication;

use accounting\model\AccountId;
use accounting\model\AccountRepository;
use accounting\model\Money;

class ModifyAccountTotal
{
	private $repo;
	private $idGenerator;

	public function __construct(AccountRepository $repo, AccountId $accountId)
	{
		$this->repo = $repo;
		$this->idGenerator = $accountId;
	}

	public function execute($uuid, $newTotal)
	{
		if (is_string($uuid)) {
			$idGenerator = $this->idGenerator;
			$uuid = $idGenerator::fromString($uuid);
		}
		$account = $this->repo->findById($uuid);
		$account->setTotal(new Money($newTotal));
		$account->setModificationDate(new \DateTime);
		$this->repo->add($account);
		$this->repo->save();
	}
}