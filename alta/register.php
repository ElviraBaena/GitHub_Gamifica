 <?php include '../librerias/cabecera.php';  ?>
 
 

<SCRIPT type="text/javascript">
	var submit_enabled=0;
		
	function validateEmail()
	{
		var x=document.forms["formulario_alta1"]["email"].value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
			alert("Email no válido");
			return false;
		} else
		{
			return true;
		}
		
	}
	
	function validateTextbox(input_name)
	{
		var x=document.forms["formulario_alta1"][input_name].value;
		if (x==null || x=="")
		{
			alert("Existe algún campo obligatorio vacío");
			return false;
		} else
		{
			return true;
		}
	}
	
	function validateForm()
	{
		return validateTextbox("nombre")&&validateTextbox("pais")&&validateTextbox("cp");
	
	}
	
	
	function submit_check()
		{
			if (submit_enabled==0)
			 {
				alert("Debe aprobar las condiciones del servicio");
				return false;
			} else 
			{
				return validateEmail();
			}
		}
		
	function checkbox_click()
		{
		validateForm("pais");
			if (submit_enabled==0)
			{
				submit_enabled=1;
			} else
			{
				submit_enabled=0;
			}
		}
		
</SCRIPT>


 
 <legend> Formulario de Alta en el Sistema</legend>
<form name="formulario_alta1" action="register2.php" method="post" onsubmit="return submit_check()">
<input type="hidden" name="dni"  value="<?=$_POST['dni']; ?>" > 
<input type="hidden" name="dni_letra"  value="<?=$_POST['dni_letra']; ?>" >
<input type="hidden" name="password" value="<?=$_POST['password']; ?>">
<input type="hidden" name="password2" value="<?=$_POST['password2']; ?>">
<input type="hidden" name="seguridad" value="<?=$_POST['seguridad']; ?>">
<input type="hidden" name="seguridad2"  value="<?=$_POST['seguridad2']; ?>">
<input type="hidden" name="nacimiento_dia"  value="<?=$_POST['nacimiento_dia']; ?>">
<input type="hidden" name="nacimiento_mes" value="<?=$_POST['nacimiento_mes']; ?>">
<input type="hidden" name="nacimiento_ano" value="<?=$_POST['nacimiento_ano']; ?>">

<table border=0 align=center>
<tr><td>Nombre*:</td> <td><input type="text" name="nombre" style="background-color:#EAF8FD;" value="<?=$_POST['nombre']; ?>"></td></tr>
<tr><td>Apellido:</td> <td><input type="text" name="apellido" style="background-color:#EAF8FD;" value="<?=$_POST['apellido'];?>"></td></tr>
<tr><td>Email*:</td> <td><input type="text" name="email" id="email" style="background-color:#EAF8FD;" value="<?=$_POST['email'];?>"></td></tr>
<tr><td>Pais*:</td> <td><input type="text" name="pais" style="background-color:#EAF8FD;" value="<?= (isset($_POST['pais']) ? $_POST['pais'] : 'España');?>"></td></tr>
<tr><td>Codigo Postal*:</td> <td><input type="text" name="cp" style="background-color:#EAF8FD;" value="<?=$_POST['cp'];?>"></td></tr>
<tr><td colspan=2 align=left><input onclick="checkbox_click()" type="checkbox" name="condicionesdelservicio" id="condicionesdelservicio" style="background-color:#EAF8FD;" value="">Acepto las <a href="./condicionesdelservicio.php" target="_blank">Condiciones del Servicio</a></td></tr>
<tr><td colspan=2 align=center>
<input type="submit" class="classname" name="boton" value="SIGUIENTE >>" ><br/></td></tr>
<tr><td colspan=2 align=left>* Campos obligatorios</td></tr>
</table>

</form> 


<SCRIPT type="text/javascript">
	document.getElementById("condicionesdelservicio").checked=false;
</SCRIPT>
 <?php include '../librerias/pie.php'; ?>