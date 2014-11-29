<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\ListAccounts;

class ListAccountsController extends BaseController
{
	public function execute($request, $response)
	{

		$usecase = new ListAccounts($this->getRepository('account'));
		$result = $usecase->execute();

		$this->render("list-accounts", $result);
	}
}