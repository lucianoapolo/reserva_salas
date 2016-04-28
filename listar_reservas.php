<?php

include('header.php');
include('header_verif.php');

if (($_REQUEST['action'] == 'remover') && ($_REQUEST['id'])) {

	$table_reservas = new Table_DB('reservas');

	$arr_reserva = $table_reservas->getRow(array('id_usuarios'), array('id' => intval($_REQUEST['id'])), false);
	
	if (intval($arr_reserva['id_usuarios']) == intval($_SESSION['id_usuario'])) {
	
		$table_reservas->set(intval($_REQUEST['id']));	
		$table_reservas->delete();
		
		$mens = "Reserva removida!";
	
	} else {
	
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
				<td align="center" class="table_titulo" colspan="6">&nbsp;Listar Reservas&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="table_titulo">&nbsp;Nome&nbsp;</td>
				<td align="center" class="table_titulo">&nbsp;Sala&nbsp;</td>
				<td align="center" class="table_titulo">&nbsp;Data&nbsp;</td>
				<td align="center" class="table_titulo">&nbsp;Horario Entrada&nbsp;</td>
				<td align="center" class="table_titulo">&nbsp;Horario Saída&nbsp;</td>
				<td align="center" class="table_titulo">&nbsp;Ação&nbsp;</td>
			</tr>
			<?php
			
			$table_reservas = new Table_DB('reservas');
		
			$arr_results = $table_reservas->_getAll("SELECT reservas.id, usuarios.id AS id_usuario, usuarios.nome, salas.numero, DATE_FORMAT(data_entrada, '%d/%m/%Y') AS data_format, DATE_FORMAT(reservas.data_entrada, '%H:%i') AS hora_entrada, DATE_FORMAT(reservas.data_saida, '%H:%i') AS hora_saida FROM reservas INNER JOIN usuarios ON reservas.id_usuarios = usuarios.id INNER JOIN salas ON reservas.id_salas = salas.id ORDER BY reservas.data_entrada");
			
			if (count($arr_results) > 0) {
			
				foreach ($arr_results as $arr_result) {
			
				?>			
				<tr>
					<td align="center"><?php print $arr_result['nome']; ?></td>
					<td align="center"><?php print $arr_result['numero']; ?></td>
					<td align="center"><?php print $arr_result['data_format']; ?></td>
					<td align="center"><?php print $arr_result['hora_entrada']; ?></td>
					<td align="center"><?php print $arr_result['hora_saida']; ?></td>
					<td align="center"><?php if (intval($_SESSION['id_usuario']) == intval($arr_result['id_usuario'])) { ?><a href="listar_reservas.php?action=remover&id=<?php print $arr_result['id']; ?>" class="link_lista">REMOVER</a><?php } ?></td>
				</tr>
				<?php
				
				}
			
			}
			
			?>
		</table>
	</div>
</form>
</body>
</html>