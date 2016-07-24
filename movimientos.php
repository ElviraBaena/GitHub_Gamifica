 <?php include './librerias/cabecera.php'; ?>
<h1>MOVIMIENTOS</h1>

<link href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"  rel="stylesheet" type="text/css" />
<link href="estilo/dataTables.jqueryui.css"  rel="stylesheet" type="text/css" />
<script src="librerias/jquery/jquery-1.11.1.min.js"></script> 
<script src="librerias/jquery/es/jquery.dataTables.min.js"></script> 
<script src="librerias/jquery/dataTables.jqueryui.js"></script> 
<script type="text/javascript">

	$(document).ready(function() {
		$('#tabla_resultados').dataTable();
	} );

//	$(document).ready(function() {
//		$('#tabla_resultados_futuros').dataTable();
//	} );
	
	
</script>
<?php
include './librerias/connection.php';

$begin_date=$_POST['begin_date'];
if (!isset($_POST['begin_date']))
	{
		$begin_date='2013-05-01';
	}
	
$end_date="'" . $_POST['end_date'] . "'";
if (!isset($_POST['end_date']))
	{
		$end_date='NOW()';
	}

$account_id=$_POST['account_id'];
if (!isset($_POST['account_id']))
	{
		$account_id=0;
	}


$sql = "CALL view_transactions(" . $_SESSION['action_id'] . "," . $account_id . ",'" . $begin_date . "'," . $end_date . ")";
$data = call_multiquery($sql);
?>



<table border=0 id="tabla_resultados" class="display" cellspacing="0" width="100%">
<?php 

	if ($_POST['account_id']==0)
	{
		echo '<thead><tr><th>Cuenta</th><th>Fecha</th><th>Transferencia</th><th>Descripcion</th><th>Entrada</th><th>Salida</th><th>Balance</th></tr></thead>';
	}
	else
	{
		echo '<thead><tr><th>Fecha</th><th>Transferencia</th><th>Descripcion</th><th>Entrada</th><th>Salida</th><th>Balance</th></tr></thead>';
	}
	echo "<tbody>";	
    while ($row = mysqli_fetch_assoc($data)) 
	{
		echo '<tr><td align="center">';
		echo $_POST['account_id']==0 ? $row['title'] . '</td><td align="center">' : '';
		echo $row['creation_date']  . '</td><td align="center">' . $row['transfer_id'] . '</td><td align="center">' . $row['description'] . '</td><td align="center">' . $row['income'] . '</td><td align="center">' . $row['outcome'] . '</td><td align="center">' . $row['balance'] . '</td></tr>';
	}
    mysqli_free_result($data);
	?>        
    </tbody>
</table>

<BR/><br/>



<!--<h1>TRANSFERENCIAS VALIDADAS</h1>-->


<?php

/*

$sql = "CALL view_transfers(" . $_SESSION['action_id'] . ",0," . $account_id . ",'SCHEDULED')";
$data = call_multiquery($sql);
*/
?>



<!--<table border=0 id="tabla_resultados_futuros" class="display" cellspacing="0" width="100%">-->
<?php 
/*
	if ($_POST['account_id']==0)
	{
		echo '<thead><tr><th>Cuenta</th><th>Fecha</th><th>Transferencia</th><th>Descripcion</th><th>Entrada</th><th>Salida</th><th>Balance</th></tr></thead>';
	}
	else
	{
		echo '<thead><tr><th>Fecha</th><th>Transferencia</th><th>Descripcion</th><th>Entrada</th><th>Salida</th><th>Balance</th></tr></thead>';
	}
	echo "<tbody>";	
       while ($row = mysqli_fetch_assoc($data)) 
	 {
		echo '<tr><td align="center">';
		echo $_POST['account_id']==0 ? $row['title'] . '</td><td align="center">' : '';
		echo $row['scheduled_date']  . '</td><td align="center">' . $row['transfer_id'] . '</td><td align="center">' . $row['description'] . '</td><td align="center">' . $row['income'] . '</td><td align="center">' . $row['outcome'] . '</td><td align="center">' . $row['balance'] . '</td></tr>';
        }
       mysqli_free_result($data);
*/       
	?> 
<!--	</tbody>-->	
<!--</table>-->

      









<a href="inicio.php">Inicio</a>
 <?php include './librerias/pie.php'; ?>