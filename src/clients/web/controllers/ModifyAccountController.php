<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\ModifyAccountName;
use accounting\aplication\ViewAccount;

class ModifyAccountController extends BaseController
{
	public function execute($request, $response)
	{
		$usecase = new ModifyAccountName($this->getRepository('account'), $this->getIdsGenerator('account'));
		$usecase->execute($request["id"], $request["name"]);
		
		$usecase = new ViewAccount($this->getRepository('account'), $this->getIdsGenerator('account'));
		$result = $usecase->execute($request['id']);
		$this->render("modify-account", $result);
	}
}