 <?php
session_start(); 
	
include "config.php";
 
  
function call_multiquery($sql,$user_in)
{
	// Ej: $sql='call proc("var1")';
	// Ej: $sql='select * from table1; select * from table2';

	$result="";
	$result2="";

	
	
        // Crea la conexión con el servidor de BBDD
        $db_con = mysqli_connect($mysql_ip_,$user_in,'F$G%h6j7k8','gamifica_access');
	if (!$db_con)
	  {	
	  	$_SESSION['error'] = 'No se ha podido conectar: ' . mysql_error();

		header( 'Location: index.php' ) ;die();
	  }
        
        
        
	if (!mysqli_multi_query($db_con,$sql))
	  {
    
    echo 'entra por aqui' ;
		$_SESSION['error'] = 'Error en conexion:: ' . mysql_error();

		header( 'Location: index.php' ) ;die();
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
	return $result2;
}


 
 
 
 ?>
 
 
 
 
 
 
 
<?php
	

	//Obtiene la plantilla de la clave de validacion
    $sql = 'CALL login_post("';
	$sql .= $_SESSION['action_id'] . '","' . $_POST['codigo_notificacion'] . '","' . $_POST['validation_code_id'] . '")';
  
  echo '$sql' . $sql ;
  
	$data = call_multiquery($sql,$_POST['user']);
  
	if ($data=="")
	{
		$_SESSION['error'] = "Error de conexion";
		header('Location: index.php') ;
  
	}	
	else
	{
		$row = mysqli_fetch_assoc($data);
		$password=$row['password'];
	}
    mysqli_free_result($data);
	
	echo "<br/>";
	




		// Se utiliza $_SESSION['action_id'] que se ha actulizado en la llamada al procedimito almacenado 'login_pre'
		if ($_SESSION['action_id']==-10)
			{
				$_SESSION['error'] = "El usuario no ha sido activado.<br/>Por favor, busque el mensaje de confirmacion en su email";
				header('Location: index.php') ;	die();			
			} 
		elseif ($_SESSION['action_id']<0)
			{
				$_SESSION['error'] = "C&oacute;digo de Validacion incorrecto.<br/>Dispone de " . $_SESSION['action_id']*-1 . " intentos adicionales antes de que se bloquee la cuenta";
				header('Location: index.php') ;	die();			
			} 
		elseif ( $_SESSION['action_id']==0)
			{
				$_SESSION['error'] = "Cuenta bloqueada: Numero de intentos de acceso fallidos superado.<br/>Por favor, contacte con el administrador del sistema en ludificacionempleados@gmail.com";
				header('Location: index.php') ;	die();			
			}   
			
			
			
		else
			{

			
				$_SESSION['mysql_ip'] = $mysql_ip_;
				$_SESSION['mysql_user'] = $_POST['user'] . '_';
				$_SESSION['mysql_pass'] = $password;
				//$_SESSION['action_id']=$_SESSION['action_id'];
				$_SESSION['error']='';
			  header( 'Location: ' . $landing_page_ ) ;
        
			}

				?>

				

			
