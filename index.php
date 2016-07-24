 <?php session_start();
		include './librerias/cabecera.php'; ?>
  <legend>Iniciar Sesión</legend>

<SCRIPT type="text/javascript" src="http://vps285822.ovh.net/js/captura_teclado_numerico.js"></script>

<SCRIPT type="text/javascript">

	var id_textbox_con_foco_ = "user";
	

  	function isNumeric_range(input_name,input_title,min_value,max_value)
		{
			var valor=document.forms["input"][input_name].value;
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
  
  	function concatDate()
	{
		var dia= "00" + document.forms["input"]['nacimiento_dia'].value;
		var mes= "00" + document.forms["input"]['nacimiento_mes'].value;
		var ano= "20" + document.forms["input"]['nacimiento_ano'].value;
		var resultado=ano.substr(-4,4) + '-' + mes.substr(-2,2) + '-' + dia.substr(-2,2);
		//alert(resultado);
		document.forms["input"]['nacimiento'].value=resultado;
		
   
	}
	
	function submitForm()
	{
		if (isBirthdate())
		{
			concatDate();
			document.forms["input"].submit();
		} 
			
		// Si isBirthdate es falso, la propia funcion hace saltar el mensaje de error.
  
	}

function botonClick(valor_in)
	{
		var siguiente_,maximo_,anterior_;
		var elemento_ = document.getElementById(id_textbox_con_foco_);
		
		
		switch(id_textbox_con_foco_) {
			case 'user':
				maximo_ = 8;
				siguiente_ = 'nacimiento_dia';
				anterior_ = 'user';
				break;
			case 'nacimiento_dia':
				maximo_ = 2;
				siguiente_ = 'nacimiento_mes';
				anterior_ = 'user';
				break;
			case 'nacimiento_mes':
				maximo_ = 2;
				siguiente_ = 'nacimiento_ano';
				anterior_ = 'nacimiento_dia';
				break;
			case 'nacimiento_ano':
				maximo_ = 4;
				siguiente_ = 'boton';
				anterior_ = 'nacimiento_mes';
				break;
			case 'boton':
				maximo_ = 1;
				siguiente_ = 'boton';
				anterior_ = 'nacimiento_ano';
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
		
		//nextFocus(maximo_,id_textbox_con_foco_,siguiente_);
	}	
  
		
	
	
	
	
	
	function setFocus(elemento)
	{
		//if (id_textbox_con_foco_ != elemento.id)
		//{
		//alert(id_textbox_con_foco_ + ";" + elemento.id);
		document.getElementById('user').style.border="solid 1px #BFBDBD";
		document.getElementById('nacimiento_dia').style.border="solid 1px #BFBDBD";
		document.getElementById('nacimiento_mes').style.border="solid 1px #BFBDBD";
		document.getElementById('nacimiento_ano').style.border="solid 1px #BFBDBD";
		id_textbox_con_foco_ = elemento.id;
		if (id_textbox_con_foco_=="boton")
		{
			document.forms[0]["boton"].focus();
		} else
		{
			elemento.style.border="solid 3px #5c4ae8";
			elemento.value="";
		}
//}
	}
	

  
</SCRIPT>
  
<form name="input" action="login_pre.php" method="post">
	<table border=0 align=center>
		<tr><td><strong>DNI (sin letras):</strong></td> <td><input type="text" readonly="readonly" id="user" name="user" onclick="setFocus(this);"  style="border:solid 3px #5c4ae8;background-color:#EAF8FD;width:120px;text-align:center" value="<?=$_POST['user']?>" maxlength="8"></td></tr>
		<tr><td  align=right style="font-weight:bold;">Fecha Nacimiento:</td> <td><input type="text" readonly="readonly"  id="nacimiento_dia" onclick="setFocus(this);" name="nacimiento_dia"   style="width:30px;" value="<?=$_POST['nacimiento_dia']; ?>"  maxlength="2">-<input type="text" readonly="readonly"  name="nacimiento_mes" id="nacimiento_mes" onclick="setFocus(this);"    style="width:30px;" value="<?=$_POST['nacimiento_mes']; ?>"  maxlength="2">-<input type="text" readonly="readonly"  id="nacimiento_ano" onclick="setFocus(this);" name="nacimiento_ano"   style="width:50px;" value="<?=$_POST['nacimiento_ano']; ?>"  maxlength="4"> <input type="hidden" id="nacimiento" name="nacimiento"  value="<?=$_POST['nacimiento']; ?>"></td></tr>
		<tr><td colspan=2 align=center>
			<br/></td></tr>
		<tr><td colspan=2><a href="./alta/register.php">Crear Nueva Cuenta</a> <br/></td></tr>
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
			<td colspan=2><input type="button"  style="width:160px;height:80px;font-size:30px;" id="boton" name="boton" value="Entrar"  onclick="submitForm();"></td>
		</tr>
		</table>	
</form> 	



<?php
// Ver web http://www.php.net/manual/es/book.mysqli.php


if ($_SESSION['error']!='')
  {
	echo '<p style="color:red">' . $_SESSION['error'] . '</p>';
  }

$_SESSION['error']='';

?> 

<SCRIPT type="text/javascript">
	document.forms[0]['user'].focus();
</SCRIPT>


<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46215845-1', 'vps285822.ovh.net');
  ga('send', 'pageview');

</script>
-->

Versión php:<?php echo  phpversion(); ?>


 <?php include './librerias/pie.php'; ?>