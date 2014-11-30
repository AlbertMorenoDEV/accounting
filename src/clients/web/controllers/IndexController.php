<?php
namespace accounting\clients\web\controllers;

class IndexController extends BaseController
{
	public function execute($request, $response)
	{
		$this->render("index", "");
	}
}