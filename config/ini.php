<?php
define(ENVIRONMENT, 'dev');
define(CONTROLLERS_PATH, dirname(__DIR__).'/src/clients/web/controllers');
date_default_timezone_set('Europe/Madrid');

$config['persistenceType'] = "MySQL";
$config['idsType'] = "Uuid";

$config['conection'] = new \MySQLi("127.0.0.1", "accounting", "");
$config['conection']->select_db("accounting");

return $config;