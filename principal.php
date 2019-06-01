<?php
include "conexion.php";
session_start();
include("class_sesion.php");
$sesion = new Sesion();
$CadenaPermisos = $sesion->iniciar();



include("class_menu.php");
$menu = new menu();

require("header.php");

?>
<br>
<div class="container">
	<center>
		<div id="menu" class="well" style="min-height: 90%; background-image: url(logo-V2.png); background-size: 300px; background-repeat: no-repeat; background-position: center;">

			<p align="center">
				<h2 id="titulo1">Sistema de Gestión Empaque S.A</h2>
			</p>

			<div class="row">
				<div class="span10">
					<div class="navbar">
						<div class="navbar-inner">
							<div class="container">
								<div class="nav-collapse">
									<ul class="nav">
										<?php $var = $menu->menu_ppal_v2($CadenaPermisos); ?>
									</ul>	
									<ul class="nav pull-right">
										<li class="divider-vertical"></li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong><?php echo $_SESSION['Nombre']; ?></strong><b class="caret"></b></a>
											<ul class="dropdown-menu">
												<li><a href="index.php">Cerrar sesión</a></li>
											</ul>
										</li>
									</ul>
								</div><!-- /.nav-collapse -->
							</div>
						</div><!-- /navbar-inner -->
					</div>
				</div>
			</div>

			<div class="row hidden">
				<div class="span10">
					<div class="navbar">
						<div class="navbar-inner">
							<div class="container">
								<div class="nav-collapse">								
									<ul class="nav">
										<?php $var = $menu->menu_ppal($CadenaPermisos); ?>
									</ul>
									<ul class="nav pull-right">
										<li class="divider-vertical"></li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong><?php echo $_SESSION['Nombre']; ?></strong><b class="caret"></b></a>
											<ul class="dropdown-menu">
												<li><a href="index.php">Cerrar sesión</a></li>
											</ul>
										</li>
									</ul>
								</div><!-- /.nav-collapse -->
							</div>
						</div><!-- /navbar-inner -->
					</div>
				</div>
			</div>

			<?php echo $var; ?>

			<div class="row hidden">
				<div class="span12" style="text-align: left;">
					<a href="#" class="btn btn-success" onClick="AgregarNota()">Agregar Nota</a>
				</div>
			</div>

			<?php
			/*
			if(!isset($_GET['day']))
			{
				$fecha = getdate();
				$menu->getNotes($fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday']); 
			}
			else
			{
				$menu->getNotes($_GET['day']); 
			}*/
			?>

		</div>
	</center>


</div>

<?php

require("footer.php");

?>

<!-- Sub Modal para Notas -->
<div class="modal hide fade" id="modal_Notas">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<center>
			<h3>Notas</h3>
		</center>
	</div>
	<div class="modal-body">
		<input type="hidden" id="idNota_">
		<input type="hidden" id="Leido_">
		<div class="row">
			<div class="span2"><input type="text" placeholder="Título" id="titulo" maxlength="20"></div>
			<div class="span2 offset1">
				<div id="error_nota" class="alert alert-danger" role="alert" style="display: none;">
					<center><b>¡Error!</b></center>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span2"><textarea id="detalle" placeholder="Detalle" maxlength="120" rows="4"></textarea></div>
			<div class="span2 offset1">
				<select id="tipo">
					<option value="1">Información</option>
					<option value="2">Advertencia</option>
					<option value="3">Urgente</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="span2"><input type="text" id="fecha1" name="fecha1" class="input-small" readonly></div>
			<div class="span3" style="text-align: right;">
				<?php
				if ($_SESSION['admin'] == 1) {
					?><p id="t_">Enviar a todos <input type="checkbox" id="todos"></p><?php
																																				}
																																				?>
			</div>
		</div>
		<div class="row">
			<hr>
		</div>
		<div class="row">
			<div class="span2">
				<select id="categoría_msj">
					<option value="0">Por categoría</option>
					<?php
					$sql = "SELECT id, descripcion FROM  `categoria_usuarios` WHERE estado = 1";
					$res = mysql_query($sql);
					while ($r = mysql_fetch_array($res)) {
						echo '<option value="' . $r['id'] . '">' . htmlentities($r['descripcion']) . '</option>';
					}
					?>
				</select>
			</div>
			<div class="span2 offset1">
				<select id="usuarios_msj">
					<option value="0">Por Usuario</option>
					<?php
					$sql = "SELECT id_usuario, nombre_real FROM `usuarios` order by nombre_real asc";
					$res = mysql_query($sql);
					while ($r = mysql_fetch_array($res)) {
						echo '<option value="' . $r['id_usuario'] . '">' . htmlentities($r['nombre_real']) . '</option>';
					}
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" onClick="Cerrar()">Cancelar</a>
		<a href="#" class="btn btn-info" onCLick="Leer_()" id="btnNL">Marcar como leido</a>
		<a href="#" class="btn btn-danger" onCLick="Leer_()" id="btnL">Marcar como no leido</a>
		<a href="#" class="btn btn-success" onCLick="validar_nota()" id="btnN">Aceptar</a>
	</div>
</div>
<!-- -->


<script>
	function Cerrar() {
		$("#modal_Notas").modal('hide');
	}

	function LeerPop(idNota, leido, titulo, descripcion, fecha, tipo) {
		Limpiar();
		Habilitar(false);
		$("#idNota_").val(idNota);
		$("#Leido_").val(leido);
		$("#titulo").val(titulo);
		$("#detalle").val(descripcion);
		$("#tipo").val(tipo);
		var aux = fecha.split(' ');
		aux = aux[0].split('-');
		$("#fecha1").val(aux[2] + '-' + aux[1] + '-' + aux[0]);

		if (leido == true) {
			//marcar como leido
			$("#btnL").show();
			$("#btnNL").hide();

		} else {
			//marcar como no leido
			$("#btnL").hide();
			$("#btnNL").show();
		}
		$("#btnN").hide();

		$("#modal_Notas").modal('show');
	}

	function Limpiar() {
		$("#titulo").val('');
		$("#detalle").val('');
		$("#fecha1").val();
		$("#todos").attr('checked', false);
		$("#tipo").val('1');
		var d = new Date();
		$('#fecha1').datepicker();
		$('#fecha1').datepicker({
			minDate: new Date(d.getFullYear(), d.getMonth(), d.getDate())
		});
		$('#fecha1').datepicker('option', 'dateFormat', 'dd-mm-yy');
		$('#fecha1').datepicker('setDate', '".$fechin."');
	}

	function validar_nota() {
		if ($("#titulo").val() == "" || $("#detalle").val() == "") {
			$("#error_nota").show("slow");
			return;
		}

		$("#error_nota").hide("slow");

		var data_ajax = {
			type: 'POST',
			url: "notascrear.php",
			data: {
				xtitulo: $("#titulo").val(),
				xdetalle: $("#detalle").val(),
				xfecha: $("#fecha1").val(),
				xtodos: $("#todos").is(':checked'),
				xtipo: $("#tipo").val(),
				xcategoria: $("#categoría_msj").val(),
				xusuario: $("#usuarios_msj").val()
			},
			success: function(data) {
				location.reload();
			},
			error: function() {
				alert("Error de conexión.");
			},
			dataType: 'json'
		};
		$.ajax(data_ajax);
	}
	$(function() {
		var d = new Date();
		$('#fecha1').datepicker();
		$('#fecha1').datepicker({
			minDate: new Date(d.getFullYear(), d.getMonth(), d.getDate())
		});
		$('#fecha1').datepicker('option', 'dateFormat', 'dd-mm-yy');
		$('#fecha1').datepicker('setDate', '".$fechin."');
	});

	function AgregarNota() {
		Limpiar();
		Habilitar(true);
		$("#btnL").hide();
		$("#btnNL").hide();
		$("#btnN").show();
		$("#idNota_").val(0);
		$("#modal_Notas").modal('show');
	}

	function Habilitar(estado) {
		if (estado == false) {
			$("#titulo").attr('readonly', 'readonly');
			$("#detalle").attr('readonly', 'readonly');
			$("#fecha1").attr('readonly', 'readonly');
			$("#todos").attr('readonly', 'readonly');
			$("#tipo").attr('readonly', 'readonly');
			$("#t_").hide();
			$("#categoría_msj").hide();
			$("#usuarios_msj").hide();
		} else {
			$("#titulo").removeAttr('readonly');
			$("#detalle").removeAttr('readonly');
			$("#fecha1").removeAttr('readonly');
			$("#todos").removeAttr('readonly');
			$("#tipo").removeAttr('readonly');
			$("#t_").show();
			$("#categoría_msj").show();
			$("#usuarios_msj").show();
		}
	}

	function Leer_() {
		Leer($("#idNota_").val(), $("#Leido_").val());
	}

	function Leer(id, estado) {

		if (estado == 0)
			estado = 1;
		else
			estado = 0;
		var data_ajax = {
			type: 'POST',
			url: "notasleido.php",
			data: {
				xid: id,
				xestado: estado
			},
			success: function(data) {
				location.reload();
			},
			error: function() {
				alert("Error de conexión.");
			},
			dataType: 'json'
		};
		$.ajax(data_ajax);
	}
</script>