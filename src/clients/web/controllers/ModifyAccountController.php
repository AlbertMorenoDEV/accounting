<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\CreateAccount;

class ModifyAccountController extends BaseController
{
	public function execute($request, $response)
	{
		$usecase = new ModifyAccountName($this->getRepository('account'), $this->getIdsGenerator('account'));
		$usecase->execute($request["uuid"], $request["name"]);
		
		$usecase = new ViewAccount($this->getRepository('account'), $this->getIdsGenerator('account'));
		$result = $usecase->execute($request['uuid']);
		$this->render("modify-account", $result);
	}
}