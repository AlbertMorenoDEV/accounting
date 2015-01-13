<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\CreateAccountHistory;

class CreateAccountHistoryFormController extends BaseController
{
	public function execute($request, $response)
	{
		$this->render("new-account-history-form", false);
	}
}