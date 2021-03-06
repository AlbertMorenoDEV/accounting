<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\CreateAccount;

class CreateAccountController extends BaseController
{
	public function execute($request, $response)
	{
		$usecase = new CreateAccount($this->getRepository('account'), $this->getIdsGenerator('account'));
		$usecase->execute($request["name"], $request["total"]);
		$result = $this->getRepository('account')->all()[0];
		
		$this->render("create-account", $result);
	}
}