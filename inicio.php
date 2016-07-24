 <?php include './librerias/cabecera.php'; ?>
 

<script type="text/javascript">

	$(document).ready(function() {
		$('#mis_cuentas').dataTable();
	} );

	$(document).ready(function() {
		$('#notificaciones').dataTable();
	} );
	
	
</script>
<p>  </p>
<?php
	include './librerias/connection.php';

	$sql = "CALL view_accounts(" . $_SESSION['action_id'] . ",0)";
  //echo "sql  $sql ";
  //echo "SESSION['mysql_user']" .     $_SESSION['mysql_user'];
  //echo "SESSION['mysql_pass']".  $_SESSION['mysql_pass'];
 
        $data = call_multiquery($sql);
        
        
        
?>

<script type="text/javascript">
	function subm(f,page)
		{
			document.panel_cuentas.action = page ;
			f.submit();
		}
</script>
 
<form name="panel_cuentas" method="post" action="">

<table border=0 class="display" cellspacing="0" width="100%">
	<tr><th colspan=3><h2>MIS CUENTAS</h2></th><td colspan=2><input type="button" name="action" value="Transferencia" onclick="subm(this.form,'transfer.php');"></td><td colspan=2><input type="button" name="action" value="Movimientos" onclick="subm(this.form,'movimientos.php');"></td></tr>
</table>
<table border=0 id="mis_cuentas" class="display" cellspacing="0" width="100%">


	<thead><tr><th>Seleccione</th><th>Cuenta</th><th>Titulo</th><th>Balance</th><th>Privilegio</th><th>Notificaciones</th><th>Tipo</th></tr></thead>
	<tbody>
	<?php	  
			$i=0;
            while ($row = mysqli_fetch_assoc($data)) 
		 {
     //echo 'prueba fila' . print_r($row, true);
			if ($i==0)
			{
				echo '<tr align="center"><td><input type="radio" checked name="account_id" value="' . $row['id'] . '"></td><td align="center">' . $row['account'] . '</td><td align="center">';
				$i=1;
			} else
			{
				echo '<tr align="center"><td><input type="radio" name="account_id" value="' . $row['id'] . '"></td><td align="center">' . $row['account'] . '</td><td align="center">';
			}
			echo  $row['title'] . '</td><td align="center">' . $row['balance'] . '</td><td align="center">' .  $row['transfer_priv'] . '</td><td align="center">';
			echo  $row['notification_type'] . '</td><td align="center">' . $row['type'] . '</td></tr>';
	        }
            mysqli_free_result($data);
	?>
	<!--<tr align="center"><td><input type="radio" name="account_id" value="0" checked></td><td align="center">Todas</td></tr>   -->     
	</tbody>
</table>


</form>

<br/>


<?php


	$sql = "CALL view_notifications_my_pending(" . $_SESSION['action_id'] . ",0)";
	$data2 = call_multiquery($sql);
?>


<form name="input" action="validacion.php" method="post">

<table border=0 class="display" cellspacing="0" width="100%">
	<tr><th colspan=5><h2>MIS NOTIFICACIONES PENDIENTES</h2></th><td colspan=2><input type="submit" name="action" value="Validar"></td></tr>
</table>
<table border=0 id="notificaciones" class="display" cellspacing="0" width="100%">
	<?php 
		if (mysqli_num_rows($data2)==0)
		{ ?>
		
		<tr><td colspan=7>NO HAY NOTIFICACIONES PENDIENTES</td></tr>
		<?php
		} else
		{ ?>
		

	<thead><tr><th>Seleccione</th><th>Creacion</th><th>Origen</th><th>Destino</th><th>Caducidad</th><th>Descripcion</th><th>Cantidad</th><th>Intentos</th></tr></thead>
	<?php
		}
			$i=0;
            while ($row = mysqli_fetch_assoc($data2)) 
		 {
			if ($i==0)
			{
				echo '<tr align="center"><td><input type="checkbox" checked name="notificacion_id[]" value="' . $row['id'] . '"></td><td align="center">' .  $row['creation_date'] . '</td><td align="center">';
				$i=1;
			} else
			{
				echo '<tr align="center"><td><input type="checkbox" name="notificacion_id[]" value="' . $row['id'] . '"></td><td align="center">' .  $row['creation_date'] . '</td><td align="center">';
			}
			echo $row['account_origin_id'] . '</td><td align="center">' .  $row['account_dest_id'] . '</td><td align="center">' .  $row['due_date'] . '</td><td align="center">';
			echo $row['description'] . '</td><td align="center">';
                        echo $row['amount'] . '</td><td align="center">' .  $row['try_number'] . '</td></tr>';
	        }
            mysqli_free_result($data2);
            //mysqli_close($con2);
	?>
	       
</table>


</form>

 <?php include './librerias/pie.php'; ?>

