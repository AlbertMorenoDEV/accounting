<?php
// app config
$config = require_once dirname(__DIR__).'/config/ini.php';

// app start
require_once dirname(__DIR__).'/config/bootstrap.php';

// router
$controler = substr($_SERVER['PATH_INFO'], 1, strlen($_SERVER['PATH_INFO'])).'Controller';
if ($controler=="Controller") $controler = DEFAULT_CONTROLLER.'Controller';

if (is_readable(CONTROLLERS_PATH."/{$controler}.php")) {
	try {
		require CONTROLLERS_PATH."/{$controler}.php";
		$clase = "accounting\\clients\\web\\controllers\\$controler";
		$controler = new $clase($config);
		echo $controler->execute($_GET, "");
	} catch (Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
		echo "<h1>500 Internal Server Error</h1>";
		if (ENVIRONMENT === 'dev') echo "(".$e->getCode()."): ".$e->getMessage()." @ ".$e->getFile().":".$e->getLine();
	}
} else {
	header('HTTP/1.0 404 Not Found');
	echo "<h1>404 Not Found</h1>".PHP_EOL;
	echo "The page that you have requested could not be found.";
	if (ENVIRONMENT === 'dev') echo "<p>$controler</p>";
}