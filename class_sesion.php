<?php
//session_start();

class Sesion
	{
	 function iniciar()
	 	{
		 //valdiar que el usuario este logueado 
		if(!isset($_SESSION['Nombre']))
			{ 
			 //no iniciaste sesio' n 
			 echo'<script>alert("Login incorrecto.");location.href="index.php";</script>';
			}
			 else
				{
				 //validar datos para armar el menu y para validar el ingreso				
				 $CadenaPermisos = $_SESSION['permisos'];//("";
				}
				
				return $CadenaPermisos;
		}
	}

?>