<?php

include('header.php');
include('header_verif.php');

if ($_REQUEST['action'] == 'Inserir') {

	if (trim($_REQUEST['numero'])) {

		$table_salas = new Table_DB('salas');
		
		$arr_result = $table_salas->getRow(array('id'), array('numero' => trim($_REQUEST['numero'])), false);
		
		if ($arr_result['id']) {
		
			$mens = "Número já foi cadastrado!";
		
		}
		
		if (!$mens) {
		
			if ($_REQUEST['ativo'] == '1') {
				$ativo = '1';
			} else {
				$ativo = '0';
			}
			
			$table_salas->insert(array('numero' => trim($_REQUEST['numero']), 'ativo' => $ativo));
			
			$mens = "Sala inserida!";
		
		}

	} else {
	
		header("Location: main.php");
		exit;
	
	}

}

if ($_REQUEST['action'] == 'Editar') {

	if (($_REQUEST['id']) && trim($_REQUEST['numero'])) {

		$table_salas = new Table_DB('salas');
		
		$id = $table_salas->DB->real_escape_string(trim($_REQUEST['id']));
		$numero = $table_salas->DB->real_escape_string(trim($_REQUEST['numero']));
		
		$arr_result = $table_salas->_getRow("SELECT id FROM salas WHERE id <> ".$id." AND numero = '".$numero."'");
		
		if ($arr_result['id']) {
		
			$mens = "Número já foi cadastrado!";
		
		}
		
		if (!$mens) {
		
			if ($_REQUEST['ativo'] == '1') {
				$ativo = '1';
			} else {
				$ativo = '0';
			}
			
			$table_salas->set($id);

			$table_salas->update(array('numero' => trim($_REQUEST['numero']), 'ativo' => $ativo));			
			
			$mens = "Sala editada!";
		
		}

	} else {
	
		header("Location: main.php");
		exit;
	
	}

}

if ($_REQUEST['id']) {

	$table_salas = new Table_DB('salas');
		
	$arr_sala = $table_salas->getRow(false, array('id' => intval($_REQUEST['id'])), false);
	
	if (!$arr_sala['id']) {
	
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

            jQuery('#numero').rules('add', { required: true, digits: true,  messages: { required: '* Campo deve ser preenchido', digits: '* Apenas dígitos' } });

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
				<td align="center" class="table_titulo" colspan="2">&nbsp;<?php if ($_REQUEST['id']) { print "Editar"; } else { print "Inserir"; } ?> Sala&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Número</td>
				<td align="left"><input type="text" name="numero" id="numero" size="10" maxlength="5" value="<?php if ($arr_sala['numero']) { print $arr_sala['numero']; } ?>" /></td>
			</tr>
			<tr>
				<td align="right">Ativo</td>
				<td align="left"><input type="checkbox" name="ativo" id="ativo" class="text_input" value="1" <?php if (($arr_sala['ativo'] == 1) || (!$_REQUEST['id'])) { print 'checked'; } ?> /></td>
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