<?php
// pillamos la configuración de la app
$config = require_once dirname(__DIR__).'/config/ini.php';
// arrancamos la app
require_once dirname(__DIR__).'/config/bootstrap.php';

// router casero cutre
$controlador = substr($_SERVER['PATH_INFO'], 1, strlen($_SERVER['PATH_INFO'])).'Controller';

if (is_readable(CONTROLADORES_PATH."/{$controlador}.php")) {
	try {
		require CONTROLADORES_PATH."/{$controlador}.php";
		$clase = "liveSimulator\\clientes\\web\\controladores\\$controlador";
		$controlador = new $clase($config);
		echo $controlador->execute($_GET, "");
	} catch (Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
		echo "<h1>500 Internal Server Error</h1>";
		if (ENTORNO === 'dev') echo $e->getMessage();
	}
} else {
	header('HTTP/1.0 404 Not Found');
	echo "<h1>404 Not Found</h1>".PHP_EOL;
	echo "The page that you have requested could not be found.";
	if (ENTORNO === 'dev') echo "<p>$controlador</p>";
}