// JavaScript Document

/* FUNCION DE VALIDACION DE USUARIO PARA INGRESO */
function valida() /* OK */
{
    //valido el nombre
	if ((document.index.user.value.length==0)||(document.index.user.value.length<4))
	   {
       alert("Tiene que escribir su nombre o su nombre es demasiado corto!!!")
       document.index.user.focus();
       return false;
       }
	if ((document.index.pass.value.length==0)||(document.index.pass.value.length<4))
	   {
       alert("Tiene que escribir su contraseña o su contraseña no tiene la cantidad de caracteres requeridos!!!")
       document.index.pass.focus();
       return false;
       }
	   
	   document.index.oper.value="V";//Operacion Validar Usuario en BD
	   //document.index.submit();

}
//BUSCAR PERMISOS

function busca_permiso()
	{
			document.alta.oper.value="P";
	    	document.alta.action="func_php.php";
	 		document.alta.submit();
	 
	}
	
function busca_permiso_asidef()
	{
	
			document.alta.oper.value="A";
	    	document.alta.action="func_php.php";
	 		document.alta.submit();
		
	 
	}	
//VERFICA PAGINA ANTERIOR PARA ASIGNAR PERMISOS

function valida_user( ) /* OK */
	{
    
	}
	
function valida_userm() /*OK*/
	{
	
	}
//OPCIONES 

function inicio_menu(ob) /* OK */
	{
	 ob.action="principal.php";
	 ob.submit();
	}
	
function cerrarses(obj) /* OK */
	{
	 obj.oper.value="C";
	 obj.action="func_php.php";
	 obj.submit();
	}
	
//VALIDACION PARA LA BUSQUEDA

function valida_user2() /* OK */
	{
   
	}	
	
function valida_3()
	{
	
	}
	
function valida_num() /* OK */
	{
	if ((document.buscar_us.dni.value.length==0)||(document.buscar_us.dni.value.length<4))
	   {
       alert("Tiene que escribir su NOMBRE o el NOMBRE es demasiado corto")
       document.buscar_us.dni.focus();
       return false;
       }
	document.buscar_us.submit(); 
	}

//PARA MODIFICAR USUARIO

function modUser() /* OK */
	{
		 document.buscar_php.oper.value="M";
	     document.buscar_php.action="func_php.php" ;
	 	 document.buscar_php.submit();
		 
	}

//para modificar administrador
function modAdmin() /* OK */
	{
		 document.buscar_php.oper.value="MA";
	     document.buscar_php.action="func_php.php" ;
	 	 document.buscar_php.submit();
		 
	}
/*function modifica()
	{
	 document.mod.oper.value="M";
	 document.mod.action="func_php.php" ;
	 document.mod.submit();
	}*/
	
function atras_buscar() /* OK */
	{
	 document.modifica.action="buscar.php";
	 document.modifica.submit();
	}
	
function chequear_checkbox2()
	{
	if((document.modifica.alta.checked==false)&&(document.modifica.baja.checked==false)&&(document.modifica.mod.checked==false))
		{
		 return false;
		}else{
	 		if(document.modifica.alta.checked==false)
	 			{
				 document.modifica.alta.checked=true;
				 document.modifica.alta.value=0;
				}
			if(document.modifica.baja.checked==false)
			 	{
				 document.modifica.baja.checked=true;
		 		document.modifica.baja.value=0;
				}
			if(document.modifica.mod.checked==false)
	 			{
				 document.modifica.mod.checked=true;
				 document.modifica.mod.value=0;
				}
			}	
	}

function chequear_check_mod()
	{
	 if((document.modifica.asig.checked==false)&&(document.modifica.rech.checked==false)&&(document.modifica.agre.checked==false)&&(document.modifica.arch.checked==false)&&(document.modifica.edit.checked==false)) 
	 	{
		 return false;
		}else{		
			if(document.modifica.asig.checked==false)
	 			{
				 document.modifica.asig.checked=true;
				 document.modifica.asig.value=0;
				}
			if(document.modifica.rech.checked==false)
	 			{
				 document.modifica.rech.checked=true;
				 document.modifica.rech.value=0;
				}
			if(document.modifica.agre.checked==false)
	 			{
				 document.modifica.agre.checked=true;
				 document.modifica.agre.value=0;
				}
			if(document.modifica.arch.checked==false)
	 			{
				 document.modifica.arch.checked=true;
				 document.modifica.arch.value=0;
				}
			if(document.modifica.edit.checked==false)
	 			{
				 document.modifica.edit.checked=true;
				 document.modifica.edit.value=0;
				}
			}	
	}

function validar_us() /* OK */
	{
	 if((document.modifica.nuevo_nom.value.length==0)||(document.modifica.nuevo_nom.value.length<4))//valido el nombre 
	   {
       alert("Tiene Que Escribir Un Nombre O Su Nombre Es Demasiado Corto")
       document.modifica.nuevo_nom.focus();
	   return false;
       }
	   
	 if((document.modifica.nuevo_nombre_real.value.length==0)||(document.modifica.nuevo_nombre_real.value.length<10))
	 	{
	   alert("Tiene Que Escribir Un Nombre O Su Nombre Es Demasiado Corto")
       document.modifica.nuevo_nombre_real.focus();
	   return false;
		}  
	   
	 if((document.modifica.nuevo_pas.value.length==0)||(document.modifica.nuevo_pas.value.length<4))
	   {
       alert("Tiene Que Escribir Su Contraseña O Su Contraseña No Tiene La Cantidad De Caracteres Requeridos")
       document.modifica.nuevo_pas.focus();
       return false;
       }  
	   
	 if (document.modifica.nuevo_pas.value != document.modifica.nuevo_pas2.value)
	   {
       alert("Las Contraseñas No Son Iguales")
       document.modifica.nuevo_pas2.focus();
       return false;
       }
	 
	 if(chequear_checkbox2()==false)
	 	{
		 if(chequear_check_mod()==false)
		 		{
				 alert ("Tienes Que Seleccionar Un Permiso Por Lo Menos!!!")
				 return false;
				}
		}
	   
    document.modifica.oper.value="X";//Operacion Modifica Usuario en BD
	document.modifica.submit();
	}
	
function elimUser(num) /* OK */
	{
		if(confirm("Esta Seguro De Borrar A Este Usuario De La BD!!!"))
			{
			 document.buscar_php.oper.value="E";
		 	 document.buscar_php.action="func_php.php";
		 	 document.buscar_php.submit();
			}
	}
	
function valida_user_menu()
	{
   
	}
	
function valida_user_inic()
	{
	
	}
	
function valida_user_ae()
	{
	
	}
	
function valida_direccion()	
	{
	
	}
	
function busca_permiso_altaexp()
	{

			document.alta.oper.value="AE";
	    	document.alta.action="func_php.php";
	 		document.alta.submit();
				 
	}

function redirecciona()
	{
	 document.almenu.action="principal.php";
	 document.almenu.submit();
	}
	
function error() // EN CASO DE USUARIO Y/O PASS INCORRECTO 
	{
	 alert("Algo Esta Mal")
	 document.error.submit();
	}
	
function remito()  //A PAGINA CARGAR REMITO
	{
	 document.principal.action="cargar.php";
	 document.principal.submit();
	}

function articulo()
	{
	 document.principal.action="articulos.php";
	 document.principal.submit();
	}

function orden()
	{
	 document.principal.action="orden_insumo.php";
	 document.principal.submit();
	}