 <?php include './librerias/cabecera.php'; ?>
<p>  </p>
<?php
	include './librerias/connection.php';

	$sql = "CALL view_accounts(" . $_SESSION['action_id'] . "," . $_POST['account_id'] . ")";
	$data = call_multiquery($sql);
	$row = mysqli_fetch_assoc($data)
                
        // de $row se obtienen todos los datos de la cuenta origen
                
       
?>

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-estilo.css" />    

<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/calendar-es.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>



<form name="input" method="post" action="validacion.php">


<table border=0>
	<tr><th>CUENTA ORIGEN:</th><td> <?=$row['account']?> <input type="hidden" name="account_origin" value="<?=$_POST['account_id']?>"></td></tr>
	<tr><th>CUENTA DESTINO:</th><td><input type="text" name="account_dest_pre" value="<?=$row['pre_number']?>" style="width: 40px">@<input type="text" name="account_dest_root" value="<?=$row['root_number']?>" style="width: 120px"> </td></tr>
	<tr><th>CANTIDAD:</th><td><input type="text" name="amount"> </td></tr>
	<tr style='display:none;'><th>FECHA: </th><td><input type="text" name="fecha" style="display:none" id="fecha" style="width: 220px" value="HOY" align="center"><input type="hidden" name="scheduled_date" id="scheduled_date" value="<?= date('Y-m-d') ?>" /> </td></tr>
	<tr><th>DESCRIPCION:</th><td><input type="text" name="description" style="width: 220px"> </td></tr>
	<tr><td colspan=2><input type="submit" name="action" value="Enviar"></td></tr>
</table>




</form>

<a href="inicio.php">Inicio</a>


<script type="text/javascript">
Calendar.setup({
  inputField: "scheduled_date",
  ifFormat:   "%Y-%m-%d",
  weekNumbers: false,
  displayArea: "fecha",
  daFormat:    "%A, %d de %B de %Y"
});
</script>


 <?php include './librerias/pie.php'; ?>