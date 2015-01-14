<?php
namespace accounting\clients\web\controllers;

use accounting\infrastructure\ids\AccountHistoryUuid;
use accounting\infrastructure\ids\AccountUuid;
use accounting\aplication\CreateAccountHistory;
use accounting\model\Money;

class CreateAccountHistoryController extends BaseController
{
	public function execute($request, $response)
	{
		$account = $this->getRepository('account')->findById(AccountUuid::fromString($request["accountId"]));
		$amount = new Money($request["amount"]);
		$date = new \DateTime($request["date"]);
		$concept = $request["concept"];
		
		$usecase = new CreateAccountHistory($this->getRepository('accountHistory'), $this->getIdsGenerator('accountHistory'));
		$result = $usecase->execute($account, $amount, $date, $concept);
		$result = $this->getRepository('accountHistory')->findById(AccountHistoryUuid::fromString($result));
		
		$this->render("create-account-history", $result);
	}
}