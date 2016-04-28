<?php

include('header.php');
include('header_verif.php');

if ($_REQUEST['action'] == 'Inserir') {

	if (trim($_REQUEST['nome']) && trim($_REQUEST['login']) && trim($_REQUEST['senha']) && trim($_REQUEST['senha_2'])) {

		$table_usuarios = new Table_DB('usuarios');
		
		$arr_result = $table_usuarios->getRow(array('id'), array('nome' => trim($_REQUEST['nome'])), false);
		
		if ($arr_result['id']) {
		
			$mens = "Nome já foi cadastrado!";
		
		}
	
		$arr_result = $table_usuarios->getRow(array('id'), array('login' => trim($_REQUEST['login'])), false);
		
		if ($arr_result['id']) {
		
			$mens = "Login já foi cadastrado!";
		
		}
		
		if (!$mens) {
		
			if ($_REQUEST['ativo'] == '1') {
				$ativo = '1';
			} else {
				$ativo = '0';
			}
			
			$table_usuarios->insert(array('nome' => trim($_REQUEST['nome']), 'login' => trim($_REQUEST['login']), 'senha' => trim(md5($_REQUEST['senha'])), 'ativo' => $ativo));
			
			$mens = "Usuário inserido!";
		
		}

	} else {
	
		header("Location: main.php");
		exit;
	
	}

}

if ($_REQUEST['action'] == 'Editar') {

	if (($_REQUEST['id']) && trim($_REQUEST['nome']) && trim($_REQUEST['login'])) {

		$table_usuarios = new Table_DB('usuarios');
		
		$id = $table_usuarios->DB->real_escape_string(trim($_REQUEST['id']));
		$nome = $table_usuarios->DB->real_escape_string(trim($_REQUEST['nome']));
		
		$arr_result = $table_usuarios->_getRow("SELECT id FROM usuarios WHERE id <> ".$id." AND nome = '".$nome."'");
		
		if ($arr_result['id']) {
		
			$mens = "Nome já foi cadastrado!";
		
		}
	
		$login = $table_usuarios->DB->real_escape_string(trim($_REQUEST['login']));

		$arr_result = $table_usuarios->_getRow("SELECT id FROM usuarios WHERE id <> ".$id." AND login = '".$login."'");
		
		if ($arr_result['id']) {
		
			$mens = "Login já foi cadastrado!";
		
		}
		
		if (!$mens) {
		
			if ($_REQUEST['ativo'] == '1') {
				$ativo = '1';
			} else {
				$ativo = '0';
			}
			
			$table_usuarios->set($id);
			
			if (trim($_REQUEST['senha'])) {
				$table_usuarios->update(array('nome' => trim($_REQUEST['nome']), 'login' => trim($_REQUEST['login']), 'senha' => md5(trim($_REQUEST['senha'])), 'ativo' => $ativo));
			} else {
				$table_usuarios->update(array('nome' => trim($_REQUEST['nome']), 'login' => trim($_REQUEST['login']), 'ativo' => $ativo));			
			}
			
			$mens = "Usuário editado!";
		
		}

	} else {
	
		header("Location: main.php");
		exit;
	
	}

}

if ($_REQUEST['id']) {

	$table_usuarios = new Table_DB('usuarios');
		
	$arr_usuario = $table_usuarios->getRow(false, array('id' => intval($_REQUEST['id'])), false);
	
	if (!$arr_usuario['id']) {
	
		header("Location: main.php");
		exit;
	
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

            jQuery('#nome').rules('add', { required: true, minlength: 5, messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres'} });
            jQuery('#login').rules('add', { required: true, minlength: 5, messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres'} });
            
			<?php if ($_REQUEST['id']) { ?>
			
			jQuery('#senha').rules('add', { minlength: 5, messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres'} });
            jQuery('#senha_2').rules('add', { minlength: 5, equalTo: '#senha', messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres', equalTo: '* Confirme a senha'} });
			
			<?php } else { ?>
			
			jQuery('#senha').rules('add', { required: true, minlength: 5, messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres'} });
            jQuery('#senha_2').rules('add', { required: true, minlength: 5, equalTo: '#senha', messages: { required: '* Campo deve ser preenchido', minlength: '* Mínimo de 5 caracteres', equalTo: '* Confirme a senha'} });

			<?php } ?>

        });
    
    </script>
</head>
<body>
<br>
<?php include('menu.php'); ?>
<br>
<?php if ($mens) { ?>
	<div align="center" id="mens"><p class="mens"><?php print $mens ?></p></div>
	<script> $("#mens").fadeOut(5000, function() { $(this).remove(); }); </script>
<?php } ?>
<br>
<form name="form1" id="form1" method="post">
	<div align="center">
		<table class="text_normal" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td align="center" class="table_titulo" colspan="2">&nbsp;<?php if ($_REQUEST['id']) { print "Editar"; } else { print "Inserir"; } ?> Usuário&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Nome</td>
				<td align="left"><input type="text" name="nome" id="nome" size="15" maxlength="50" value="<?php if ($arr_usuario['nome']) { print $arr_usuario['nome']; } ?>" /></td>
			</tr>
			<tr>
				<td align="right">Login</td>
				<td align="left"><input type="text" name="login" id="login" size="15" maxlength="15" value="<?php if ($arr_usuario['login']) { print $arr_usuario['login']; } ?>" /></td>
			</tr>
			<tr>
				<td align="right">Senha</td>
				<td align="left"><input type="password" name="senha" id="senha" size="10" maxlength="10" /></td>
			</tr>
			<tr>
				<td align="right">Confirmar Senha</td>
				<td align="left"><input type="password" name="senha_2" id="senha_2" size="10" maxlength="10" /></td>
			</tr>
			<tr>
				<td align="right">Ativo</td>
				<td align="left"><input type="checkbox" name="ativo" id="ativo" class="text_input" value="1" <?php if (($arr_usuario['ativo'] == 1) || (!$_REQUEST['id'])) { print 'checked'; } ?> /></td>
			</tr>
			<tr>
				<th colspan="2">
				<?php 
				if ($_REQUEST['id']) {
				?>
				<input type="submit" name="action" id="action" value="Editar" />
				<?php
				} else {
				?>
				<input type="submit" name="action" id="action" value="Inserir" />				
				<?php
				}
				?>
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="id" id="id" value="<?php print $_REQUEST['id']; ?>" /> 
</form>
</body>
</html>