<?php

$path = realpath(__DIR__ . '/src');
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

function autoload($className) {
	$file = 'src/' . $className . '.php';

	if (file_exists($file)) {
		require $className . '.php';
	}
}

spl_autoload_register('autoload');
