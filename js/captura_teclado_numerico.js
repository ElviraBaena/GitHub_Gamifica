 
document.onkeyup = function(event) 
	{
		var key_press = String.fromCharCode(event.keyCode);
		
		if (event.keyCode>47 && event.keyCode<58 )	//Si la tecla pulsada es un numero
		{
			botonClick(key_press);
		} else if (event.keyCode>95 && event.keyCode<106 )	//Si la tecla pulsada es del teclado numerico
		{
			botonClick(event.keyCode - 96);
		} else if (event.keyCode==8 || event.keyCode==37)	// // Boton 'del' (retroceso)(8) o flecha para atrás (37)
		{ 
			botonClick(-1);
		} else if (event.keyCode==9 || event.keyCode==39)	// Boton tabulador (9) o flecha adelante (39)
		{
			botonClick('tab');
		}
		
	}