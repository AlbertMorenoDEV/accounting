<?php
date_default_timezone_set('Europe/Madrid');
define(ENVIRONMENT, 'dev');
define(CONTROLLERS_PATH, dirname(__DIR__).'/src/clients/web/controllers');

define(PERSISTENCE_TYPE, "MySQL");
define(ID_TYPE, "Uuid");
define(APP_TITLE, "Accounting");
define(VERSION, "1.00");
define(VERSION_TYPE, "beta");

$config['connection'] = new \MySQLi("127.0.0.1", "accounting", "");
$config['connection']->select_db("accounting");

return $config;