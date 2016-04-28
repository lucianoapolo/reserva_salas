<?php

session_start();

if ($_SESSION['id_usuario'] && $_SESSION['senha_usuario']) {

	$table_usuarios = new Table_DB('usuarios');
		
	$arr_result = $table_usuarios->getRow(array('id'), array('id' => intval($_SESSION['id_usuario']), 'senha' => $_SESSION['senha_usuario']), false);

	if (!$arr_result['id']) {
		header("Location: index.php");
		exit;
	}

} else {
	header("Location: index.php");
	exit;
}

?>
