<?php

include('header.php');
include('header_verif.php');

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
	<div align="center"><p class="mens"><?php print $mens ?></p></div>
<?php } ?>
<br>
<form name="form1" id="form1" method="post">
	<div align="center">
		<table class="text_normal" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td align="center" class="table_titulo" colspan="4">&nbsp;Listar Salas&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="table_titulo">&nbsp;Número&nbsp;</td>
				<td align="center" class="table_titulo">&nbsp;Status&nbsp;</td>
				<td align="center" class="table_titulo">&nbsp;Ação&nbsp;</td>
			</tr>
			<?php
			
			$table_salas = new Table_DB('salas');
		
			$arr_results = $table_salas->getAll(false, false, array('id'));
			
			if (count($arr_results) > 0) {
			
				foreach ($arr_results as $arr_result) {
			
				?>			
				<tr>
					<td align="center"><?php print $arr_result['numero']; ?></td>
					<td align="center"><?php if ($arr_result['ativo'] == '1') { print '<font color=blue>ATIVO</font>'; } else { print '<font color=red>INATIVO</font>'; } ?></td>
					<td align="center"><a href="sala.php?id=<?php print $arr_result['id']; ?>" class="link_lista">EDITAR</a></td>
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