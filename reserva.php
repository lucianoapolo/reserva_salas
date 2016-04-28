<?php

include('header.php');
include('header_verif.php');

$timeout_msg = 5000;

if ($_REQUEST['action'] == 'Inserir') {

	if (($_SESSION['id_usuario']) && ($_REQUEST['id_sala']) && ($_REQUEST['data']) && ($_REQUEST['horario'])) {

		$table_reservas = new Table_DB('reservas');
		
		list($dia, $mes, $ano) = explode("/", $_REQUEST['data']);
		
		if (checkdate($mes, $dia, $ano) && preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $_REQUEST['horario'])) {
		
			$id_usuario = $table_reservas->DB->real_escape_string(trim($_SESSION['id_usuario']));
			$data = $table_reservas->DB->real_escape_string(trim($ano."-".$mes."-".$dia." ".$_REQUEST['horario']));
		
			$arr_result = $table_reservas->_getRow("SELECT id, DATE_FORMAT(data_entrada, '%H:%i') AS hora_entrada, DATE_FORMAT(data_saida, '%H:%i') AS hora_saida FROM reservas WHERE id_usuarios = ".intval($id_usuario)." AND '".$data."' BETWEEN data_entrada AND data_saida");
		
			if ($arr_result['id']) {
			
				$mens = "Usuário já tem uma reserva de sala nesta data entre ".$arr_result['hora_entrada']." e ".$arr_result['hora_saida']." horas!";
				
				$timeout_msg = 12000;
			
			}
		
			$id_sala = $table_reservas->DB->real_escape_string(trim($_REQUEST['id_sala']));

			$arr_result = $table_reservas->_getRow("SELECT id, DATE_FORMAT(data_entrada, '%H:%i') AS hora_entrada, DATE_FORMAT(data_saida, '%H:%i') AS hora_saida FROM reservas WHERE id_salas = ".intval($id_sala)." AND '".$data."' BETWEEN data_entrada AND data_saida");
		
			if ($arr_result['id']) {
			
				$mens = "Sala já está reservada nesta data entre ".$arr_result['hora_entrada']." e ".$arr_result['hora_saida']." horas!";
			
				$timeout_msg = 12000;
				
			}

		} else {
		
			header("Location: main.php");
			exit;
		
		}
		
		if (!$mens) {
		
			$data_entrada = date("Y-m-d H:i:s", strtotime(trim($ano."-".$mes."-".$dia." ".$_REQUEST['horario'])));
			$data_saida = date("Y-m-d H:i:s", strtotime("+59 minute", strtotime(trim($ano."-".$mes."-".$dia." ".$_REQUEST['horario']))));
			
			$table_reservas->insert(array('id_usuarios' => intval($_SESSION['id_usuario']), 'id_salas' => intval($_REQUEST['id_sala']), 'data_entrada' => $data_entrada, 'data_saida' => $data_saida));
			
			$mens = "Reserva inserida!";
		
		}

	} else {
	
		header("Location: main.php");
		exit;
	
	}

}

if ($_SESSION['id_usuario']) {

	$table_usuarios = new Table_DB('usuarios');
		
	$arr_usuario = $table_usuarios->getRow(false, array('id' => intval($_SESSION['id_usuario'])), false);
	
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
    <script src="Scripts/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="Scripts/additional-methods.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">

        jQuery(function () {

            jQuery('#form1').validate();

            jQuery('#id_sala').rules('add', { required: true,  messages: { required: '* Selecione uma opção'} });
            jQuery('#data').rules('add', { required: true, dateITA: true,  messages: { required: '* Campo deve ser preenchido', dateITA: '* Data inválida'} });
            jQuery('#horario').rules('add', { required: true, time: true,  messages: { required: '* Campo deve ser preenchido', time: '* Hora inválida'} });
			
			jQuery("#data").mask("99/99/9999", {placeholder:" "});
			jQuery("#horario").mask("99:99", {placeholder:" "});

        });
    
    </script>
</head>
<body>
<br>
<?php include('menu.php'); ?>
<br>
<?php if ($mens) { ?>
	<div align="center" id="mens"><p class="mens"><?php print $mens ?></p></div>
	<script> $("#mens").fadeOut(<?php print $timeout_msg; ?>, function() { $(this).remove(); }); </script>
<?php } ?>
<br>
<form name="form1" id="form1" method="post">
	<div align="center">
		<table class="text_normal" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td align="center" class="table_titulo" colspan="2">&nbsp;Inserir Reserva&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Usuário</td>
				<td align="left"><input type="text" name="nome" id="nome" size="15" value="<?php if ($arr_usuario['nome']) { print $arr_usuario['nome']; } ?>" /></td>
			</tr>
			<tr>
				<td align="right">Sala</td>
				<td align="left">
					<select name="id_sala" id="id_sala">
						<option value="">-- Selecione uma Sala --</option> 
						<?php
						
						$table_salas = new Table_DB('salas');
						
						$arr_salas = $table_salas->getAll(array('id', 'numero'), array('ativo' => '1'), array('numero'));
						
						foreach ($arr_salas as $arr_sala) {
						
							?><option value="<?php print $arr_sala['id']; ?>"><?php print $arr_sala['numero'] ?></option><?php
						
						}
						
						?>
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">Data</td>
				<td align="left"><input type="text" name="data" id="data" size="15" /></td>
			</tr>
			<tr>
				<td align="right">Horário</td>
				<td align="left"><input type="text" name="horario" id="horario" size="10" /></td>
				</td>
			</tr>
			<tr>
				<th colspan="2"><input type="submit" name="action" id="action" value="Inserir" /></td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="id" id="id" value="<?php print $_REQUEST['id']; ?>" /> 
</form>
</body>
</html>