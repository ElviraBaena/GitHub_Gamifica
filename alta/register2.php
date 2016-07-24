
<?php
session_start(); // this MUST be called prior to any output including whitespaces and line breaks!

$GLOBALS['DEBUG_MODE'] = 1;
// CHANGE TO 0 TO TURN OFF DEBUG MODE


$GLOBALS['ct_recipient']   = 'ludificacionempleado@gmail.com'; 
$GLOBALS['ct_msg_subject'] = 'Alta en Ludificación';

include '../librerias/cabecera.php'; 

 ?>
 
 

<SCRIPT type="text/javascript">
	
	var boton_pulsado="";
	function isDNI(dni) {
		var numero, let, letra;
		var expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;
	
		dni = dni.toUpperCase();
 
		if(expresion_regular_dni.test(dni) === true){
			numero = dni.substr(0,dni.length-1);
			numero = numero.replace('X', 0);
			numero = numero.replace('Y', 1);
			numero = numero.replace('Z', 2);
			let = dni.substr(dni.length-1, 1);
			numero = numero % 23;
			letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
			letra = letra.substring(numero, numero+1);
			if (letra != let) 
			{
				alert('Dni erroneo, la letra del NIF no se corresponde');
				return false;
			}else{
				//alert('Dni correcto');
				return true;
			}
		}else{
			alert('Dni erroneo, formato no válido');
			return false;
		}	
	}


		function validateTextbox(input_name)
	{
		var x=document.forms["formulario_alta2"][input_name].value;
		if (x==null || x=="")
		{
			alert("Existe algún campo obligatorio vacío");
			return false;
		} else
		{
			return true;
		}
	}
	
	function areDuplicatedTextboxes(input_name1,input_name2,input_title)
	{

		if (document.forms["formulario_alta2"][input_name1].value==document.forms["formulario_alta2"][input_name2].value)
		{	
			if (document.forms["formulario_alta2"][input_name1].value.length>5)
			{
				return true;
			}else
			{
				alert("El campo " + input_title + " tiene menos de 5 caracteres");
				return false;
			}
		} else
		{
			alert("El campo " + input_title + " no se ha repetido correctamente");
			return false;
		}
	}
	
	function isNumeric(input_name,input_title)
		{
			if (isNaN(document.forms["formulario_alta2"][input_name].value))
			{	
				alert("El campo " + input_title + " no es numerico");
				return false;
			} else
			{
				return true;
			}
		}
		
	function isNumeric_range(input_name,input_title,min_value,max_value)
		{
			var valor=document.forms["formulario_alta2"][input_name].value;
			if (isNaN(valor))
			{	
				alert("El campo " + input_title + " no es numerico");
				return false;
			} else
			{
				if ((valor>=min_value)&&(valor<=max_value))
				{
					return true;
				}
				else
				{
					alert("El campo " + input_title + " no es valido");
					return false;

				}
			}
		}	
	
	function isBirthdate()
	{
		if (isNumeric_range('nacimiento_dia','"dia de nacimiento"',1,31)&&isNumeric_range('nacimiento_mes','"mes de nacimiento"',1,12)&&isNumeric_range('nacimiento_ano','"año de nacimiento"',1900,2100))
		{				
			return true;
		} else
		{
			return false;
		}
	}
	
	
	
		
	function boton(nombre_boton)
	{
		boton_pulsado=nombre_boton;
		return true;
	}
	
	
	function concatDate()
	{
		var dia= "00" + document.forms["formulario_alta2"]['nacimiento_dia'].value;
		var mes= "00" + document.forms["formulario_alta2"]['nacimiento_mes'].value;
		var ano= "20" + document.forms["formulario_alta2"]['nacimiento_ano'].value;
		var resultado=ano.substr(-4,4) + '-' + mes.substr(-2,2) + '-' + dia.substr(-2,2);
		//alert(resultado);
		document.forms["formulario_alta2"]['nacimiento'].value=resultado;
		
	}
	

	function nextFocus(max_number_digits,current_element_name,next_element_name)
	{
	//alert(document.forms["formulario_alta2"][current_element_name].value.length);
		if (document.forms["formulario_alta2"][current_element_name].value.length>=max_number_digits)
		{
			document.forms["formulario_alta2"][next_element_name].focus();
		}
	}
	
	function validateForm()
	{
		if (boton_pulsado=='boton_anterior')
		{
			return true;
		} else
		{
			concatDate();
//			return isNumeric("seguridad","Código de Seguridad") && isDNI(document.forms["formulario_alta2"]["dni"].value + document.forms["formulario_alta2"]["dni_letra"].value) && areDuplicatedTextboxes("password","password2","Contraseña")  && areDuplicatedTextboxes("seguridad","seguridad2","Código de Seguridad");
			return isNumeric("seguridad","Código de Seguridad") && isDNI(document.forms["formulario_alta2"]["dni"].value + document.forms["formulario_alta2"]["dni_letra"].value) && areDuplicatedTextboxes("seguridad","seguridad2","Código de Seguridad")&&isBirthdate();

		}
	}



	
		
</SCRIPT>


  <style type="text/css">
  <!--
  .error { color: #f00; font-weight: bold; font-size: 1.2em; }
  .success { color: #00f; font-weight: bold; font-size: 1.2em; }
  .note { font-size: 18px;
  -->
  </style>



<legend>Formulario de Alta en el Sistema</legend>
 
<form name="formulario_alta2" id="formulario_alta2" action="register3.php" method="post" onsubmit="return validateForm()">

<input type="hidden" name="nombre" value="<?=$_POST['nombre']; ?>" >
<input type="hidden" name="apellido" value="<?=$_POST['apellido']; ?>" >
<input type="hidden" name="email" value="<?=$_POST['email']; ?>" >
<input type="hidden" name="pais" value="<?=$_POST['pais']; ?>" >
<input type="hidden" name="cp" value="<?=$_POST['cp']; ?>" >

<table border=0 align=center>
<tr><td  align=right style="font-weight:bold;">DNI*:</td> <td><input type="text" name="dni" onkeyup="nextFocus(8,'dni','dni_letra')" style="background-color:#EAF8FD;width:75px;" value="<?=$_POST['dni']; ?>"  maxlength="8"> Letra:<input type="text" name="dni_letra" onkeyup="nextFocus(1,'dni_letra','nacimiento_dia')" style="background-color:#EAF8FD;width:30px" value="<?=$_POST['dni_letra']; ?>" maxlength="1"></td></tr>
<tr><td  align=right style="font-weight:bold;">Fecha Nacimiento*:</td> <td><input type="text" name="nacimiento_dia"  onkeyup="nextFocus(2,'nacimiento_dia','nacimiento_mes')" style="background-color:#EAF8FD;width:30px;" value="<?=$_POST['nacimiento_dia']; ?>"  maxlength="2">-<input type="text" name="nacimiento_mes"  onkeyup="nextFocus(2,'nacimiento_mes','nacimiento_ano')"  style="background-color:#EAF8FD;width:30px;" value="<?=$_POST['nacimiento_mes']; ?>"  maxlength="2">-<input type="text" name="nacimiento_ano"  onkeyup="nextFocus(4,'nacimiento_ano','seguridad')" style="background-color:#EAF8FD;width:50px;" value="<?=$_POST['nacimiento_ano']; ?>"  maxlength="4"> <input type="hidden" name="nacimiento" style="background-color:#EAF8FD" value="<?=$_POST['nacimiento']; ?>"></td></tr>
<tr><td align=right style="font-weight:bold;">Clave de Seguridad*:</td> <td><input type="password" name="seguridad" style="background-color:#EAF8FD;" value="<?=$_POST['seguridad']; ?>"></td></tr>
<tr><td align=right style="font-weight:bold;">Repita Clave Seguridad*:</td> <td><input type="password" name="seguridad2" style="background-color:#EAF8FD;" value="<?=$_POST['seguridad2']; ?>"></td></tr>
<tr style='display:none;'><td align=left colspan=2>
  <img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="../librerias/securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />

    <object type="application/x-shockwave-flash" data="../librerias/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=../librerias/securimage/images/audio_icon.png&amp;audio_file=../librerias/securimage/securimage_play.php" height="32" width="32">
    <param name="movie" value="../librerias/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=../librerias/securimage/images/audio_icon.png&amp;audio_file=../librerias/securimage/securimage_play.php" />
    </object>
    &nbsp;
    <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '../librerias/securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="../librerias/securimage/images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a><br />
    <strong>Introduzca Código de Verificación*:</strong><br />
	<input type="text" name="ct_captcha" size="12" maxlength="16" />
</td></tr>
<?php

?>

<tr><td colspan=2 align=center>
	<input type="submit" class="classname" name="boton_siguiente" value="SIGUIENTE >>" onclick="return boton('boton_siguiente')" style="visibility:hidden">
	<input type="submit" class="classname" name="boton_anterior" value="<< ANTERIOR" onclick="return boton('boton_anterior')"> 
	<input type="submit" class="classname" name="boton_siguiente" value="SIGUIENTE >>" onclick="return boton('boton_siguiente')">
<br/><br/></td></tr>
<tr><td colspan=2 align=left><span style="font-weight:bold;">DNI</span>: Actua como nombre de usuario para acceder al sistema<br/></td></tr>
<!--<tr><td colspan=2 align=left><span style="font-weight:bold;">Contraseña</span>: Palabra secreta de más de 5 letras y números</td></tr>
-->
<tr><td colspan=2 align=left><span style="font-weight:bold;">Clave de Seguridad</span>: Número de más de 5 cifras para realizar transferencia<br/><br/></td></tr>
<tr><td colspan=2 align=left><span style="font-weight:bold;">ATENCIÓN</span>: Memorice su Clave de Seguridad y nunca la guarde junto a su DNI</td></tr>
</table>


</form> 


 <?php include '../librerias/pie.php'; ?>