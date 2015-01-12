<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\CreateAccount;

class AccountFormController extends BaseController
{
	public function execute($request, $response)
	{
		$this->render("account-form", false);
	}
}