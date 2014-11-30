<?php
namespace accounting\aplication;

use accounting\model\AccountHistoryId;
use accounting\model\AccountHistoryRepository;

class ListAccountHistories
{
	private $repo;

	public function __construct(AccountHistoryRepository $repo)
	{
		$this->repo = $repo;
	}

	public function execute($conceptFilter = "")
	{
		assert(is_string($conceptFilter), "Error in concept filter");

		return $this->repo->findByConcept($conceptFilter);
	}
}