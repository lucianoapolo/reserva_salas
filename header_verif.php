<?php

session_start();

if ($_SESSION['id_usuario']) {

	$table_usuarios = new Table_DB('usuarios');
		
	$arr_usuario = $table_usuarios->getRow(array('id'), array('id' => $_SESSION['id_usuario'], 'senha' => $_SESSION['senha_usuario']), false);

	if (!$arr_usuario['id']) {
		header("Location: index.php");
		exit;
	}

} else {
	header("Location: index.php");
	exit;
}

?>
