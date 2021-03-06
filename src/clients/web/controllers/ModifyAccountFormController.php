<?php
namespace accounting\clients\web\controllers;

use accounting\aplication\ViewAccount;

class ModifyAccountFormController extends BaseController
{
	public function execute($request, $response)
	{
		$usecase = new ViewAccount($this->getRepository('account'), $this->getIdsGenerator('account'));
		$result = $usecase->execute($request['id']);

		$this->render("modify-account-form", $result);
	}
}