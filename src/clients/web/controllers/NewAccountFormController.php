<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\CreateAccount;

class NewAccountFormController extends BaseController
{
	public function execute($request, $response)
	{
		$this->render("new-account-form", false);
	}
}