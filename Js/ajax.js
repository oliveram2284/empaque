function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}

function ajaxx(valor1,id_div,controller, lmtMenor, lmtMayor, opcion)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1+"~"+lmtMenor+"~"+lmtMayor+"~"+opcion);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function ajaxp(valor1,id_div,controller)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function ajaxx2(valor1,id_div,controller)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function ajaxxx(valor1,depId,id_div,controller)
{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1+"~"+depId);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   //RESPONDE CAJETON !!!! 
//c="+id_in+"~"+id_des

ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function Agregar(agregar,idProd,idDep,Cantidad,Bultos,Kg,id_div,archivo)
{
	if(agregar == "valido")
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idProd+"~"+idDep+"~"+Cantidad+"~"+Bultos+"~"+Kg);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
		
		Limpiar();
	 /*
	 */
	}else
	{
		return false();
	}
}

function AgregaraEgreso(agregar,idProd,idDep,Cantidad,Bultos,Kgs,id_div,archivo)
{
	if(agregar == "valido")
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idProd+"~"+idDep+"~"+Cantidad+"~"+Bultos+"~"+Kgs);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
		
		Limpiar();
	}else
	{
		return false;
	}
}

function Busque(idDep,idDiv,Archivo)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(idDiv);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", Archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idDep);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}	
	}
	
function eliminar(valor,id_div,archivo)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+valor);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
	}

function eliminar2(valor,depId,id_div,archivo)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+valor+"~"+depId);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
	}		

function ajax2(valor1,id_div,controller,nombreTabla)
{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1+"~"+nombreTabla);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
}

function ShowDiv(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='none')
	{ 
     document.getElementById(id).style.display='';
    }
	else
	{
     document.getElementById(id).style.display='none';
    }
}

function ShowDiv2(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='none')
	{ 
     document.getElementById(id).style.display='';
    }
	
}

function PopWindows(ventana,titulo, alto , ancho)
{ 
window.open(ventana,titulo, "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=yes,fullscreen=no,height="+alto+",width="+ancho+"");
}


function ShowDiv(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='')
	{ 
     document.getElementById(id).style.display='none';
    }
	else
	{
     document.getElementById(id).style.display='';
    }
}

var GAccion = "";

function AbrirPop(xid, accion)
  {
	document.getElementById('error_div').style.display = 'none';
	GAccion = accion;
	$('#table_hoja_ruta tr').remove();
	
	if(accion == 'U')
	{
		//pedir unicamente el número de hoja de ruta.
		//ocultar div de busqueda de productos
		//document.getElementById('codigoProducto').style.display = 'none';
		document.getElementById('groupBtn').style.display = 'none';
		document.getElementById('codigoLbl').style.display = 'none';
		document.getElementById('descriptionProd').style.display = 'none';
		document.getElementById('codigoTangoProd').style.display = 'none';
		//alert("tiene que ocultar");
	}
	else
	{
		//pedir el número de hoja de ruta y el código de producto.
		//hacer visible el div de busqueda de productos
		//document.getElementById('codigoProducto').style.display = 'block';
		document.getElementById('groupBtn').style.display = 'block';
		document.getElementById('codigoLbl').style.display = 'block';
		document.getElementById('descriptionProd').style.display = 'block';
		document.getElementById('codigoTangoProd').style.display = 'block';
		//alert("tiene que mostrar");
		
		//BUscar hojas de rutas para ese pedido
		$('#tableEditHRCI tbody').html('');
		
		var data_ajax={
			type: 'POST',
			url: "../gethrci.php",
			data: { id: xid},
			success: function( data ) {
					 $.each(data, function(k,v)
					  {
					      var fila = "<tr id=\""+v.value+"\"><td>"+v.value+"</td>";
					      fila += "<td style=\"text-align: right;\"><input style=\"margin-right:100px;\" type=\"button\" value=\"X\" class=\"btn btn-danger\" onclick=\"removerFila('"+v.value+"')\"></td></tr>";
					      $('#table_hoja_ruta > tbody:last').append(fila);
					  });
				},
			error: function(){
		    console.log("Error de conexión.");
		  },
			dataType: 'json'
			};
		
		$.ajax(data_ajax);
		
		if (accion == "EH") {
			//obtener los datos del producto
			//si es un producto nuevo no se completan los campos
			var data_ajax={
				type: 'POST',
				url: "/empaque_demo/getPedidos.php",
				data: { idP: xid},
				success: function( data ) {
						if (data[0]['productoCodigo'][0] == "n") {
							$('#codigoProducto').val('');
							$('#descriptionProd').val('');
							$('#codigoTangoProd').val('');
						}
						else
						{
							$('#codigoProducto').val(data[0]['productoCodigo']);
							$('#descriptionProd').val(data[0]['descripcion']);
							$('#codigoTangoProd').val(data[0]['productoCodigoT']);
						}
					},
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
		
		$	.ajax(data_ajax);
		}
		
	}
	$('#modal_produccion').modal('show');
	$('#idPed').text(xid);
	
  }
  
function PedidoEnCurso()
{
	var HojasDeRutaArrayFinal = new Array();
	
	//$("#table_hoja_ruta tbody tr").each(function (index) {
	//	$(this).children("td").each(function (index2) {
	//		HojasDeRutaArrayFinal.push($(this).text());		
	//	});
	//});
	
	$("#table_hoja_ruta tbody tr").each(function (index) {
		HojasDeRutaArrayFinal.push($(this)[0].id);
	});
	
	if(HojasDeRutaArrayFinal.length <= 0)
	{
		//Error
		document.getElementById('error_div').style.display = 'block';
		document.getElementById('error_msj').innerHTML = "<strong>Error!!!</strong> Ingrese al menos una hoja de ruta.";

		return false;
	}
	else
	{
		if(GAccion == 'U')
		{
			document.getElementById('error_div').style.display = 'none';
			
			//Solo modificar hoja de ruta
			var idPedido = $('#idPed').text();
			var hojaRuta = document.getElementById('hojaRuta').value;
		
			var data_ajax={
				type: 'POST',
				url: "/empaque_demo/insertPedido.php",
				data: { id: idPedido , action: GAccion , hoja: HojasDeRutaArrayFinal},
				success: function( data ) {
						$('#modal_produccion').modal('hide');
						location.reload();
					},
				error: function(){
						    alert("Error de conexión.");
						  },
				dataType: 'json'
				};
			
			$.ajax(data_ajax);
		}
		else
		{
			//validar producto
			if(document.getElementById('codigoProducto').value == "" || document.getElementById('codigoProducto').value == null)
			{
			//Error
			document.getElementById('error_div').style.display = 'block';
			document.getElementById('error_msj').innerHTML = "<strong>Error!!!</strong> Completa el código del producto.";
			
			return false;
			}
			else
			{
				document.getElementById('error_div').style.display = 'none';
				
				//Solo modificar hoja de ruta
				var idPedido = $('#idPed').text();
				var hojaRuta = document.getElementById('hojaRuta').value;
				
				/* Actualizar codigo del producto nuevo */
				var codigoProducto = $('#codigoProducto').val();
				var descProductos = $('#descriptionProd').val();
				var tangoCodigo = $('#codigoTangoProd').val();
				/****************************************/
				
				var data_ajax={
					type: 'POST',
					url: "/empaque_demo/insertPedido.php",
					data: { id: idPedido , action: GAccion , hoja: HojasDeRutaArrayFinal, code: codigoProducto, desc: descProductos, tango: tangoCodigo},
					success: function( data ) {
							$('#modal_produccion').modal('hide');
							location.reload();
						},
					error: function(){
							    alert("Error de conexión.");
							  },
					dataType: 'json'
					};
				
				$.ajax(data_ajax);
			}
		}
	}
	
}

function AbrirPopTerminado(id, producto, codigo)
  {
	document.getElementById('error_div_ter').style.display = 'none';
	//$('#modal_terminado').modal('show');
	$('#idPed').val(id);
	$('#nomProducto').html();
	$('#NTPid').html();
	$('#nomProducto').text(producto);
	$('#NTPid').text(codigo);
	$("#calculo").html("$ 0.00 /Kg.");
	$("#tbcantidad").val("");
	$("#tbkg").val("");
	$("#tbbulto").val("");
	$("#cotizacionMM").val("1");
	
	//Acá poner llamado Ajax para obtener datos del pedido seleccionado.
	var data_ajax={
		type: 'POST',
		url: "/empaque_demo/getPedidos.php",
		data: {
			idP: id 
			},
		success: function( data ) {
				if (data != 0) {
					$.each(data, function(k,v){
						$.each(v, function(i,j){
							$("#"+i).text(j);
						});
					});
					
					if(data[0]['iptObserv'] == null || data[0]['iptObserv'] == "") {
						$('#linkObservaciones').css("display","none");
					}
					else
					{
						$('#linkObservaciones').css("display","block");
					}
					
					$("#CotCot").text(data[0]['cotizacionMM']);
					$("#cotizacionMM").val(data[0]['cotizacionMM']);
					
					var dataX = $('#precio').text();
					var divideEn = 1;
					if(dataX.indexOf("Final") != -1)
						divideEn = 1.21;
						
					var arr = dataX.split(' ');
					var precio = 0;
					if(arr[4]== undefined)
					{
					    precio = arr[1];
					}
					else
					{
					    precio = arr[4];
					}
					
					var cotizacion = parseFloat($("#cotizacionMM").val());
					
					$("#PrecioCotCot").text("$ " + ((precio * cotizacion) / divideEn).toFixed(4));
					if(data[0]['ObservaPolimero'] == "")
					{
						$("#esconderBtn").hide();
					}
					else
					{
						if (data[0]['importe'] == undefined ||
						data[0]['importe'] == null ||
						data[0]['importe'] == "" ||
						data[0]['importe'] == 0
						)
						{
							$("#esconderBtn").hide();
						}
						else
						{
							$("#esconderBtn").show();
							$("#iconDetailPolimero").attr("title",data[0]['ObservaPolimero']);
						}
					}
					
					if (data[0]['importe'] == undefined ||
					    data[0]['importe'] == null ||
					    data[0]['importe'] == "" ||
					    data[0]['importe'] == 0
					    ) {
						//no se factura polimero
						$("#btnFacturarSiNo").removeClass('btn-danger');
						$("#btnFacturarSiNo").addClass('btn-success');
						$("#spanMoneyTitle").text('No Existe Polímero');
						$("#spanMoney").text('a Facturar');
						$('#btnFacturarSiNo').attr('disabled', 'disabled');
					}
					else
					{
						$("#spanMoneyTitle").text('Facturar Polímero');
						$("#spanMoney").text('$ '+ data[0]['importe']);
						
						if (data[0]['yaSeFacturo'] != 0) {
							//ya se factura polimero
							$("#btnFacturarSiNo").removeClass('btn-danger');
							$("#btnFacturarSiNo").addClass('btn-success');
							$('#btnFacturarSiNo').attr('disabled', 'disabled');
						}
						else
						{
							//se debe facturar
							$("#btnFacturarSiNo").removeClass('btn-success');
							$("#btnFacturarSiNo").addClass('btn-danger');
							$('#btnFacturarSiNo').removeAttr('disabled');
						}
					}
					
				}
				
				$('#modal_terminado').modal('show');
				
				var porcent = ((5 * $("#cantidad").html()) / 100);
				var entregado = ($("#cantidadEntregada").html() * 1).toFixed(2);
				var cantidad = ($("#cantidad").html() * 1).toFixed(2);
								
				if ( entregado < ((cantidad * 1) + (porcent * 1)) && entregado > ((cantidad * 1) - (porcent * 1))) {
					$("#calc2").html('<b style="color: green">' + entregado + '</b>');
				}
				else
					{
						if (entregado < ((cantidad * 1) - (porcent * 1))) {
							$("#calc2").html('<b style="color: blue">' + entregado + '</b>');
						}
						else
						{
							$("#calc2").html('<b style="color: red">' + entregado + '</b>');
						}
					}
			},
		error: function(){
				    alert("Error de conexión.");
				  },
		dataType: 'json'
		};
	
	$.ajax(data_ajax);	
  }

function AbrirPopEditarPrecio(id, producto, codigo)
{
	document.getElementById('error_div_edt_p').style.display = 'none';
	$('#idPed').val(id);
	$('#nomProductoEdit').html();
	$('#NTPidEditP').html();
	$('#nomProductoEdit').text(producto);
	$('#NTPidEditP').text(codigo);
	$('#onlyEdit').val('1');
	//Acá poner llamado Ajax para obtener datos del pedido seleccionado.
	var data_ajax={
		type: 'POST',
		url: "/empaque_demo/getPedidos.php",
		data: {
			idP: id 
			},
		success: function( data ) {
				if (data != 0) {
					$.each(data, function(k,v){
						$.each(v, function(i,j){
							$("#"+i+"Edit").text(j);
						});
					});
				}
				$('#modal_editar_precio').modal('show');
			},
		error: function(){
				    alert("Error de conexión.");
				  },
		dataType: 'json'
		};
	
	$.ajax(data_ajax);
	
}

function PedidoTerminado()
{
	if($("#btnFacturarSiNo").attr('disabled')){
		//alert("ok");
	}else{
		if($("#btnFacturarSiNo").hasClass('btn-success'))
		{
			//alert("okkk");
		}
		else
		{
			document.getElementById('error_div_ter').style.display = 'block';
			document.getElementById('error_msj_ter').innerHTML = "<strong>Error!!!</strong> Indique que esta notificado de facturar el polímero en esta entrega.";
			return;
		}
	}
	
	var idPedido = document.getElementById('idPed').value;
	var accion;
	var cantidad = 0;
	var bulto = 0;
	var kg = 0;
	
	if(document.getElementById('optionsRadios').checked == true)
	{ accion = "T";	}
	else
	{ accion = "TP"; }
	
	if(
	   document.getElementById('tbcantidad').value.length <= 0 ||
	   document.getElementById('tbbulto').value.length <= 0 ||
	   document.getElementById('tbkg').value.length <= 0 
	   )
	{
		document.getElementById('error_div_ter').style.display = 'block';
		document.getElementById('error_msj_ter').innerHTML = "<strong>Error!!!</strong> Las cantidades son obligatorias.";
	}
	else
	{
		var corte = false;
		//Evaluar que sean números
		if(isNaN(document.getElementById('tbcantidad').value) == true)
		{ 
			document.getElementById('error_div_ter').style.display = 'block';
			document.getElementById('error_msj_ter').innerHTML = "<strong>Error!!!</strong> Solo se permiten números en las cantidades.";
			corte =true;
		}
		else
		{
			cantidad = document.getElementById('tbcantidad').value;
			
			if(isNaN(document.getElementById('tbbulto').value) == true)
			{
				document.getElementById('error_div_ter').style.display = 'block';
				document.getElementById('error_msj_ter').innerHTML = "<strong>Error!!!</strong> Solo se permiten números en las cantidades.";
				corte =true;
			}
			else
			{
				bulto = document.getElementById('tbbulto').value;
				
				if(isNaN(document.getElementById('tbkg').value) == true)
				{
					document.getElementById('error_div_ter').style.display = 'block';
					document.getElementById('error_msj_ter').innerHTML = "<strong>Error!!!</strong> Solo se permiten números en las cantidades.";
					corte =true;
				}
				else
				{
					kg = document.getElementById('tbkg').value;
				}
			}	
		}
		
		if(corte == false)
		{
			var data_ajax={
					type: 'POST',
					url: "/empaque_demo/insertPedido.php",
					data: {
						id: 		idPedido 	,
						action: 	accion 		,
						cantidad:	cantidad	,
						bulto: 		bulto		,
						kg: 		kg		,
						fecha: 		document.getElementById('fechaOper').value
						},
					success: function( data ) {
							$('#modal_produccion').modal('hide');
							location.reload();
						},
					error: function(){
							    alert("Error de conexión.");
							  },
					dataType: 'json'
					};
				
				$.ajax(data_ajax);
		}
	}
	
}

function Seguimiento(idPedido, codigoPedido)
{
	$('#idC').text("N\u00famero " + codigoPedido);
	$('#modal_seguimiento').modal('show');
	CargarLog(idPedido);
}

function AbrirMotivos(idPedido)
{	console.debug("====> AbrirMotivos open");
	$('#idC').text("Motivos de rechazo.");
	$('#modal_seguimiento').modal('show');
	CargarLogMotivos(idPedido);
}

function AbrirMotivosCancelados(idPedido)
{
	$('#idC').text("Motivos de Cancelación.");
	$('#modal_seguimiento').modal('show');
	CargarLogMotivosCancelados(idPedido);
}

function AbrirMotivosRechazados(idPedido)
{
	$('#idC').text("Motivos de Rechazo.");
	$('#modal_seguimiento').modal('show');
	CargarLogMotivosRechazados(idPedido);
}

function CargarLog(idPedido)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById('div_seguimiento');
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", "loadLog.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idPedido);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}	
	}
	
function CargarLogMotivos(idPedido)
{
	

	$.ajax({
	  type: "POST",
	  url: "services/pedidos.php",
	  data: {action:1,id:idPedido},
	  success: function( data ) {			
			var pedido= data.pedido;
			console.debug("==>services/pedidos.php pedido: %o",pedido);
		  var output="";
		  		  
		  if(pedido.hojaruta!='NN' && pedido.hojaruta!='' &&pedido.hojaruta!=null){
		  	output+="<p>";
		  	output+="<label><b> Hoja de Ruta Nroº:</b> <span class='label label-success'>"+pedido.hojaruta+"</span> </label> ";
		  	output+="</p>";
		  }

		  if(pedido.estaImpreso=='1'){
		  	output+="<p>";
		  	output+='<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>  <strong>Atención!</strong> Esta Nota de Pedido pudo haber sido impresa anteriormente';
		  	output+="</p>";
		  }


		  $("div.head_div").empty().html(output);
		},
	   dataType: 'json'
	});

	
	$.post( "loadLogMotivos.php",{variable:idPedido}, function( data ) {
		console.debug("==>loadLogMotivos");
	  $( "#div_seguimiento" ).html( data );
	});

	

	
}
	
function CargarLogMotivosCancelados(idPedido)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById('div_seguimiento');
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", "loadLogMotivosCancelados.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idPedido);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}	
	}

function CargarLogMotivosRechazados(idPedido)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById('div_seguimiento');
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", "loadLogMotivosRechazados.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idPedido);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}	
	}