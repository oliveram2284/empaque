//_________________________________________________________//	
//solo letras en el campo	
function letras (campo) 
	{
	var charpos = campo.value.search("[^A-Za-z ��]"); 
	if(campo.value.length > 0 &&  charpos >= 0) 
		{ 
		campo.value= campo.value.slice(0, -1);
		campo.focus();
		return false; 
		}
		 else 
		 	{
			return true;
			}
}
//_________________________________________________________// 
//Solo numeros en el campo
function numerico(campo) 
	{
	var charpos = campo.value.search("[^0-9]"); 
    if (campo.value.length > 0 &&  charpos >= 0)  
		{ 
		campo.value = campo.value.slice(0, -1);
		campo.focus();
	    return false; 
		} 
			else 
				{
				return true;
				}
	}
//_________________________________________________________//
//Solo se permiten numero y letras (no simbolos)
function alfanumerico(campo)
	{ 
	var charpos = campo.value.search("[^A-Za-z0-9. ]"); 
	if(campo.value.length > 0 &&  charpos >= 0) 
		{ 
		campo.value =  campo.value.slice(0, -1)
		campo.focus();
		return false; 
		} 
			else 
				{
				return true;
				}
	}
//_________________________________________________________//	
//validar e-mail 	
function validarEmail(valor) 
	{
	 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(valor))
		{return true;} 
		else {return false;}
	}
//_________________________________________________________//	
//tama�o del campo
function tamaño(campo,longitud)
	{
	 if(campo.value.length < longitud)
	 	{
		 campo.focus();
		 return false; 
		}else
			return true;
	}
//_________________________________________________________//	
/*funcion de mensajes (para que todos los mensajes de error u otro mensaje, tengan el 
mismo contenido en todas las pantallas cuando se produzaca un mensaje similar )	*/						
function mensaje(cadena,boton)
	{
	 switch(cadena)
	 	{
		 case "longitud_invalida": {alert ("Longitud de campo "+boton+" no valida");break;}
		 case "email" :  {alert ("Verifique la Direccion de E-mail");break;}
		 case "contrase�as" :  {alert ("Las contraseñas no son iguales");break;}
		 case "monto" :  {alert ("Monto no valido");break;}
		}
	}
