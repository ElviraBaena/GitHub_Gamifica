


        <?php
        
        
        include './librerias/connection.php';

	if (isset($_POST['codigo_notificacion']))
	{
            $cancel = 0;
            if (isset($_POST['cancelar']))
            {
                $cancel = $_POST['cancelar'];
            }
            $sql = 'CALL transfer_ack(' . $_SESSION['action_id'];
            $sql .= ',"' . $_POST["notificaciones"];
            $sql .= '","' . $_POST['codigo_notificacion'];
            $sql .= '","' . $cancel . '")';
            $data = call_multiquery($sql);
            
            $row = mysqli_fetch_assoc($data);
			
			include './librerias/cabecera.php';
            
            echo "<legend> RESULTADO DE LA VALIDACI&oacute;N </legend>";
			if ($row['notification_valid']>0)  // Operacion validada con exito
			{
				echo '<center><img src="./imagenes/ok.jpg" alt="ok"></center>';			
	

			} else								// Operacion no validada
			{
				echo '<center><img align=center src="./imagenes/ko.jpg" alt="ko"></center><br/>';
				
			    if ($row['notification_wrong']==0)
				{
					echo "<center>NO SE HA SELECCIONADO NINGUNA NOTIFICACION VALIDA</center>";
				} else
				{
					echo "<center>CODIGO DE VALIDACION INCORRECTO. <br/>YA HA CONSUMIDO " . $row['max_tries'] . " INTENTOS DE 4</center>";
				}
				
			}
			?>
			
		
			<br/>
			<br/>
			
			<?php

        }  else
        {
         $_SESSION['error'] = "Sesion caducada";
		 header('Location: index.php') ;	die();
            

        }
        
		
		
        ?>
        
        <a href="inicio.php">Inicio</a>
        
 <?php include './librerias/pie.php'; ?>
