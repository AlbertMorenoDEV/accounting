<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\ViewAccountHistory;

class ViewAccountHistoryController extends BaseController
{
	public function execute($request, $response)
	{
		$usecase = new ViewAccountHistory($this->getRepository('accountHistory'), $this->getIdsGenerator('accountHistory'));
		$result = $usecase->execute($request['id']);

		$this->render("view-account-history", $result);
	}
}