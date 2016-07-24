<?php

// Codigo comun
session_start();
include "config.php";



//Funciones



function call_multiquery($sql)
{
	// Ej: $sql='call proc("var1")';
	// Ej: $sql='select * from table1; select * from table2';

	global $mysql_ip_; //Variable definida en config.php
	
	$result="";
	$result2="";

        // Crea la conexión con el servidor de BBDD
        $db_con = mysqli_connect($mysql_ip_,$_SESSION['mysql_user'],$_SESSION['mysql_pass'],'gamifica');
	if (!$db_con)
	  {	
	  	$_SESSION['error'] = 'No se ha podido conectar: ' . mysql_error();
		header( 'Location: /index.php' ) ;
	  }
        
        
        
	if (!mysqli_multi_query($db_con,$sql))
	  {
		$_SESSION['error'] = 'Error en conexion:: ' . mysql_error();
		header( 'Location: /index.php' ) ;

	  }

	else
	  {
		$result = mysqli_store_result($db_con);
		$fila = mysqli_fetch_row($result);
		mysqli_free_result($result);
		if ($fila[0]==0)
			{
				$_SESSION['error'] = 'Sesion Caducada ';
				header( 'Location: /index.php' ) ;
				exit();
			}
			else
			{
				$_SESSION['action_id']=$fila[0];
				mysqli_next_result($db_con);
				$result2 = mysqli_store_result($db_con);
			}
	  }
        mysqli_close($db_con);
	return $result2;
}





?> 