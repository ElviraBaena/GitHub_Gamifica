
<?php
include './librerias/connection.php'; // this MUST be called prior to any output including whitespaces and line breaks!

$GLOBALS['DEBUG_MODE'] = 0;
// CHANGE TO 0 TO TURN OFF DEBUG MODE
// IN DEBUG MODE, ONLY THE CAPTCHA CODE IS VALIDATED, AND NO EMAIL IS SENT

include '../librerias/cabecera.php'; 

function procesar_alta($password)
{
	$salida='';

	if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && 
		isset($_POST['pais']) && isset($_POST['cp']) && isset($_POST['dni']) && 
		isset($_POST['dni_letra']) && isset($_POST['seguridad']))
	{
		$nombre=$_POST['nombre']; 
		$apellido=$_POST['apellido']; 
		$email=$_POST['email']; 
		$pais=$_POST['pais']; 
		$cp=$_POST['cp']; 
		$dni=$_POST['dni']; 
		$dni_letra=$_POST['dni_letra']; 
		$nacimiento=$_POST['nacimiento'];
		$seguridad=$_POST['seguridad'];


		$db_con = mysqli_connect('51.255.43.27','acceso','053781ad3ed12fc42b11043c1cc949c95ee12533','gamifica_access');
  	
  
		if (!$db_con)
		{
			$_SESSION['error'] = 'No se ha podido conectar: ' . mysql_error();
			$salida= $_SESSION['error'];
			//header( 'Location: ../index.php' ) ; 
       echo 'No se ha podido conectar' ;
		}
	
		$sql = "CALL create_user('$nombre','$apellido','$dni','$dni_letra','$nacimiento','%','$password','$email','$cp','$pais','$seguridad',100)";
		//echo $sql;
		if (!mysqli_multi_query($db_con,$sql))
		{
      
			$_SESSION['error'] = 'Error en create user: ' . mysqli_error();
			$salida= $_SESSION['error'];
     // echo "salida es $salida"; 
		}
		
		else
		{	
			$result = mysqli_store_result($db_con);
			$fila = mysqli_fetch_row($result);
			mysqli_free_result($result);
				
			$salida=$fila[0]; //0: usuario repetido (introducido con anterioridad); 1: alta registrada con éxito
		 // echo "salida: " . $salida;
		}	
	} else
	{
		$salida=-1; //Datos incompletos;
	}
  //echo "salida es $salida"; 
	return $salida;	
}
?>



  <style type="text/css">
  <!--
  .error { color: #f00; font-weight: bold; font-size: 1.2em; }
  .success { color: #00f; font-weight: bold; font-size: 1.2em; }
  .note { font-size: 18px;
  -->
  </style>


<legend>Formulario de Alta en el Sistema</legend>
                                                    
 
<?php

if (isset($_POST['boton_anterior']))
{
	echo "<form name='formulario_alta3' action='register.php' method='post'>";
	foreach($_POST as $key => $value) 
	{
		if (!is_array($key)) 
		{
			echo "<input type='hidden' name='" . $key . "' value='" . $value . "' ><br/>";
		}	
	}
	echo "</form>";	
	echo "<SCRIPT type='text/javascript'> document.forms['formulario_alta3'].submit();</SCRIPT>";
} else
{
 
   
  
	// GENERADOR DE CONTRASEÑAS
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$passwd = "";
	for($i=0;$i<7;$i++) 
		{
			$passwd .= substr($str,rand(0,62),1);
		}
	
	
	$resultado = procesar_alta($passwd);
	
	
	if ($resultado==0)
			{
				echo "<CENTER><p style='color:red'>El DNI introducido ya estaba dado de alta con anterioridad o hubo un error de registro.</p></CENTER>";
				echo "<CENTER><p>Contacte con nosotros en  <a href='mailto:ludificacionempleado@gmail.com?subject=DNI duplicado'>ludificacionempleado@gmail.com</a> si sospecha que alguien introdujo su DNI sin su consentimiento.</p></CENTER>";
				echo "<form name='formulario_alta3' action='register.php' method='post'>";
				echo '<CENTER><input type="submit" class="classname" name="boton_anterior" value="<< VOLVER"></CENTER>';
				foreach($_POST as $key => $value) 
				{
					if (!is_array($key)) 
					{
						echo "<input type='hidden' name='" . $key . "' value='" . $value . "' ><br/>";
					}	
				}
				
				echo "</form>";	
			}
	elseif ($resultado==1)
			{
				echo "<center><p>Alta de usuario efectuada con éxito.</p></center>";
				
			}
	elseif ($resultado==-1)
			{
				echo "<p>Datos incompletos </p>";
			}
	


}
?>

<center><p>Haga clic en <a href="../index.php">Iniciar de sesión</a> para comenzar a usar el sistema.</p></center> 

<!--Ir a iniciar sesión mediante botón, en lugar de enlace:-->
 <!--<center>--> 
     <!--<input type="button" name="action" value="Iniciar Sesión" onclick="location.href='http://vps285822.ovh.net/index.php'");">-->
  <!--</center>--> 
  <?php include '../librerias/pie.php'; ?>
 
   