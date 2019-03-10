//console.debug("===> LOCATION: %o", $(location).attr('hostname'));
//console.debug("===> host_url_ajax: %o", host_url_ajax);

console.log("====> LOAD OK");
var hostname = $(location).attr('hostname');
var host_url_ajax = '';
if (hostname == 'empaque.des') {
    //host_url_ajax = 'http://190.3.7.29:301/empaque_demo/';
    host_url_ajax = 'http://58d70548161e.sn.mynetname.net:301/empaque_demo/';
}
$(function() {

    var accionPedido = $("#accionPedido").val();
    if (accionPedido != 'I') {
        console.log(accionPedido);
        console.log($("#cantidad").val());
        $("#cantidad").maskMoney('mask', $("#cantidad").val());
        get_ficha_tecnica($("#codigoProductop").val());
        $("#moneda").trigger('change');
    }

});

var campos_para_validar = [];
var cliente = true;


var fechaIn = $("#fecha1").data('fechain');
console.debug("===> fechaIn: %o", fechaIn);
var d = new Date();
var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());

$("#fecha1").datepicker({
    minDate: today,
    dateFormat: 'dd-mm-yy',
    setDate: fechaIn
});

console.debug("==> fechaIn: %o", fechaIn);
var seteaFechaEntrega = function() {
    var d = new Date();
    var formato_id = $("#formato").val();
    var material_id = $("#material").val();
    var data_ajax = {
        type: "POST",
        url: "services/DiasMaterialesFormatos.php",
        data: { action: 5, formato_id: formato_id, material_id: material_id },
        success: function(data) {
            $("#fecha1").datepicker('destroy');
            var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());
            if (data.result == true) {
                today = new Date(data.date.year, data.date.month - 1, data.date.day);
                console.debug("===> New Date: %o", today);
                $("#fecha1").datepicker({
                    minDate: today,
                    dateFormat: 'dd-mm-yy'
                });
            } else {
                var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());
                console.debug("===> Today: %o", today);
                $("#fecha1").datepicker({
                    minDate: today,
                    dateFormat: 'dd-mm-yy',
                });
            }
            return false;
        },
        error: function(error_msg) {
            alert("error_msg: " + error_msg);
        },
        dataType: 'json'
    };
    $.ajax(data_ajax);
    return false;
};


$("#pop_close").live('click', function() {
    /*alert("ClOSE");*/
    $("#cantidad_modal").modal("hide");
    $("#cantidad").attr("readonly", true);
});


$("#tbCliente").typeahead({
    minLength: 3,
    items: 'all',
    showHintOnFocus: false,
    scrollHeight: 0,
    source: function(query, process) {
        var strng = $('#tbCliente').val();
        var input = [];
        input.push(strng);
        var data_ajax = {
            type: "POST",
            //method: "POST",
            //url: "jsons/buscarCliente.json",
            //url: "http://190.3.7.29:301/empaque_demo/buscarCliente.php",
            url: host_url_ajax + "buscarCliente.php",
            data: { xinput: strng, xpage: 1, busq: 1 },
            success: function(data) {
                console.debug("===> data client: %o", data.length);
                objects = [];
                map = {};
                $.each(data, function(i, object) {
                    var key = object.cod_client + " - " + object.razon_soci
                    map[key] = object;
                    objects.push(key);
                });
                return process(objects);

            },
            error: function(error_msg) {
                alert("error_msg: " + error_msg);
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
    },
    updater: function(item) {
        var data = map[item];
        $("#tbCliente").prop('maxLength', item.length);
        $("#codigoTango").val(map[item].cod_client);
        //$("#tbCliente").val(data.name).data('id',map[item].cod_client);
        $("#direccionCliente").val(data.domicilio);
        $("#telefonoCliente").val(data.telefono);
        $("#cuit").val(data.cuit);
        $("#dirCliente").val(data.domicilio);
        $("#facturarA").val(data.name);
        $("#codigoTangoFacturar").val(map[item].cod_client);
        return data.razon_soci;
    }
});

$("#codigoProductop").typeahead({
    minLength: 4,
    items: 'all',
    showHintOnFocus: false,
    scrollHeight: 0,
    source: function(query, process) {
        console.debug("codigoProductop typeahead() ");
        var temp = $('#codigoProductop').val();
        var strng = "";
        var input = [];
        input.push(strng);
        //#TODO: Recuperar filtro por +/-
        string_params = temp.split('%');

        console.debug("===> strng: %o", temp);
        console.debug("===> string_params: %o", string_params);

        busq = 1;
        switch (string_params[0]) {
            case '+':
                {
                    busq = 2;
                    break;
                }
            case '-':
                {
                    busq = 3;
                    break;
                }
            case '+-':
            case '-+':
                {
                    busq = 4;
                    break;
                }
            default:
                {
                    busq = 1;
                    break;
                }
        }

        if (string_params[1] !== undefined) {
            console.debug
            $strng = string_params[1];
        } else {
            $strng = string_params[0];
        }

        console.debug("===> busq= %o", busq);
        console.debug("===> strng= %o", strng);



        var data_ajax = {
            type: "POST",
            //method: "POST",
            //url: "jsons/buscarArticulo.json",
            //url: "http://190.3.7.29:301/empaque_demo/buscarProducto.php",
            url: host_url_ajax + "buscarProducto.php",
            data: {
                xinput: strng,
                xpage: 1,
                busq: busq
            },
            success: function(data) {
                console.debug(data);
                objects = [];
                map = {};
                $.each(data, function(i, object) {

                    var key = object.Id + " - " + object.Articulo
                    map[key] = object;
                    console.debug(key);
                    objects.push(key);
                });
                return process(objects);
            },
            error: function(error_msg) {
                alert("error_msg: " + error_msg);
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
    },
    updater: function(item) {
        var data = map[item];
        $("#nombreProducto").val(data.Articulo);
        $("#articuloTangoCode").val(data.Nombre_en_Facturacion);
        $("#descripcionProducto").val(data.Nombre_en_Facturacion);
        get_ficha_tecnica(data.Id);
        return data.Id;
    }

});



function get_ficha_tecnica(id) {
    console.debug("====> GET FICHA URL: %o", host_url_ajax + "buscarProductoFicha.php");

    var data_ajax = {
        method: "POST",
        //url: "http://190.3.7.29:301/empaque_demo/buscarProductoFicha.php",
        url: host_url_ajax + "buscarProductoFicha.php",
        data: { id: id },
        dataType: "json",
        success: function(data) {

            var articulo = data.articulo;
            var ficha_tecnica_detalle = data.Fichas_Tecnica_Detalle;
            var color = "";
            var formato = data.Formato;
            var material = data.Material;

            switch ($("#accionPedido").val()) {
                case 'A':
                case 'E':
                    {
                        console.log("===> buscarProductoFicha");
                        console.log(ficha_tecnica_detalle);

                        if (ficha_tecnica_detalle.length < 1) {
                            var output = "<p style='font-size:20px; color:#000000'>El Articulo <b style='color:red'> " + valor + " </b> <br> No posee Ficha Técnica en Mercedario.<br> Por favor, ingrese datos manualmente<p>";
                            swal({
                                title: "Advertencia!",
                                text: output,
                                type: "warning",
                                confirmButtonText: "Ok",
                                html: true
                            });
                            //color = data.Color.Color;
                        }
                        var first_color = false;
                        var cantidad_pistas = null;
                        $.each(ficha_tecnica_detalle, function(index, item) {

                            if (item.Nombre == 'CANT. DE PISTAS' || item.Id_Unidad_Medida == "4005") {
                                console.debug("=> Cantidad de Pistas: %o", item.Valor);
                                cantidad_pistas = parseFloat(item.Valor).toFixed(0);

                                if (articulo.Id.substring(0, 2) == 'I0') {
                                    $("#cant_pista").val(cantidad_pistas);
                                }
                            }

                        });


                        break;
                    }
                case 'I':
                    {


                        $("#ancho").val(null);
                        $("#largo").val(null);
                        $("#micronaje").val(null);
                        $("#color").val(null);
                        $("#fuelle").val(null);
                        $("#origen").removeAttr("readonly");
                        $("#cantidad").val(null).attr("readonly", true);

                        if (ficha_tecnica_detalle.length < 1) {
                            var output = "<p style='font-size:20px; color:#000000'>El Articulo <b style='color:red'> " + valor + " </b> <br> No posee Ficha Técnica en Mercedario.<br> Por favor, ingrese datos manualmente<p>";
                            swal({
                                title: "Advertencia!",
                                text: output,
                                type: "warning",
                                confirmButtonText: "Ok",
                                html: true
                            });
                            //alert(output);
                            color = data.Color.Color;
                        }

                        var first_color = false;
                        var cantidad_pistas = null;
                        $.each(ficha_tecnica_detalle, function(index, item) {

                            var i = 0;
                            if (item.Id_Unidad_Medida == '200') {
                                $("#ancho").val(item.Valor);
                                i = 1;
                            }

                            if (item.Id_Unidad_Medida == '5000') { //.Nombre=='LARGO PT'||item.Nombre=="LARGO  PT"){
                                $("#largo").val(item.Valor);
                                i = 1;
                            }

                            //if(item.Nombre=='MICRONAJE 1'){
                            if (item.Id_Unidad_Medida == '40') {
                                $("#micronaje").val(item.Valor);
                                i = 1;
                            }

                            if (item.Nombre == 'FUELLE 1') {
                                $("#fuelle").val(item.Valor);
                                i = 1;
                            }



                            //if(item.Nombre=='COLOR 1' && first_color!=true){
                            /*if (item.Nombre == 'COLOR 1') {
                                color += item.Referencia.replace("[object Object]", "") + "  ";
                                i = 1;
                                first_color = true;
                            }*/

                            if (item.Id_Unidad_Medida == "80") {
                                console.debug("COLOR MATERIAL: %o", item);
                                color = item.Referencia.replace('-', '').trim();
                                console.debug("COLOR MATERIAL: %o", color);
                            }

                            if (item.Nombre == 'CANT. DE PISTAS' || item.Id_Unidad_Medida == "4005") {
                                console.debug("=> Cantidad de Pistas: %o", item.Valor);
                                cantidad_pistas = parseFloat(item.Valor).toFixed(2);
                            }

                        });

                        console.debug("===> sdsd articulo ID: %o", articulo.Id.substring(0, 2));
                        //reset cant_pista
                        $("#cant_pista").val(null);

                        switch (articulo.Id.substring(0, 2)) {
                            case 'L0':
                            case 'T0':
                                {
                                    $("#micronaje").val(articulo.Espesor);
                                    $("#largo").val(articulo.Largo);
                                    break;
                                }
                            case 'I0':
                                {
                                    console.debug("===> articulo.Id: %o ", articulo.Id);
                                    $("#micronaje").val(articulo.Espesor);
                                    $("#largo").val(articulo.Largo);
                                    $("#cant_pista").val(cantidad_pistas);

                                    break;
                                }

                                break;
                            default:

                        }
                        /*if(articulo.Id.startsWith("L0") || articulo.Id.startsWith("T0")){
                        		$("#micronaje").val(articulo.Espesor);
                        }*/

                        $("#color").val(color);

                        if (formato != null) {
                            console.debug("===> formato.formato_i: %o", formato.formato_id);
                            $("#formato").removeAttr("selected");
                            $("#formato option[value=" + formato.formato_id + "] ").attr("selected", "selected");
                        }
                        if (material != null) {
                            $("#material option[value=" + material.material_id + "] ").attr("selected", "selected");
                            $("#material").trigger("change");
                        }
                        break;
                    }
                default:
                    {

                        break;
                    }
            }


        },
        error: function(error_msg) {
            alert("error_msg: " + error_msg);
        }
    };
    $.ajax(data_ajax);

}


function BuscarClientes() {
    cliente = true;
    $("#buscador").val("");
    $("#resultado_Cliente").html("");
    $('#ClientesPop').modal('show');
    setTimeout(function() { $('#buscador').focus(); }, 1000);
};

//Cliente a facturar !!!!
function BuscarFacturars(value) {
    cliente = false;
    $("#buscador").val("");
    $("#resultado_Cliente").html("");
    $('#ClientesPop').modal('show');
    setTimeout(function() { $('#buscador').focus(); }, 1000);
}

function ClosePop(div) {
    var idDiv = "#" + div;
    $(idDiv).modal('hide');
}

function BuscadorDeClientes(value) {
    var input = [];
    input.push(value);
    var color = '#FFFFFF';
    var data_ajax = {
        type: 'POST',
        //url: "/empaque_demo/buscarCliente.php",
        //url: "http://190.3.7.29:301/empaque_demo/buscarCliente.php",
        url: host_url_ajax + "buscarCliente.php",
        data: { xinput: input },
        success: function(data) {
            if (data != 0) {
                var fila = '<table class="table  table-bordered table-condensed">';
                fila += '<thead><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th>Razón Social</th></tr></thead>';
                fila += "<tbody>";
                $.each(data, function(k, v) {
                        if (color == '#A9F5A9') {
                            color = '#FFFFFF';
                        } else {
                            color = '#A9F5A9';
                        }
                        //Datos de cada cliente
                        var idCodigo = "";
                        $.each(v, function(i, j) {
                            if (i == "cod_client") //<i class="iconic-o-check" style="color: #51A351"></i>
                            {
                                //Icono  accept
                                fila += '<tr style="cursor: pointer; background-color:' + color + '" id="' + j + '" onClick="Seleccionado(\'' + j + '\')">';
                                fila += '<td>';
                                fila += '<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
                                fila += '</td>';
                                fila += "<td>" + j + "</td>";
                                fila += '<input type="hidden" id="' + j + '_c" value="' + j + '">';
                                idCodigo = j;
                            }
                            if (i == "razon_soci") {
                                fila += "<td>" + j + "</td>";
                                fila += '<input type="hidden" id="' + idCodigo + '_rz" value="' + j + '">';
                            }
                            if (i == "telefono_1") {
                                fila += '<input type="hidden" id="' + idCodigo + '_f" value="' + j + '">';
                            }
                            if (i == "domicilio") {
                                fila += '<input type="hidden" id="' + idCodigo + '_d" value="' + j + '">';
                            }
                            if (i == "cuit") {
                                fila += '<input type="hidden" id="' + idCodigo + '_cu" value="' + j + '">';
                            }
                            if (i == "nom_com") {
                                fila += '<input type="hidden" id="' + idCodigo + '_n" value="' + j + '">';
                            }
                            if (i == "e_mail") {
                                fila += '<input type="hidden" id="' + idCodigo + '_mail" value="' + j + '">';
                            }
                            if (i == "telefono_2") {
                                fila += '<input type="hidden" id="' + idCodigo + '_protocolo" value="' + j + '">';
                            }
                        });

                        fila += "</tr>";

                    }

                );
                fila += "</tbody></table>";

                $("#resultado_Cliente").html(fila);

            } else {
                $("#resultado_Cliente").html('<strong style="color: red;">No se encontraron resultados</strong>');
            }
        },
        error: function() {
            swal({
                title: "Error!",
                text: "Error de conexión.",
                type: "error",
                confirmButtonText: "Cerrar"
            });
        },
        dataType: 'json'
    };
    $.ajax(data_ajax);
}

function Seleccionado(valor) {
    //tomar id pasado y buscar los valor para los campos correspondientes al cliente
    var id = "#" + valor + "_c";
    var rz = "#" + valor + "_rz";

    $("#facturarA").val($(rz).val());
    $("#codigoTangoFacturar").val($(id).val());

    if (cliente == true) {
        var te = "#" + valor + "_f";
        var dom = "#" + valor + "_d";
        var cu = "#" + valor + "_cu";
        var mail = "#" + valor + "_mail";
        var proto = "#" + valor + "_protocolo";

        $("#codigoTango").val($(id).val());
        $("#tbCliente").val($(rz).val());
        $("#telefonoCliente").val($(te).val());
        $("#direccionCliente").val($(dom).val());
        $("#cuit").val($(cu).val());

        $("#mail_protocolo").val($(mail).val());
        $("#envia_protocolo").val($(proto).val());

    }

    ClosePop("ClientesPop");
}

function BuscarProductoN() {
    if ($("#chkH").is(':checked')) {
        $("#buscadorP").val("");
        $("#resultado_Productos").html("");
        $('#ProductosPop').modal('show');
        setTimeout(function() { $("#buscadorP").focus(); }, 1000);
    }
}

function BuscadorDeProductos(value, page) {
    console.log(host_url_ajax);
    var color = '#FFFFFF';
    var data_ajax = {
        type: 'POST',
        //url: "http://190.3.7.29:301/empaque_demo/buscarProducto.php",
        url: host_url_ajax + "buscarProducto.php",
        data: { xinput: value, xpage: page, busq: $('#busc').val() },
        success: function(data) {
            if (data != 0) {
                var fila = '<table class="table table-bordered table-condensed" >';
                fila += '<thead><th style="width: 20px;"></th><th style="width: 70px;">Código</th><th style="width: 500px;">Artículo</th><th>Código Producto</th></tr></thead>';
                fila += "<tbody>";
                $.each(data, function(k, v) {
                        console.debug("===> PRODUCTOS: %o - %o", k, v);
                        if (color == '#A9F5A9') {
                            color = '#FFFFFF';
                        } else {
                            color = '#A9F5A9';
                        }
                        //Datos de cada cliente
                        var idCodigo = "";
                        $.each(v, function(i, j) {
                            if (i == "Id") {
                                //Icono
                                fila += '<tr style="cursor: pointer; background-color:' + color + '" id="' + j + '" data-pid="' + j + '">';
                                fila += '<td>';
                                fila += '<img src="./assest/plugins/buttons/icons/accept.png" width="15" heigth="15" title="Seleccionar"/>';
                                fila += '</td>';
                                fila += "<td>" + j + "</td>";
                                fila += '<input type="hidden" id="' + j + '_cp" value="' + j + '">';
                                idCodigo = j;
                            }
                            if (i == "Articulo") {
                                fila += '<td style="padding-left: 10px;">' + j + '</td>';
                                fila += '<input type="hidden" id="' + idCodigo + '_arp" value="' + j + '">';
                            }
                            if (i == "Nombre_en_Facturacion") {
                                fila += "<td>" + j + "</td>";
                                fila += '<input type="hidden" id="' + idCodigo + '_ncp" value="' + j + '">';
                            }


                        });
                        fila += '<td> <a class="btn btn-mini btn-info" href="#" data-code="' + v.Id + '"><i class="icon-search"></i></a> </td>';

                        fila += "</tr>";

                    }

                );
                fila += "</tbody></table>";

                $("#resultado_Productos").html(fila);

            } else {
                $("#resultado_Productos").html('<strong style="color: red;">No se encontraron resultados</strong>');
            }
        },
        error: function() {
            swal({
                title: "Error!",
                text: "Error de conexión.",
                type: "error",
                confirmButtonText: "Cerrar"
            });
        },
        dataType: 'json'
    };
    $.ajax(data_ajax);
}

//function SeleccionadoP(valor) {
$(document).on('click', '#resultado_Productos table tbody tr td', function() {
    var valor = $(this).parents('tr').data('pid');
    console.debug("====> pidsdsd: %o", valor);
    //return false;
    $("#ancho").val(null);
    $("#º").val(null);
    $("#micronaje").val(null);
    $("#color").val(null);
    $('#formato').prop('selectedIndex', 0);
    $('#material').prop('selectedIndex', 0);
    var ar = "#" + valor + "_arp";
    var nc = "#" + valor + "_ncp";
    $("#codigoProductop").val(valor);
    $("#nombreProducto").val($(ar).val());
    $("#descripcionProducto").val($(nc).val());

    var data_ajax = {
        method: "POST",
        //url: "http://190.3.7.29:301/empaque_demo/buscarProductoFicha.php",
        url: host_url_ajax + "buscarProductoFicha.php",
        data: { id: valor },
        dataType: "json",
        success: function(data) {
            var articulo = data.articulo;
            var ficha_tecnica_detalle = data.Fichas_Tecnica_Detalle;
            var color = "";
            var formato = data.Formato;
            var material = data.Material;

            $("#ancho").val(null);
            $("#largo").val(null);
            $("#micronaje").val(null);
            $("#color").val(null);
            $("#fuelle").val(null);
            //$("#origen").removeAttr("readonly");
            $("#cantidad").val(null).attr("readonly", true);

            if (ficha_tecnica_detalle.length < 1) {
                var output = "<p style='font-size:20px; color:#000000'>El Articulo <b style='color:red'> " + valor + " </b> <br> No posee Ficha Técnica en Mercedario.<br> Por favor, ingrese datos manualmente<p>";
                swal({
                    title: "Advertencia!",
                    text: output,
                    type: "warning",
                    confirmButtonText: "Ok",
                    html: true
                });
                color = data.Color.Color;
            }

            var first_color = false;
            $("#ancho").val("0.0");
            $("#largo").val("0.0");
            $("#micronaje").val("0.0");
            console.debug("===> Ficha Tecnica asdasdsa: %o", ficha_tecnica_detalle);
            $.each(ficha_tecnica_detalle, function(index, item) {

                var i = 0;
                if (item.Id_Unidad_Medida == '200') {
                    console.debug("===> ANCHO: %o", item.Valor);
                    $("#ancho").val(parseFloat(item.Valor).toFixed(2));
                    i = 1;
                }

                if (item.Id_Unidad_Medida == '5000') { //.Nombre=='LARGO PT'||item.Nombre=="LARGO  PT"){
                    console.debug("===> largo: %o", item.Valor);

                    $("#largo").val(parseFloat(item.Valor).toFixed(2));
                    i = 1;
                }


                //if(item.Nombre=='MICRONAJE 1'){
                if (item.Id_Unidad_Medida == '40') {
                    console.debug("===> micronaje: %o", item.Valor);

                    $("#micronaje").val(parseFloat(item.Valor).toFixed());
                    i = 1;
                }


                if (item.Nombre == 'FUELLE 1') {
                    $("#fuelle").val(item.Valor);
                    i = 1;
                }


                if (item.Id_Unidad_Medida == "80") {
                    console.debug("COLOR MATERIAL: %o", item);
                    color = item.Referencia.replace('-', '').trim();
                    console.debug("COLOR MATERIAL: %o", color);
                }

                if (item.Nombre == 'CANT. DE PISTAS' || item.Id_Unidad_Medida == "4005") {
                    console.debug("=> Cantidad de Pistas: %o", item.Valor);
                    cantidad_pistas = item.Valor;
                }

            });

            console.debug("===> sdsd articulo ID: %o", articulo.Id.substring(0, 2));
            //reset cant_pista
            $("#cant_pista").val(null);

            switch (articulo.Id.substring(0, 2)) {
                case 'L0':
                case 'T0':
                    {
                        $("#micronaje").val(parseFloat(articulo.Espesor).toFixed());
                        $("#largo").val(parseFloat(articulo.Largo).toFixed(2));
                        break;
                    }
                case 'I0':
                    {
                        console.debug("===> articulo.Id: %o ", articulo.Id);
                        $("#micronaje").val(parseFloat(articulo.Espesor).toFixed());
                        $("#largo").val(parseFloat(articulo.Largo).toFixed(2));
                        $("#cant_pista").val(cantidad_pistas);

                        break;
                    }

                    break;
                default:

            }
            /*
            console.debug("===> articulo ID: %o", articulo.Id);
            if (articulo.Id.startsWith("L0") || articulo.Id.startsWith("T0") || articulo.Id.startsWith("I0")) {
                console.debug("====> ARTICULO: %o", articulo);
                $("#micronaje").val(articulo.Espesor);
                $("#largo").val(articulo.Largo);
                $("#ancho").val(articulo.Ancho);

            } else {
                console.debug("===> ancho: %o", $("#ancho").val());
                console.debug("===> largo: %o", $("#largo").val());
                console.debug("===> micronaje: %o", $("#micronaje").val());
            }*/

            $("#color").val(color);

            if (formato != null) {
                $("#formato option[value=" + formato.formato_id + "] ").attr("selected", "selected");
                $("#formato").trigger("change");
            }
            console.debug("===> HERE MATERIAL");
            if (material != null) {
                console.debug("===> HERE MATERIAL");
                $("#material option[value=" + material.material_id + "] ").attr("selected", "selected");
                $("#material").trigger("change");
            }

        },
        error: function(error_msg) {
            alert("error_msg: " + error_msg);
        }
    };
    $.ajax(data_ajax);
    ClosePop("ProductosPop");
});

function chequeadoN(value) {

    //debugger;
    if ($("#versionNP").val() > 1) {
        if ($("#esNuevoNP").val() == 0 && value == "si") {
            $('#msj_error_pop').html("<strong>No se puede cambiar un producto de habitual a nuevo cuando la versión de la nota de pedido es mayor a 1.</strong>");
            $('#MensajesPop').modal('show');
            $("#chkH").attr('checked', 'checked');
            return;
        }
    }

    if (value == "si") {
        $("#codigoProductop").val("");
        $("#nombreProducto").val("");
        $('#nombreProducto').removeAttr('readonly');
        $("#descripcionProducto").val("");
        $("#div_busqueda_prod").removeClass("control-group error");
        //$("#observaciones").removeAttr('readonly');
    } else {
        $("#div_busqueda_prod").addClass("control-group");
        $("#div_busqueda_prod").addClass("error");
        $('#nombreProducto').attr('readonly', true);
        $("#descripcionProducto").val("");
        $("#codigoProductop").val("");
        $("#nombreProducto").val("");
        //$('#observaciones').val('');
        //$('#observaciones').attr('readonly', true);
    }
}




$(document).ready(function() {


    $("#material").change(function() {
        seteaFechaEntrega();

    });

    $("#formato").change(function() {

        $("#span_etiqueta").empty().css("display", "none");
        seteaFechaEntrega();
        //console.debug('$("#formato").change');
        campos_para_validar = [];
        $("#cantidad").val(null);
        $("#cantidad").attr("readonly", true);
        $("#origen").attr("readonly", true);
        clear_all();
        var op = $(this).find("option:selected").val();

        var data_ajax = {
            type: 'POST',
            url: "get_campos_obligatorios.php",
            data: { xinput: op },
            success: function(data) {
                //console.debug("formato  data: %o",data);
                if (data != 0) {
                    $("#origen").attr("readonly", true);
                    $.each(data, function(k, v) {
                        //console.debug("== >  k %o : %o",k,v);
                        var id_cmp = "#" + v;
                        campos_para_validar.push(id_cmp);

                        if (v == "termo" || v == "micro" || v == "troquelado") {
                            $(id_cmp).removeAttr('disabled');
                        } else if (v == 'origen') {
                            $("#origen").removeAttr('readonly');
                        } else {
                            $(id_cmp).removeAttr('readonly');
                        }
                    });
                }
            },
            error: function() {
                swal({
                    title: "Error!",
                    text: "Error de conexión.",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

            },
            dataType: 'json'
        };
        $.ajax(data_ajax);




    });


    //$("#input_cant_pop")

    $("#cantidad").live('click', function(e) {

        var id_formato = $("#formato").val();

        if ($("#largo").val().length < 1) {
            swal({
                title: "Error!",
                text: "<b>Debe Ingresar Largo de Producto.</b>",
                type: "error",
                html: true,
                confirmButtonText: "Cerrar"
            });
            $("#largo").focus();
            return false;
        }

        var largo = $("#largo").val();

        console.debug("===> aca id_formato : %o", id_formato);
        console.debug("===> largo: %o", largo);




        switch (id_formato) {
            case '0':
                {
                    alert("Debe Seleccionar un Formato.");
                    $("#formato").focus();
                    return false;
                    break;
                }
            case '6':
                {
                    if ($(document).find("#chkN").is(":checked")) {
                        $("#cantidad").removeAttr("readonly");
                    } else {
                        console.debug("===> cant_pista: %o", $("#cant_pista").val().length);
                        var pistas = ($("#cant_pista").val().length > 0) ? $("#cant_pista").val() : 0;
                        procesa_cantidades_etiqueta(id_formato, largo, pistas);
                    }

                    return false;
                    break;
                }


                //case '22':
                // case '23':
            case '13':
            case '14':
            case '15':
                {
                    console.debug("==> procesa_cantidades_bolsa ")
                    console.debug("===> cant_pista: %o", $("#cant_pista").val().length);
                    procesa_cantidades_bolsa(id_formato, largo);
                    return false;
                    break;
                }

            default:
                {
                    //alert("Formato Incorrecto:  " + id_formato + "");
                    $("#cantidad").removeAttr("readonly");
                    return false;
                    break;
                }

        }
        return false;



    });

    function procesa_cantidades_bolsa(id_formato, largo_corte) {


        $(this).attr("readonly", "readonly");
        $("#input_cant_pop").val(null);
        if (id_formato == 0) { //Si no se selecciono un formato no abre el popup
            alert("Debe Seleccionar un Formato.");
            $("#formato").focus();
            return false;
        }

        console.debug('$("#largo").val().length ', $("#largo").val().length);
        if ($("#largo").val().length < 1) {
            swal({
                title: "Error!",
                text: "<b>Debe Ingresar Largo de Producto.</b>",
                type: "error",
                html: true,
                confirmButtonText: "Cerrar"
            });
            $("#largo").focus();
            return false;
        }
        //console.debug("==> Formato Seleccionado: %o",id_formato);
        var data_ajax = {
            type: 'POST',
            url: "services/formatos.php",
            beforeSend: function(xhr) {
                xhr.overrideMimeType("text/plain; charset=x-user-defined");
            },
            //data: {action:6,id_formato:id_formato,largo:largo},
            data: { action: 6, id_formato: id_formato },
            success: function(data) {
                console.debug("=DATA: %o", data);
                if (data.result.length < 1) {
                    $("#cantidad").removeAttr("readonly");
                    return false;
                } else {
                    $(this).attr("readonly", "readonly");
                }

                var largo = $("#largo").val();
                //console.debug("== FORMATO CANTIDADES: %o",data);
                //return false;
                var tbody_content = "";
                $.each(data.result, function(index, item) {

                    console.debug("====> index: %o", index);
                    console.debug("====> item: %o", item);
                    if (parseFloat(item.largo).toFixed(2) == parseFloat(largo).toFixed(2)) {

                        tbody_content += '<tr data-id="' + item.id + '"  data-multiplo="' + item.multiplo + '" >';
                        tbody_content += '<td><a href="#" data-id="' + item.id + '"  data-multiplo="' + item.multiplo + '" class=""><i class="fa fa-circle-o fa-2x " aria-hidden="true"></i></a></td>';
                        tbody_content += '<td>' + item.descripcion + '</td>';
                        tbody_content += '<td>' + parseFloat(item.largo).toFixed(1) + '</td>';
                        tbody_content += '<td>' + parseFloat(item.ancho).toFixed(1) + '</td>';
                        tbody_content += '<td>' + item.multiplo + '</td>';
                        tbody_content += '</tr>';
                    }


                });

                if (tbody_content == '') {
                    $("#cantidad").removeAttr("readonly");
                    return false;
                }
                $("#table_cant").find("tbody").html(tbody_content);
                $("#table_cant tbody  ").find("tr:first-child").trigger("click");
                $("#cantidad_modal").modal("show");

            },
            error: function() {
                console.debug("===> error Carga Formato");
            },
            complete: function() {
                //$("#cantidad_modal").modal("show");
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
    }


    function procesa_cantidades_etiqueta(id_formato, largo_corte, pistas) {
        console.debug("===> procesa_cantidades_etiqueta function	");
        console.debug("===> id_formato: %o", id_formato);
        console.debug("===> largo_corte: %o", largo_corte);
        console.debug("===> pistas: %o", pistas);

        var data_ajax = {
            type: 'POST',
            url: "services/bobinas.php",
            beforeSend: function(xhr) {
                xhr.overrideMimeType("text/plain; charset=x-user-defined");
            },
            data: { action: 3, formato_id: id_formato },
            success: function(data) {
                console.debug("=>>> BOBINA: %o", data);
                var tbody_content = "";
                $.each(data.bobina, function(index, item) {
                    console.debug("===> index: %o - %o", index, item);

                    total_etiquetas = (parseFloat(item.largo_cm) / parseFloat(largo_corte)) * parseInt(pistas);
                    total_etiquetas = total_etiquetas.toFixed();

                    tbody_content += '<tr data-id="' + item.id + '"  data-multiplo="' + total_etiquetas + '" data-largo="' + parseFloat(item.largo).toFixed() + '">';
                    tbody_content += '<td><a href="#" data-id="' + item.id + '"  data-multiplo="' + total_etiquetas + '" class=""><i class="fa fa-circle-o fa-2x " aria-hidden="true"></i></a></td>';
                    tbody_content += '<td>' + item.nombre + '</td>';
                    tbody_content += '<td>' + parseFloat(item.largo).toFixed(1) + '</td>';
                    tbody_content += '<td>' + pistas + '</td>';
                    tbody_content += '<td>' + total_etiquetas + '</td>';
                    tbody_content += '</tr>';

                });
                console.debug("===> tbody_content: %o", tbody_content);

                if (tbody_content == '') {
                    $("#cantidad").removeAttr("readonly");
                    return false;
                }

                $("#table_bobina_cant").find("tbody").html(tbody_content);
                $("#table_bobina_cant tbody  ").find("tr:first-child").trigger("click");
                $("#etiqueta_cantidad_modal").modal('show');

                return false;
                $("#etiqueta_cantidad_modal").modal('show');
            },
            error: function() {
                console.debug("===> error Carga Formato");
            },
            complete: function() {
                //$("#cantidad_modal").modal("show");
            },
            dataType: 'json'

        }
        $.ajax(data_ajax);


        //#TODO: Falta cargar datos en modal

        return false;
    }




    function Moneda(entrada) {
        var num = entrada.replace(/\./g, "");
        if (!isNaN(num)) {
            num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g, "$1.");
            num = num.split("").reverse().join("").replace(/^[\.]/, "");
            entrada = num;
        } else {
            entrada = input.value.replace(/[^\d\.]*/g, "");
        }
        return entrada;
    }

    function formatearNumero(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    function addCommas(input) {
        // If the regex doesn't match, `replace` returns the string unmodified
        return (input.toString()).replace(
            // Each parentheses group (or 'capture') in this regex becomes an argument
            // to the function; in this case, every argument after 'match'
            /^([-+]?)(0?)(\d+)(.?)(\d+)$/g,
            function(match, sign, zeros, before, decimal, after) {

                // Less obtrusive than adding 'reverse' method on all strings
                var reverseString = function(string) { return string.split('').reverse().join(''); };

                // Insert commas every three characters from the right
                var insertCommas = function(string) {

                    // Reverse, because it's easier to do things from the left
                    var reversed = reverseString(string);

                    // Add commas every three characters
                    var reversedWithCommas = reversed.match(/.{1,3}/g).join(',');

                    // Reverse again (back to normal)
                    return reverseString(reversedWithCommas);
                };

                // If there was no decimal, the last capture grabs the final digit, so
                // we have to put it back together with the 'before' substring
                return sign + (decimal ? insertCommas(before) + decimal + after : insertCommas(before + after));
            }
        );
    };



    $("#table_cant tbody tr ").live('click', function() {
        console.debug("===> OPTION CLICKED: %o", $(this).find('i').length);
        $("#table_cant tbody tr").removeClass('label label-success');
        $("#table_cant tbody tr i").attr('class', 'fa fa-circle-o fa-2x '); //  removeClass('label label-success');
        $(this).addClass('label label-success');
        $(this).find('i').attr('class', 'fa fa-check-circle fa-2x  label label-success');
        var multiplo = $(this).data('multiplo');
        $("#multiplo_cant").val(multiplo);
        $("#input_cant_pop").val(null);
    });

    $("#table_bobina_cant tbody tr ").live('click', function() {
        console.debug("===> OPTION CLICKED: %o", $(this).find('i').length);
        $("#table_bobina_cant tbody tr").removeClass('label label-success');
        $("#table_bobina_cant tbody tr i").attr('class', 'fa fa-circle-o fa-2x '); //  removeClass('label label-success');
        $(this).addClass('label label-success');
        $(this).find('i').attr('class', 'fa fa-check-circle fa-2x  label label-success');
        var multiplo = $(this).data('multiplo');
        var largo = $(this).data('largo');
        $("#multiplo_etiqueta_cant").val(multiplo);
        $("#largo_etiqueta_cant").val(largo);
        $("#input_cant_etiqueta_pop").val(null);
    });

    function format2(input) {
        var num = input.value.replace(/\./g, '');
        if (!isNaN(num)) {
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');
            input.value = num;
        } else {
            alert('Solo se permiten numeros');
            input.value = input.value.replace(/[^\d\.]*/g, '');
        }
    }


    function format(num) {
        var n = num.toString(),
            p = n.indexOf('.');
        return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i) {
            return p < 0 || i < p ? ($0 + ',') : $0;
        });
    }

    $("#input_cant_pop").live('keyup', function(event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        var cant = $(this).val();
        cant = cant.split('.').join("");
        cant = parseFloat(cant);
        var multiplo = parseInt($("#multiplo_cant").val());
        min = 0;
        max = multiplo;

        flag = false;
        rest = cant / multiplo;
        i = parseInt(rest);

        if (i == 0) {
            $i = 1;
            min = 0;
            max = multiplo;
        } else {
            min = multiplo * i;
            max = multiplo * i + multiplo;
        }


        var list_li = "";
        //return false;
        if (cant == min || cant == max) {
            list_li += '<li><input type="radio" value="' + cant + '" name="cantidad_opciones[]"> Cantidad Permitida: ' + cant + '</li>';
        } else if (cant < min) {
            list_li += '<li><input type="radio" value="' + min + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + min + '</li>';
        } else if (cant < max) {
            list_li += '<li><input type="radio" value="' + min + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + min + '</li>';
            list_li += '<li><input type="radio" value="' + max + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + max + '</li>';
        }
        $(".cant_allowed").empty().append(list_li);

        return false;
    });


    $("#input_cant_etiqueta_pop").live('keyup', function(event) {
        console.debug("==> input_cant_etiqueta_pop: %o", $(this).val());

        var cant = $(this).val().split('.').join("");
        var cant = parseInt(cant);
        var multiplo = $("#multiplo_etiqueta_cant").val();

        min = 0;
        max = multiplo;
        i = 1;
        flag = false;
        while (!flag) {
            min = max;
            max = multiplo * i;
            if (cant >= max) {
                i++;
            } else {
                flag = true;
            }
        }
        console.debug("===> i %o", i);

        //medio= multiplo*0.5;
        //medio=medio.toFixed();
        min_y_medio = parseInt(min) + parseInt(multiplo * 0.5);

        var list_li = "";

        if (cant == min || cant == max) {
            list_li += '<li><input type="radio" value="' + cant + '" name="cantidad_opciones[]"> Cantidad Permitida: ' + cant + '</li>';
        } else if (cant == min_y_medio) {
            list_li += '<li><input type="radio" value="' + cant + '" name="cantidad_opciones[]"> Cantidad Permitida: ' + cant + '</li>';
        } else if (cant < min) {
            list_li += '<li><input type="radio" value="' + min + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + min + '</li>';
        } else if (cant < min_y_medio) {
            list_li += '<li><input type="radio" value="' + min + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + min + '</li>';
            list_li += '<li><input type="radio" value="' + min_y_medio + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + min_y_medio + '</li>';
        } else if (cant < max) {

            list_li += '<li><input type="radio" value="' + min_y_medio + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + min_y_medio + '</li>';
            list_li += '<li><input type="radio" value="' + max + '" name="cantidad_opciones[]"> Cantidad Permitida : ' + max + '</li>';
        }



        $(".cant_etiquetas_allowed").empty().append(list_li);
        return false;
    });

    $("#cantidad_modal .btn-primary").click(function() {
        //console.debug("Save bt");
        var radios_cants = $("#cantidad_modal .modal-body").find("input[type='radio']:checked");
        console.debug("==> radios_cants: %o", radios_cants.length);
        $(".cant_allowed").find("li.alert-danger").remove();
        if (radios_cants.length == 0) {
            $(".cant_allowed").append("<li class='alert alert-danger'>Debe seleccionar una cantidad disponible</li>");
            return false;
        } else {
            $(".cant_allowed").find("li.alert-danger").remove();
        }
        $("#cantidad").val(radios_cants.val()).focus();
        $("#cantidad_modal").modal("hide");
    });

    $("#etiqueta_cantidad_modal .btn-primary").click(function() {
        //console.debug("Save bt");
        var multiplo = $("#multiplo_etiqueta_cant").val();
        var largo_bobina = parseFloat($("#largo_etiqueta_cant").val());
        var radios_cants = $("#etiqueta_cantidad_modal .modal-body").find("input[type='radio']:checked");
        console.debug("====> multiplo: %o", multiplo);
        console.debug("====> multiplo: %o", (parseInt(radios_cants.val()) / parseInt(multiplo)));
        var total_bobinas = (parseInt(radios_cants.val()) / parseInt(multiplo)).toFixed(2);
        console.debug("Equivale a " + total_bobinas + " Bobinas de " + largo_bobina + " Metros.");
        $("#span_etiqueta").html("Equivale a " + total_bobinas + " Bobinas de " + largo_bobina + " Metros.").css("display", "block");


        console.debug("==> radios_cants: %o", radios_cants.length);
        $(".cant_allowed").find("li.alert-danger").remove();
        if (radios_cants.length == 0) {
            $(".cant_etiquetas_allowed").append("<li class='alert alert-danger'>Debe seleccionar una cantidad disponible</li>");
            return false;
        } else {
            $(".cant_etiquetas_allowed").find("li.alert-danger").remove();
        }
        $("#cantidad").val(radios_cants.val()).focus();
        $("#etiqueta_cantidad_modal").modal("hide");
    });



});

function clear_all() {
    var codigoProductop = $("#codigoProductop");
    console.debug(codigoProductop.val().length);

    if (codigoProductop.val().length < 1) {
        console.debug("LImpiar code");
        $("#ancho").attr('readonly', true);
        $("#ancho").val("");
        $("#largo").attr('readonly', true);
        $("#largo").val("");
        $("#micronaje").attr('readonly', true);
        $("#micronaje").val("");
    }
    /*else{
    			$("#ancho").attr('readonly', true);
    			$("#largo").attr('readonly', true);
    			$("#micronaje").attr('readonly', true);
    		}*/


    $("#fuelle").attr('readonly', true);
    $("#fuelle").val("");
    $("#precioPoli").attr('readonly', true);
    $("#precioPoli").val("");
    $("#termo").attr("disabled", "disabled");
    $("#termo").attr('checked', false);
    $("#micro").attr("disabled", "disabled");
    $("#micro").attr('checked', false);
    $("#origen").val("");
    $("#origen").attr('readonly', false);
    $("#solapa").val("");
    $("#solapa").attr('readonly', true);
    $("#troquelado").attr("disabled", "disabled");
    $("#troquelado").val("-1");
}

function setear(valor) {
    $('#busc').val(valor);
    $("#resultado_Productos").html("");
}

function closeMensaje() {
    $('#MensajesPop').modal('hide');
}

function abrir_venc() {
    $("#VencPop").modal('show');
}


//$('#btnCloseMensajePop').click(function(){
//
//	$(idDiv).modal('hide');
//});



function EnabledButtonCI() {
    if ($("#esCI").is(':checked')) {
        $("#btn_save").css("display", "none");
        $("#btn_CI").css("display", "block");
    } else {
        $("#btn_CI").css("display", "none");
        $("#btn_save").css("display", "block");
    }
}

function guardar_CI() {
    $("#error_div_CI").css("display", "none");
    $("#error_msj_CI").html('');
    $("#CIpop").modal('show');
    $("#CI_values").val("");
}

function AddCI() {
    if ($("#numberCI").val() != "" && $("#numberCI").val() != null) {
        $('#table_hoja_CI > tbody:last').append('<tr><td>' + $("#numberCI").val() + '<br></td></tr></tr>');
        var str = $("#CI_values").val() == "" ? $("#numberCI").val() : $("#CI_values").val() + "-" + $("#numberCI").val();
        $("#CI_values").val(str);
        $("#numberCI").val('');
    }
}

function ValidarConCI() {
    //debugger;
    if ($("#CI_values").val() == "") {
        $("#error_div_CI").css("display", "block");
        $("#error_msj_CI").html('<b>Ingrese al menos un número de comprobante de CI.</b>');
    } else {
        $("#error_div_CI").css("display", "none");
        $("#error_msj_CI").html('');
        $("#CIpop").modal('hide');

        //Validar demas datos
        guardar_1();
    }
}

function BuscarCliente() {
    window.open("buscarCliente.php", "PopUp", 'width=900px,height=auto,scrollbars=YES');
    return false;
}

function BuscarFacturar() {
    window.open("buscarFacturar.php", "PopUp", 'width=700px,height=350px,scrollbars=YES');
    return false;
}

function BuscarProducto() {
    window.open("buscarProducto.php", "PopUp", 'width=900px,height=350px,scrollbars=YES');
    return false;
}

function guardar_1() {


    update_formato_material();




    $('#btn_save').attr("disabled", "disabled");
    $('#btn_CI').attr("disabled", "disabled");

    var input = [];
    var title = [];

    if ($("#codigoTango").val() == "") {
        $('#msj_error_pop').html("<strong>Seleccione un cliente válido.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#codigoTango").val());
        title.push("codTango");

        input.push($("#tbCliente").val());
        title.push("nomCliente");

        input.push($("#direccionCliente").val());
        title.push("dirCliente");

        input.push($("#telefonoCliente").val());
        title.push("telCliente");

        input.push($("#cuit").val());
        title.push("cuit");

        input.push($("#facturarA").val());
        title.push("codTangoFact");

        input.push($("#codigoTangoFacturar").val());
        title.push("codTangoCod");

        input.push($("#mail_protocolo").val());
        title.push("mail_p");

        input.push($("#envia_protocolo").val());
        title.push("envia_p");
    }
    if ($("#lugId").val() == "") {
        $('#msj_error_pop').html("<strong>Seleccione el lugar de entrega.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#lugId").val());
        title.push("lugarEnt");
    }

    //debugger;
    //if($("#arti").val() == "no")
    if ($("#chkH").is(':checked') == true) {
        //el producto no es nuevo
        if ($("#nombreProducto").val() == "") {
            $('#msj_error_pop').html("<strong>Seleccione un artículo.</strong>");
            $('#MensajesPop').modal('show');
            $('#btn_save').removeAttr('disabled');
            $('#btn_CI').removeAttr('disabled');
            return false;
        } else {
            //Datos de Productos
            input.push($("#codigoProductop").val());
            title.push("codProd");

            input.push($("#nombreProducto").val());
            title.push("nomProd");

            input.push($("#descripcionProducto").val());
            title.push("codTangoProd");

            input.push("no");
            title.push("habitual");
        }
    } else {
        //el producto es nuevo
        if ($("#nombreProducto").val() == "") {
            $('#msj_error_pop').html("<strong>Eligio cargar un producto nuevo, entonces debe cargar la descripción de este.</strong>");
            $('#MensajesPop').modal('show');
            $('#btn_save').removeAttr('disabled');
            $('#btn_CI').removeAttr('disabled');
            return false;
        } else {
            if ($("#codigoProductop").val() != "" && $("#codigoProductop").val() != null) {
                input.push($("#codigoProductop").val());
                title.push("codProd");
            } else {
                input.push("");
                title.push("codProd");
            }

            input.push($("#nombreProducto").val());
            title.push("nomProd");

            input.push("");
            title.push("codTangoProd");

            input.push("si");
            title.push("habitual");
        }
    }

    if ($("#fecha1").val() == "") {
        $('#msj_error_pop').html("<strong>Seleccione la fecha de entrega.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#fecha1").val());
        title.push("fechaEnt");
    }
    //Volumen de pedido
    if ($("#cantidad").val() == "") {
        $('#msj_error_pop').html("<strong>Seleccione la cantidad.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {

        input.push($("#cantidad").val().replace('.', ''));
        title.push("cantProd");
    }

    if ($("#unidades").val() == "0") {
        $('#msj_error_pop').html("<strong>Seleccione la unidad de medida.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#unidades").val());
        title.push("unidades");
    }

    if ($("#moneda").val() == "0") {
        $('#msj_error_pop').html("<strong>Seleccione el tipo de moneda.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#moneda").val());
        title.push("moneda");
    }

    if ($("#precio").val() == "") {
        $('#msj_error_pop').html("<strong>Indique el precio de la nota de pedido.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#precio").val());
        title.push("precio");
    }

    if ($("#condicionPago").val() == "0") {
        $('#msj_error_pop').html("<strong>Seleccione la condición de IVA.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#condicionPago").val());
        title.push("condIVA");
    }

    if ($('#caras').val() == "3") {
        $('#msj_error_pop').html("<strong>Seleccione la cantidad de caras a imprimir.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($('#caras').val());
        title.push("caras");
    }

    if ($('#centrada').val() == "3") {
        $('#msj_error_pop').html("<strong>Seleccione la opción de tipo de impresión.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($('#centrada').val());
        title.push("tipoImp");
    }

    if ($('#tipo').val() == "3") {
        $('#msj_error_pop').html("<strong>Seleccione la opción de horientación.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($('#tipo').val());
        title.push("horientacion");
    }

    if ($('#formato').val() == "0") {
        $('#msj_error_pop').html("<strong>Seleccione el formato del producto.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#formato").val());
        title.push("formato");
    }

    if ($('#material').val() == "0") {
        $('#msj_error_pop').html("<strong>Seleccione material del producto.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#material").val());
        title.push("material");
    }

    if ($("#color").val() == "") {
        $('#msj_error_pop').html("<strong>Seleccione el color del producto.</strong>");
        $('#MensajesPop').modal('show');
        $('#btn_save').removeAttr('disabled');
        $('#btn_CI').removeAttr('disabled');
        return false;
    } else {
        input.push($("#color").val());
        title.push("color");
    }

    //debugger;
    if (campos_para_validar.length > 0) {
        for (var i in campos_para_validar) {
            switch (campos_para_validar[i]) {
                case "#largo":
                    if ($("#largo").val() == "") {
                        $('#msj_error_pop').html("<strong>Seleccione el largo del producto.</strong>");
                        $('#MensajesPop').modal('show');
                        $('#btn_save').removeAttr('disabled');
                        $('#btn_CI').removeAttr('disabled');
                        return false;
                    } else {
                        input.push($("#largo").val());
                        title.push("largo");
                    }
                    break;

                case "#ancho":
                    if ($("#ancho").val() == "") {
                        $('#msj_error_pop').html("<strong>Seleccione el ancho del producto.</strong>");
                        $('#MensajesPop').modal('show');
                        $('#btn_save').removeAttr('disabled');
                        $('#btn_CI').removeAttr('disabled');
                        return false;
                    } else {
                        input.push($("#ancho").val());
                        title.push("ancho");
                    }
                    break;

                case "#micronaje":
                    if ($("#micronaje").val() == "") {
                        $('#msj_error_pop').html("<strong>Seleccione el micronaje del producto.</strong>");
                        $('#MensajesPop').modal('show');
                        $('#btn_save').removeAttr('disabled');
                        $('#btn_CI').removeAttr('disabled');
                        return false;
                    } else {
                        input.push($("#micronaje").val());
                        title.push("micronaje");
                    }
                    break;

                case "#fuelle":
                    if ($("#fuelle").val() == "") {
                        $('#msj_error_pop').html("<strong>Seleccione el fuelle del producto.</strong>");
                        $('#MensajesPop').modal('show');
                        $('#btn_save').removeAttr('disabled');
                        $('#btn_CI').removeAttr('disabled');
                        return false;
                    } else {
                        input.push($("#fuelle").val());
                        title.push("fuelle");
                    }
                    break;

                case "#termo":
                    if ($("#termo").is(':checked')) {
                        input.push("1");
                    } else {
                        input.push("0");
                    }
                    title.push("termo");
                    break;

                case "#micro":
                    if ($("#micro").is(':checked')) {
                        input.push("1");
                    } else {
                        input.push("0");
                    }
                    title.push("micro");
                    break;

                case "#origen":
                    if ($("#origen").val() == "") {
                        $('#msj_error_pop').html("<strong>Seleccione el origen del producto.</strong>");
                        $('#MensajesPop').modal('show');
                        $('#btn_save').removeAttr('disabled');
                        $('#btn_CI').removeAttr('disabled');
                        return false;
                    } else {
                        input.push($("#origen").val());
                        title.push("origen");
                    }
                    break;

                case "#solapa":
                    if ($("#solapa").val() == "") {
                        $('#msj_error_pop').html("<strong>Seleccione la solapa del producto.</strong>");
                        $('#MensajesPop').modal('show');
                        $('#btn_save').removeAttr('disabled');
                        $('#btn_CI').removeAttr('disabled');
                        return false;
                    } else {
                        input.push($("#solapa").val());
                        title.push("solapa");
                    }
                    break;

                case "#troquelado":
                    //debugger;
                    if ($("#troquelado").val() == "-1") {
                        $('#msj_error_pop').html("<strong>Seleccione si el producto tiene troquelado.</strong>");
                        $('#MensajesPop').modal('show');
                        $('#btn_save').removeAttr('disabled');
                        $('#btn_CI').removeAttr('disabled');
                        return false;
                    } else {
                        input.push($("#troquelado").val());
                        title.push("troquelado");
                    }
                    break;
            }
        }
    } else {

        input.push($("#ancho").val());
        title.push("ancho");
        input.push($("#largo").val());
        title.push("largo");
        input.push($("#micronaje").val());
        title.push("micronaje");
        //Validar por disponibilidad
        /*
        if($("#ancho").attr("readonly") != "readonly")
        {
        	if($("#ancho").val() == "")
        		{
        			$('#msj_error_pop').html("<strong>Seleccione el ancho del producto.</strong>");
        			$('#MensajesPop').modal('show');
        			$('#btn_save').removeAttr('disabled');
        			$('#btn_CI').removeAttr('disabled');
        			return false;
        		}
        		else
        		{
        			input.push($("#ancho").val());
        			title.push("ancho");
        		}
        }

        if($("#largo").attr("readonly") != "readonly")
        {
        	if($("#largo").val() == "")
        		{
        			$('#msj_error_pop').html("<strong>Seleccione el largo del producto.</strong>");
        			$('#MensajesPop').modal('show');
        			$('#btn_save').removeAttr('disabled');
        			$('#btn_CI').removeAttr('disabled');
        			return false;
        		}
        		else
        		{
        			input.push($("#largo").val());
        			title.push("largo");
        		}
        }

        if($("#micronaje").attr("readonly") != "readonly")
        {
        	if($("#micronaje").val() == "")
        			{
        				$('#msj_error_pop').html("<strong>Seleccione el micronaje del producto.</strong>");
        				$('#MensajesPop').modal('show');
        				$('#btn_save').removeAttr('disabled');
        				$('#btn_CI').removeAttr('disabled');
        				return false;
        			}
        			else
        			{
        				input.push($("#micronaje").val());
        				title.push("micronaje");
        			}
        }*/

        if ($("#fuelle").attr("readonly") != "readonly") {
            if ($("#fuelle").val() == "") {
                $('#msj_error_pop').html("<strong>Seleccione el fuelle del producto.</strong>");
                $('#MensajesPop').modal('show');
                $('#btn_save').removeAttr('disabled');
                $('#btn_CI').removeAttr('disabled');
                return false;
            } else {
                input.push($("#fuelle").val());
                title.push("fuelle");
            }
        }

        if ($("#origen").attr("readonly") != "readonly") {
            if ($("#origen").val() == "") {
                $('#msj_error_pop').html("<strong>Seleccione el origen del producto.</strong>");
                $('#MensajesPop').modal('show');
                $('#btn_save').removeAttr('disabled');
                $('#btn_CI').removeAttr('disabled');
                return false;
            } else {
                input.push($("#origen").val());
                title.push("origen");
            }
        }

        if ($("#solapa").attr("readonly") != "readonly") {
            if ($("#solapa").val() == "") {
                $('#msj_error_pop').html("<strong>Seleccione la solapa del producto.</strong>");
                $('#MensajesPop').modal('show');
                $('#btn_save').removeAttr('disabled');
                $('#btn_CI').removeAttr('disabled');
                return false;
            } else {
                input.push($("#solapa").val());
                title.push("solapa");
            }
        }

        if ($("#termo").attr("disabled") != "disabled") {
            if ($("#termo").is(':checked')) {
                input.push("1");
            } else {
                input.push("0");
            }
            title.push("termo");
        }

        if ($("#micro").attr("disabled") != "disabled") {
            if ($("#micro").is(':checked')) {
                input.push("1");
            } else {
                input.push("0");
            }
            title.push("micro");
        }

        if ($("#troquelado").attr("disabled") != "disabled") {
            if ($("#troquelado").val() == "-1") {
                $('#msj_error_pop').html("<strong>Seleccione si el producto tiene troquelado.</strong>");
                $('#MensajesPop').modal('show');
                $('#btn_save').removeAttr('disabled');
                $('#btn_CI').removeAttr('disabled');
                return false;
            }
            input.push($("#troquelado").val());
            title.push("troquelado");
        } else {
            input.push('-1');
            title.push("troquelado");
        }
    }

    //--------------------------------------

    //Campos no requeridos
    input.push($('#bobinado').val());
    title.push("sentido");

    input.push($('#fuera').val());
    title.push("tratado");

    input.push($('#distancia').val());
    title.push("distTaco");

    input.push($('#bobina').val());
    title.push("diamBobina");

    input.push($('#canuto').val());
    title.push("diamCanuto");

    input.push($('#kgBobina').val());
    title.push("kgBobina");

    input.push($('#mtsBobina').val());
    title.push("mtsBobina");

    input.push($('#observaciones').val());
    title.push("observaciones");


    input.push($("#CI_values").val());
    title.push("CI_values");
    //--------------------------------------

    //Descripción del Laminado
    if ($('#material').val() == "1") {
        //Bilaminado
        if (
            $('#Bilaminado1').val() == "1" || $('#Bilaminado2').val() == "1" ||
            $('#Material1').val() == "1" || $('#Material2').val() == "1" ||
            $('#Micronaje1').val() == "" || $('#Micronaje2').val() == ""
        ) {
            $('#msj_error_pop').html("<strong>Descripción de laminado incompleta.</strong>");
            $('#MensajesPop').modal('show');
            $('#btn_save').removeAttr('disabled');
            $('#btn_CI').removeAttr('disabled');
            return false;
        } else {
            input.push($('#Bilaminado1').val());
            title.push("Bilaminado1");
            input.push($('#Material1').val());
            title.push("Material1");
            input.push($('#Micronaje1').val());
            title.push("Micronaje1");
            //---
            input.push($('#Bilaminado2').val());
            title.push("Bilaminado2");
            input.push($('#Material2').val());
            title.push("Material2");
            input.push($('#Micronaje2').val());
            title.push("Micronaje2");
            //--
            input.push(1);
            title.push("Bilaminado3");
            input.push(1);
            title.push("Material3");
            input.push("");
            title.push("Micronaje3");
        }
    } else {
        if ($('#material').val() == "0" || $('#material').val() == "2") {
            if ($('#material').val() == "2") {
                if (
                    $('#Bilaminado1').val() == "1" || $('#Bilaminado2').val() == "1" || $('#Trilaminado').val() == "1" ||
                    $('#Material1').val() == "1" || $('#Material2').val() == "1" || $('#Material3').val() == "1" ||
                    $('#Micronaje1').val() == "" || $('#Micronaje2').val() == "" || $('#Micronaje3').val() == ""
                ) {
                    $('#msj_error_pop').html("<strong>Descripción de laminado incompleta.</strong>");
                    $('#MensajesPop').modal('show');
                    $('#btn_save').removeAttr('disabled');
                    $('#btn_CI').removeAttr('disabled');
                    return false;
                }
            }
            input.push($('#Bilaminado1').val());
            title.push("Bilaminado1");
            input.push($('#Material1').val());
            title.push("Material1");
            input.push($('#Micronaje1').val());
            title.push("Micronaje1");
            //---
            input.push($('#Bilaminado2').val());
            title.push("Bilaminado2");
            input.push($('#Material2').val());
            title.push("Material2");
            input.push($('#Micronaje2').val());
            title.push("Micronaje2");
            //--
            input.push($('#Trilaminado').val());
            title.push("Bilaminado3");
            input.push($('#Material3').val());
            title.push("Material3");
            input.push($('#Micronaje3').val());
            title.push("Micronaje3");
        } else {
            input.push(1);
            title.push("Bilaminado1");
            input.push(1);
            title.push("Material1");
            input.push("");
            title.push("Micronaje1");
            //---
            input.push(1);
            title.push("Bilaminado2");
            input.push(1);
            title.push("Material2");
            input.push("");
            title.push("Micronaje2");
            //--
            input.push(1);
            title.push("Bilaminado3");
            input.push(1);
            title.push("Material3");
            input.push("");
            title.push("Micronaje3");
        }
    }
    //--------------------------------------

    //Datos de elaboración -----------------
    input.push($('#envasado').val());
    title.push("envasado");

    input.push($('#vencimiento').val());
    title.push("vencimiento");

    input.push($('#lote').val());
    title.push("lote");
    //--------------------------------------

    if ($(".bs-docs-date").find("#fecha_entrega_original").length != 0) {
        var fecha_entrega_original = $(".bs-docs-date").find("#fecha_entrega_original");
        if (fecha_entrega_original.val() == null || fecha_entrega_original.val() == '') {
            input.push($("#fecha1").val());
        } else {
            input.push(fecha_entrega_original.val());
        }
        title.push("entrega_original");
    } else {
        input.push($("#fecha1").val());
        title.push("entrega_original");
    }

    var IdPed = $('#idPedido').val();
    var Accion = $('#accionPedido').val();

    title.push("estadistica");
    if ($('#accionPedido').val() == "A") {
        input.push($('#estadistica').val());
    } else {
        input.push(0);
    }

    if (Accion != "I" && Accion != "E" && Accion != "A" && Accion != "P" && Accion != "CL" && Accion != "N") {
        return;
    }

    var data_ajax = {
        type: 'POST',
        url: "insertPedido.php",
        data: { valores: input, titulos: title, action: Accion, id: IdPed },
        success: function(data) {

            window.location.href = 'principal.php';
            return false;
        },
        error: function() {
            swal({
                title: "Error!",
                text: "Error de conexión.",
                type: "error",
                confirmButtonText: "Cerrar"
            });
            $('#btn_save').removeAttr('disabled');
            $('#btn_CI').removeAttr('disabled');
        },
        dataType: 'json'
    };

    $.ajax(data_ajax);

}


$("#moneda").on('change', function() {


    if ($(this).val() == '1') {
        console.debug("==> moneda: %o", $(this).val());
        $("#precio").addClass('currency_peso');
        $("#precio").removeClass('currency_dolar');

    } else if ($(this).val() == '2') {
        console.debug("==> moneda: %o", $(this).val());
        $("#precio").addClass('currency_dolar');
        $("#precio").removeClass('currency_peso');

    }


    return false;
});


$("#precio").change(function() {
    if ($(this).val().length == 0) {
        return false;
    }
    console.log(" PRECIO CHANGE: %o", $(this).val());
    var temp = $(this).val();
    console.log(" PRECIO CHANGE: %o", parseFloat(temp).toFixed(5));
    $(this).val(parseFloat(temp).toFixed(5));

});


function update_formato_material() {

    var id = $("#codigoProductop").val();
    var formato = $("#formato").val();
    var material = $("#material").val();

    if (id.length == 0) {
        return false;
    }

    var data_ajax = {
        type: 'POST',
        url: "services/pedidos.php",
        data: { action: 1, id: id, formato: formato, material: material },
        success: function(data) {

            return true;
        },
        error: function() {
            swal({
                title: "Error!",
                text: "Error de conexión.",
                type: "error",
                confirmButtonText: "Cerrar"
            });
            $('#btn_save').removeAttr('disabled');
            $('#btn_CI').removeAttr('disabled');
        },
        dataType: 'json'
    };

    $.ajax(data_ajax);
}

function habilitarComponentes(id) {
    console.debug("==> habilitarComponentes");
    if (id == 1) //es bilamina , habilitar los dos primeros select
    {
        $('#Bilaminado1').attr('disabled', false);
        $('#Bilaminado2').attr('disabled', false);
        $('#Trilaminado').attr('disabled', true);

        $('#Material1').attr('disabled', false);
        $('#Material2').attr('disabled', false);
        $('#Material3').attr('disabled', true);

        $('#Micronaje1').attr('disabled', false);
        $('#Micronaje2').attr('disabled', false);
        $('#Micronaje3').attr('disabled', true);

    } else {
        if (id == 2) // es trilamina , habilitar los 3 select
        {

            $('#Bilaminado1').attr('disabled', false);
            $('#Bilaminado2').attr('disabled', false);
            $('#Trilaminado').attr('disabled', false);

            $('#Material1').attr('disabled', false);
            $('#Material2').attr('disabled', false);
            $('#Material3').attr('disabled', false);

            $('#Micronaje1').attr('disabled', false);
            $('#Micronaje2').attr('disabled', false);
            $('#Micronaje3').attr('disabled', false);
        } else {
            $('#Bilaminado1').attr('disabled', true);
            $('#Bilaminado2').attr('disabled', true);
            $('#Trilaminado').attr('disabled', true);

            $('#Material1').attr('disabled', true);
            $('#Material2').attr('disabled', true);
            $('#Material3').attr('disabled', true);

            $('#Micronaje1').attr('disabled', true);
            $('#Micronaje2').attr('disabled', true);
            $('#Micronaje3').attr('disabled', true);
        }
    }
}

function HabilitarDatosImpresion() {
    if ($("#caras").val() == 0) {
        $("#centrada option[value=2]").attr("selected", true);
        $("#tipo option[value=2]").attr("selected", true);
        $('#centrada').attr('disabled', 'disabled');
        $('#tipo').attr('disabled', 'disabled');
    } else {
        $("#centrada option[value=3]").attr("selected", true);
        $("#tipo option[value=3]").attr("selected", true);
        $('#centrada').removeAttr('disabled');
        $('#tipo').removeAttr('disabled');
    }
}
//_________________________________________________________//
function Imprimir(valor) {
    window.open("impresionComprobantes.php?documento=4&id=" + valor, "PopUp", "menubar=1,width=920,height=700");
}
//_________________________________________________________//
//solo letras en el campo
function letras(campo) {
    var charpos = campo.value.search("[^A-Za-z ]");
    if (campo.value.length > 0 && charpos >= 0) {
        campo.value = campo.value.slice(0, -1);
        campo.focus();
        return false;
    } else {
        return true;
    }
}
//_________________________________________________________//

//Solo numeros en el campo
function numerico(campo) {
    var charpos = campo.value.search("[^0-9]");
    if (campo.value.length > 0 && charpos >= 0) {
        campo.value = campo.value.slice(0, -1);
        campo.focus();
        return false;
    } else {
        return true;
    }
}
//_________________________________________________________//

//Solo se permiten numero y letras (no simbolos)
function alfanumerico(campo) {
    var charpos = campo.value.search("[^A-Za-z0-9. ]");
    if (campo.value.length > 0 && charpos >= 0) {
        campo.value = campo.value.slice(0, -1)
        campo.focus();
        return false;
    } else {
        return true;
    }
}
//_________________________________________________________//

//Solo se permiten numero y punto
function decimal(campo) {
    var charpos = campo.value.search("[^0-9. ]");
    if (campo.value.length > 0 && charpos >= 0) {
        campo.value = campo.value.slice(0, -1)
        campo.focus();
        return false;
    } else {
        return true;
    }
}
//_________________________________________________________//




$(document).on('click', '.btn-info', function() {
    console.debug("====> btn-info clicked: code= %o ", $(this).data());
    var code = $(this).data('code');
    loadFichaTecnica(code);




    return false;
})

var hostname = $(location).attr('hostname');
var host_url_ajax = '';
if (hostname == 'empaque.des') {
    //host_url_ajax = 'http://190.3.7.29:301/empaque_demo/';
    host_url_ajax = 'http://58d70548161e.sn.mynetname.net:301/empaque_demo/';
}

function loadFichaTecnica(code) {
    console.debug("====> loadFichaTecnica: code= %o ", code);
    var data_ajax = {
        method: "POST",
        url: host_url_ajax + "buscarProductoFicha.php",
        data: { id: code },
        dataType: "json",
        success: function(data) {

            console.debug("===> FICHA TECNICA: %o", data);


            var _art_detalle_list = '';
            _art_detalle_list += '<li class="text-left"><strong>Código: </strong>' + data.articulo.Id + '</li>';
            _art_detalle_list += '<li class="text-left"><strong>Descripcíon: </strong>' + data.articulo.Articulo + '</li>';
            _art_detalle_list += '<li class="text-left" ><strong>Ancho: </strong>' + data.articulo.Ancho + '</li>';
            _art_detalle_list += '<li class="text-left"><strong>Largo: </strong>' + data.articulo.Largo + '</li>';
            _art_detalle_list += '<li class="text-left"><strong>Espesor: </strong>' + data.articulo.Espesor + '</li>';
            _art_detalle_list += '<li class="text-left"><strong>Color: </strong>' + data.Color.Color + '</li>';
            $("#modal_Ficha").find("ul#articulo_detalle").empty().html(_art_detalle_list);


            var _ficha_tabla_row = '';
            $.each(data.Fichas_Tecnica_Detalle, function(index, item) {
                _ficha_tabla_row += '<tr>';
                _ficha_tabla_row += '<td>' + ((item.Nombre != null) ? item.Nombre : '') + '</td>';
                _ficha_tabla_row += '<td>' + ((item.Detalle != null) ? item.Detalle : '') + '</td>';
                _ficha_tabla_row += '<td>' + ((item.Valor != null) ? item.Valor : '') + '</td>';
                _ficha_tabla_row += '<td>' + ((item.Unidad != null) ? item.Unidad : '') + '</td>';
                _ficha_tabla_row += '</tr>';
            })
            console.debug(_ficha_tabla_row);
            $("#modal_Ficha").find("table#ficha_tabla tbody").empty().html(_ficha_tabla_row);


            $("#modal_Ficha").find(".btn_select").attr('data-code', code);
            $("#modal_Ficha").find(".btn_select").show();
            $('#modal_Ficha').modal('show');

        },
        error: function(error_msg) {
            alert("error_msg: " + error_msg);
        }
    };
    $.ajax(data_ajax);
}

$(document).on('click', "#modal_Ficha .btn_select", function() {
    var code = $(this).data('code');
    console.debug("#modal_Ficha .btn_select %o", $(this).data('code'));
    $('#modal_Ficha').modal('hide');
    console.debug("====> #resultado_Productos table tr#" + code + " td", $(document).find("#resultado_Productos table tr#" + code + " td").first().length);
    $(document).find("#resultado_Productos table tr#" + code + " td").first().trigger('click');
    return false;
});