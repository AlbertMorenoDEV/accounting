<?php
namespace accounting\clients\web\controllers;

use accounting\infrastructure\persistence\MySQLAccountRepository;

abstract class BaseController
{	
	protected $repos = [];
	protected $connection;
	protected $persistenceType;
	protected $idsType;
	protected $title;
	protected $version;

	public function __construct($config)
	{
		$this->connection = $config['connection'];
		$this->persistenceType = PERSISTENCE_TYPE;
		$this->idsType = ID_TYPE;
		$this->title = APP_TITLE;
		$this->version = VERSION." ".VERSION_TYPE;
	}

	public final function render($template, $data)
	{
		ob_start();
		include dirname(__DIR__)."/templates/$template.tpl.php";
		$title = $this->title;
		$version = $this->version;
		$content = ob_get_clean();
		include dirname(__DIR__)."/templates/base.tpl.php";
	}

	public final function getRepository($repoName)
	{
		if (!array_key_exists($repoName, $this->repos)) {
			$name = "accounting\infrastructure\\persistence\\".$this->persistenceType.ucfirst($repoName)."Repository";
			if (class_exists($name)) $this->repos[$repoName] = new $name($this->connection);
			else throw new \Exception("Repository $name not exists");
		}
		return $this->repos[$repoName];
	}

	public final function getIdsGenerator($type)
	{
		$name = "accounting\infrastructure\\ids\\".ucfirst($type).$this->idsType;
		if (class_exists($name)) return new $name;
		
		throw new \Exception("Ids generator for $type not exists");
	}

}