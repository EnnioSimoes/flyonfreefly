<?php
function printa($v, $dump = 0)
{
	echo '<pre>';
	if ($dump) {
		var_dump($v);
	} else {
		print_r($v);
	}
	echo '</pre>';
}

function __autoload($classe)
{
	$arquivo = $classe . '.php';
	$diretorios = [_DIR_CONTROLLERS_, _DIR_MODELS_, _DIR_VIEWS_, _DIR_HELPERS_];

	foreach ($diretorios as $d) {
		if (file_exists($d . $arquivo)) {
			require_once $d . $arquivo;
			return;
		}
	}

	die('Classe nao encontrada');
}
