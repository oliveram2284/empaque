
<?php

function botonera_menu($usuario){
	$privilegios = str_split($_SESSION['privilegios'],1);
	$botonera = '<a href="zmain.php" class="desktop"><span>Inicio</span></a>';
	
	if ($privilegios[17]==1){
		$botonera = $botonera . '<a href="zmodifusuario.php?personal='.$_SESSION["codigo"].'&perfil=true" class="profil"><span>Perfil</span></a>';
	}
	if ($privilegios[5]==1){
	$botonera = $botonera . '<a href="administracion.php" class="admin"><span>Admin</span></a>';
	}
	$botonera = $botonera. '<a href="logout.php" class="logout"><span>Salir</span></a>';
	$botonera = $botonera. '<a href="ayuda.php" class="help"><span>Ayuda</span></a>';
	
return $botonera;
}



?>