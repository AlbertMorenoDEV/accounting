<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\ListAccountHistories;
use accounting\infrastructure\ids\AccountUuid;

class ListAccountHistoriesController extends BaseController
{
	public function execute($request, $response)
	{
		$account = $this->getRepository('account')->findById(AccountUuid::fromString($_GET["id_account"]));
		
		$usecase = new ListAccountHistories($this->getRepository('accountHistory'), $account);
		$result = $usecase->execute();

		$this->render("list-account-histories", $result);
	}
}