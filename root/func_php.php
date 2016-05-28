<?php
session_start();

function inicia_sesion1($x,$user,$pass)
	{
	 //session_start();
	 $_SESSION['Nombre']=$user;           //variable sesion.nombre = a nombre de usuario
	 $_SESSION['Pass']=$pass;             //variable sesion.pass = a pass del usuarios
	 $_SESSION['id_usuario']=$x;          //variable sesion.id = al id que identifica al usuario
	 
	 $sql = "SELECT * FROM usuarios where id_usuario = ".$x;
	 $resu = mysql_query($sql);
	 while ($row = mysql_fetch_array($resu))
	 	{
			$_SESSION['NombreReal'] = $row['nombre_real'];
			$idGrupo = $row['id_grupo']; 
		}
	$_SESSION['permisos'] = $idGrupo;
	
	 obtener_permisos($idGrupo);
	}
	
function obtener_permisos($id_us)
	{
	 $consulta ="SELECT * From tbl_grupos Where id_grupo = $id_us";
	 $result = mysql_query($consulta);
	 while($row = mysql_fetch_array($result))
	 	{
		 //$_SESSION['permisos'] = $row['permisos'];
		 $_SESSION['admin'] = $row['administrador'];
		}
	}
		
function buscar_usuario($user,$pass)
	{
	  include("conexion.php");
	  $aux=new conexion();
	  $aux->conectarse();
		 $sql="SELECT * FROM usuarios";
		 $result=mysql_query($sql);
		 if ($row = mysql_fetch_array($result))
			{
			 
			 do
				{ if(($row["nombre"] == $user) && ($row["contrasenia"] == $pass))
				     {
					  return $row["id_usuario"];
					 }
				}
			 while ($row=mysql_fetch_array($result));
			}
		return 0; 
		//$aux->cerrar_conexion();
	}

function valida($user , $pass)
	{
	 $x=buscar_usuario($user,$pass);
     if($x==0)	
	 	{ 
		 header("Location: no_login.php");
		}else
			{
			 inicia_sesion1($x,$user,$pass); 
			 header("Location: principal.php");
			}
	
	}

function cierra()
	{
	 //session_start();	
	 $_SESSION['Nombre']=NULL;
	 $_SESSION['Pass']=NULL;
	 header("Location: index.php");
	}

switch($_POST['oper'])
	{
	 case 'V': { 
	 			valida($_POST['user'],$_POST['pass']);
				break;
				}
				
	case 'M':   {/* para modificar usuario */
	             header("Location: modificar.php");
				 break;
				}
				
	case 'MA':	{
				/*para modificar administrador */
				header("Location: modificar_administrador.php");
				break;
				}			
				
	case 'C':   { /* para cerrar sesion */
				 cierra();
				 break;
				}				
	default :  {echo "No tenes idea de lo que queres hacer!!!";}
	}
?>
