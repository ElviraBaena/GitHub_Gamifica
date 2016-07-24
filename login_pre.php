 <?php 
session_start();
include "config.php";
  
function call_multiquery($sql,$user_in)
{
	// Ej: $sql='call proc("var1")';
	// Ej: $sql='select * from table1; select * from table2';

	global $mysql_ip_; //Variable definida en config.php
	
	$result="";
	$result2="";

	
	
        // Crea la conexión con el servidor de BBDD
    $db_con = mysqli_connect($mysql_ip_,$user_in,'F$G%h6j7k8','gamifica_access');
   
   //echo '$user_in' . $user_in;
   //echo '$mysql_ip_' . $mysql_ip_;
   
	if (!$db_con)
	  {	
	  	$_SESSION['error'] = 'DNI o Fecha de Nacimiento Incorrecto';
		header( 'Location: index.php' ) ;
		die();
	  }
        
	if (!mysqli_multi_query($db_con,$sql))
	  {
		$_SESSION['error'] = 'Error en conexion_: ' . mysql_error();
		header( 'Location: index.php' ) ;
		die();
	  }
	else
	  {
		$result = mysqli_store_result($db_con);
		$fila = mysqli_fetch_row($result);
		mysqli_free_result($result);
		
		$_SESSION['action_id']=$fila[0];
		mysqli_next_result($db_con);
		$result2 = mysqli_store_result($db_con);		

	  }
    mysqli_close($db_con);
    
   // echo '$fila[0]' . $fila[0] ;
	return $result2;
}

 
 ?>
 
 
<?php
	//echo 'estamos en login_pre' ;
  
	//Inicializa variables de sesion
	$validation_code_id="";
	$data="";
	$_SESSION['error']="";
	$_SESSION['action_id']=0;
	
	//Obtiene la plantilla de la clave de validacion
    $sql = 'CALL login_pre("';
	$sql .= $_POST['nacimiento'] . '","' . $application_id_ . '","' . $_SERVER['HTTP_USER_AGENT'] . '","' . $_SERVER['REMOTE_ADDR'] . '",' . $institution_id_ . ')';

  //echo 'sql'  . $sql;
	$data = call_multiquery($sql,$_POST['user']);

	
	
	if ($data!="")
	{
		$row = mysqli_fetch_assoc($data);
		$validation_code_id=$row['validation_code_id'];
		$validation_code_msg = $row['validation_code_msg'];
    
    
    //	echo '$validation_code_id' . $validation_code_id;
     // echo '$validation_code_msg' . $validation_code_msg;
	}
    //echo 'fuera';
    mysqli_free_result($data);


		// Se utiliza $_SESSION['action_id'] que se ha actulizado en la llamada al procedimito almacenado 'login_pre'
		if ($_SESSION['action_id']==-10)
			{
				$_SESSION['error'] = "El usuario no ha sido activado.<br/>Por favor, busque el mensaje de confirmacion en su email";
				header('Location: index.php') ;	die();			
			} 
		elseif ($_SESSION['action_id']<0)
			{
				$_SESSION['error'] = "Fecha de Nacimiento Incorrecta.<br/>Dispone de " . $_SESSION['action_id']*-1 . " intentos adicionales antes de que se bloquee la cuenta";
				header('Location: index.php') ;	die();			
			} 
		elseif ( $_SESSION['action_id']==0)
			{
				echo $data;
				$_SESSION['error'] = "Cuenta bloqueada: Numero de intentos de acceso fallidos superado.<br/>Por favor, contacte con el administrador del sistema en gamificabaenapad@gmail.com";
				header('Location: index.php') ;	die();
			}  
		else
			{

			include './librerias/cabecera.php';

				?>




 <legend>Autenticaci&oacute;n por Clave de Seguridad</legend>
 
 <SCRIPT type="text/javascript" src="http://vps285822.ovh.net/js/captura_teclado_numerico.js"></script>
 <SCRIPT type="text/javascript">
	var id_textbox_con_foco_='codigo_notificacion_0'; //Iniciacion de variable de foco 
 
 	window.onload = function(event) 
	{
		document.getElementById('codigo_notificacion_0').style.border="solid 3px #5c4ae8";
	}
 
 
	function botonClick(valor_in)
	{
		var siguiente_,maximo_,anterior_;
		var elemento_ = document.getElementById(id_textbox_con_foco_);
		
		maximo_=1;
		
		switch(id_textbox_con_foco_) {
			case 'codigo_notificacion_0':
				siguiente_ = 'codigo_notificacion_1';
				anterior_ = 'codigo_notificacion_0';
				break;
			case 'codigo_notificacion_1':
				siguiente_ = 'codigo_notificacion_2';
				anterior_ = 'codigo_notificacion_0';
				break;
			case 'codigo_notificacion_2':
				siguiente_ = 'codigo_notificacion_3';
				anterior_ = 'codigo_notificacion_1';
				break;
			case 'codigo_notificacion_3':
				siguiente_ = 'codigo_notificacion_3';
				anterior_ = 'codigo_notificacion_2';
				break;
		} 
		
		if (valor_in=="-1")
		{
			if (elemento_.value.length==0)
			{
				setFocus(document.getElementById(anterior_));
			} else
			{
				elemento_.value = elemento_.value.substr(0,elemento_.value.length-1);
			}
			
		} else if (valor_in=="tab")
		{
			setFocus(document.getElementById(siguiente_));
		}else
		{
			elemento_.value = elemento_.value + valor_in;
			if (elemento_.value.length>=maximo_)
			{
				setFocus(document.getElementById(siguiente_));
			}
		}
		
		
	}	
  
 	function setFocus(elemento)
	{
		document.getElementById('codigo_notificacion_0').style.border="solid 1px #BFBDBD";
		document.getElementById('codigo_notificacion_1').style.border="solid 1px #BFBDBD";
		document.getElementById('codigo_notificacion_2').style.border="solid 1px #BFBDBD";

		id_textbox_con_foco_ = elemento.id;
		if (id_textbox_con_foco_=="codigo_notificacion_3")
		{
			document.forms[0]["codigo_notificacion_3"].focus();
		} else
		{
			elemento.style.border="solid 3px #5c4ae8";
			elemento.value="";		
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
				
				
				
				
				
<form method="post" action="login_post.php">
<input type="hidden" name="validation_code_id" id="validation_code_id" value="<?=$validation_code_id ?>">
<input type="hidden" name="codigo_notificacion">
<input type="hidden" name="user" value="<?= $_POST['user']?>">



<table border=0 align=center>
	
	<tr><th>Introduzca los 3 digitos indicados de su clave de seguridad:</th></tr>
	
		<tr><th>
<?php
$longitud=strlen($validation_code_msg);

$javascrip_inicia = "";
$indice=0;
for ($i=0;$i<$longitud;$i++)
{
	$caracter=substr($validation_code_msg,$i,1);
	if ($caracter=='_')
	{
		echo '<input type="password" style="width:25px;vertical-align:top;text-align:center;font-size:x-large;margin:2px" readonly="readonly" onclick="setFocus(this);" maxlength=1 name="codigo_notificacion_' . $indice . '" id="codigo_notificacion_' . $indice . '" >';
		$indice =$indice + 1;
	} else
	{
		echo '<span style="font-size:xx-large;font-weight:bold;vertical-align:bottom;margin:5px">*</span>';
	}
}
?>
		</th></tr>
	
	
	<tr><th></th></tr>
</table>

	<table border=0 align="center">
		<tr>
			<td><input type="button"  style="width:80px;height:80px;font-size:75px;" value="1" onclick="botonClick(this.value)" /></td>
			<td><input type="button"  style="width:80px;height:80px;font-size:75px;" value="2" onclick="botonClick(this.value)" /></td>
			<td><input type="button"  style="width:80px;height:80px;font-size:75px;" value="3" onclick="botonClick(this.value)" /></td>
		</tr>
		<tr>
			<td><input type="button"  style="width:80px;height:80px;font-size:80px;" value="4" onclick="botonClick(this.value)"  /></td>
			<td><input type="button"  style="width:80px;height:80px;font-size:80px;" value="5" onclick="botonClick(this.value)"  /></td>
			<td><input type="button"  style="width:80px;height:80px;font-size:80px;" value="6" onclick="botonClick(this.value)"  /></td>
		</tr>
		<tr>
			<td><input type="button" style="width:80px;height:80px;font-size:80px;" value="7" onclick="botonClick(this.value)"  /></td>
			<td><input type="button" style="width:80px;height:80px;font-size:80px;" value="8" onclick="botonClick(this.value)"  /></td>
			<td><input type="button" style="width:80px;height:80px;font-size:80px;" value="9" onclick="botonClick(this.value)"  /></td>
		</tr>
		<tr>
			<td><input type="button" style="width:80px;height:80px;font-size:80px;" value="0"  onclick="botonClick(this.value)"  /></td>
			<td colspan=2><input type="button" style="width:160px;height:80px;font-size:30px;" name="<?= 'codigo_notificacion_'.$indice ?>" id="<?= 'codigo_notificacion_'.$indice ?>" value="Entrar"  onclick="submitForm();"></td>
		</tr>
		</table>	



</form>

			
<?php			
						
			
 	}
?>


<SCRIPT type="text/javascript">
	document.forms[0]['codigo_notificacion_0'].focus();
</SCRIPT>




 <?php include './librerias/pie.php'; ?>