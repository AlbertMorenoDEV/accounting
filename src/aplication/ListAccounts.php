<?php
namespace accounting\aplication;

use accounting\model\AccountId;
use accounting\model\AccountRepository;

class ListAccounts
{
	private $repo;

	public function __construct(AccountRepository $repo)
	{
		$this->repo = $repo;
	}

	public function execute($nameFilter = "")
	{
		assert(is_string($nameFilter), "Error in name filter");

		return $this->repo->findByName($nameFilter);
	}
}