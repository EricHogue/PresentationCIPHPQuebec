<?php

$path = realpath(dirname(__FILE__) . '/../');
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

function autoload($className) {
	$file = $className . '.php';
	if (file_exists($file)) {
		require $className . '.php';
	}
}

spl_autoload_register('autoload');

