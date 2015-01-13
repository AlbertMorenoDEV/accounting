<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\CreateAccountHistory;
use accounting\aplication\ViewAccount;

class CreateAccountHistoryFormController extends BaseController
{
	public function execute($request, $response)
	{
		$usecase = new ViewAccount($this->getRepository('account'), $this->getIdsGenerator('account'));
		$result = $usecase->execute($request['id_account']);
		
		$this->render("new-account-history-form", $result);
	}
}