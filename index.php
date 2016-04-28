<?php

include('header.php');

if ($_REQUEST['logar'] == "Logar") {

	$mens = "Login e ou Senha incorretos!";

	if (trim($_REQUEST['login']) && trim($_REQUEST['senha'])) {

		$table_usuarios = new Table_DB('usuarios');
		
		$arr_usuario = $table_usuarios->getRow(false, array('login' => trim($_REQUEST['login']), 'senha' => trim(md5($_REQUEST['senha']))), false);
		
		if ($arr_usuario['id']) {
		
			session_start();
		
			$_SESSION['id_usuario'] = $arr_usuario['id'];
			$_SESSION['nome_usuario'] = $arr_usuario['nome'];
			$_SESSION['senha_usuario'] = $arr_usuario['senha'];
			
			header("Location: main.php");
		
		}
		
	}

}

?>
<html>
<head>
	<title>Sistema de Reserva de Salas</title>
	<meta charset="utf-8">
    <link href="Styles/StyleSheet.css" rel="stylesheet" type="text/css" />
    <script src="Scripts/jquery-1.7.1.js" type="text/javascript"></script>
    <script src="Scripts/jquery.validate.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">

        jQuery(function () {

            jQuery('#form1').validate();

            jQuery('#login').rules('add', { required: true, minlength: 5, messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres'} });
            jQuery('#senha').rules('add', { required: true, minlength: 5, messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres'} });

        });
    
    </script>
</head>
<body>
<br>
<br>
<br>
<?php if ($mens) { ?>
	<div align="center"><p class="mens"><?php print $mens ?></p></div>
<?php } ?>
<form name="form1" id="form1" method="post">
	<div align="center">
		<table class="text_normal" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td align="center" class="table_titulo" colspan="2">&nbsp;Sistema de Reserva de Salas&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Login</td>
				<td align="left"><input type="text" name="login" id="login" size="15" maxlength="15" /></td>
			</tr>
			<tr>
				<td align="right">Senha</td>
				<td align="left"><input type="password" name="senha" id="senha" size="10" maxlength="10" /></td>
			</tr>
			<tr>
				<th colspan="2"><input type="submit" name="logar" id="logar" value="Logar" /></td>
			</tr>
		</table>
	</div>
</form>
</body>
</html>