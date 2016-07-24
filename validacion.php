<?php include './librerias/cabecera.php';	?>


 
 
<?php
	include './librerias/connection.php';

	if (isset($_POST['notificacion_id']))
	{
            $notification_id=",";
            $noti_post = $_POST['notificacion_id'];
            if(!empty($noti_post)) 
            {
                $N = count($noti_post);
                for($i=0; $i < $N; $i++)
                {
                    $notification_id .= $noti_post[$i] . ",";
                }
            }
            $transfer_id=0;
              
    } else
    {
       	$sql = 'CALL transfer_request(' . $_SESSION['action_id'] . ',"';
		$sql .= $_POST['description'] . '","';
		$sql .= $_POST['account_origin'] . '","';
		$sql .= $_POST['account_dest_pre'] . '","';
		$sql .= $_POST['account_dest_root'] . '","';
		$sql .= $_POST['amount'] . '","';
		$sql .= $_POST['scheduled_date'] . '")';
		
		$data = call_multiquery($sql);
		if ($data=="")
		{
			echo "No existe transferencia";
		}	
		else
		{
			$row = mysqli_fetch_assoc($data);
			$transfer_id=$row['transfer_id'];
			$notification_id = $row['notification_id'];
                        //echo "<br/>" . $transfer_id;
                        //echo "<br/>" . $notification_id;
                        
		}
        mysqli_free_result($data);

    }
	
        
    if ($transfer_id==-1)
    {
		echo '<center><img align=center src="./imagenes/ko.jpg" alt="ko"></center><br/>';
        echo "<br/>No hay suficiente saldo en la cuenta<br/><!--";
    } else
    {

        $sql2 = 'CALL transfer_notification_validation(' . $_SESSION['action_id'] . ',"';
        $sql2 .= $notification_id . '")';
        $data2 = call_multiquery($sql2);

        if ($data2=="")
		{
			echo "No existen acciones pendientes para validar";
		}	
		else
		{
			$row2 = mysqli_fetch_assoc($data2);
			$transfer_code_msg=$row2['transfer_code_msg'];
			$number_modified_notifications = $row2['number_modified_notifications'];
            echo "<BR/>NUMERO DE ACCIONES SELECCIONADAS PARA SU VALIDACI&Oacute;N: " . $number_modified_notifications;

		}
    }

	


?>



 
<SCRIPT type="text/javascript">
   	function nextFocus(max_number_digits,current_element_name,next_element_name)
	{
	
		if (document.forms[0][current_element_name].value.length>=max_number_digits)
		{
			document.forms[0][next_element_name].focus();
		}
	}
  

	
	function submitForm()
	{
		var code0= document.forms[0]['codigo_notificacion_0'].value;
		var code1= document.forms[0]['codigo_notificacion_1'].value;
		var code2= document.forms[0]['codigo_notificacion_2'].value;
		document.forms[0]['codigo_notificacion'].value = code0 + code1 + code2;
		document.forms[0].submit();
 
	}
  
</SCRIPT>
	

	
	
	
 <legend>VALIDACI&oacute;N MEDIANTE CLAVE DE SEGURIDAD</legend> 


<form method="post" action="validacion_process.php">
<input type="hidden" name="notificaciones" id="notificaciones" value="<?=$notification_id ?>">
<input type="hidden" name="codigo_notificacion">
<table border=0 align=center>
	<tr><th>Introduzca los 3 digitos indicados de su clave de seguridad:</th>
	
			<tr><th>
<?php
$longitud=strlen($transfer_code_msg);

$indice=0;
for ($i=0;$i<$longitud;$i++)
{
	$caracter=substr($transfer_code_msg,$i,1);
	if ($caracter=='_')
	{
		$onkeyup="nextFocus(1,'codigo_notificacion_" . $indice . "','codigo_notificacion_" . ($indice+1) . "')";
		
		echo '<input type="password" style="width:25px;vertical-align:top;text-align:center;font-size:x-large;margin:2px" maxlength=1 name="codigo_notificacion_' . $indice . '" onkeyup="' . $onkeyup  . '" >';
		$indice =$indice + 1;
	} else
	{
		echo '<span style="font-size:xx-large;font-weight:bold;vertical-align:bottom;margin:5px">*</span>';
	}
}
?>
		</th></tr>
	
	
<tr><th><input type="button" name="<?= 'codigo_notificacion_'.$indice ?>" value="Validar"  onclick="submitForm();"></th></tr>
</table>


</form>

<SCRIPT type="text/javascript">
	document.forms[0]['codigo_notificacion_0'].focus();
</SCRIPT>
<?php if ($transfer_id==-1)
    {
        echo "-->";
    }
	?>
<a href="inicio.php">Inicio</a>
 <?php include './librerias/pie.php'; ?>