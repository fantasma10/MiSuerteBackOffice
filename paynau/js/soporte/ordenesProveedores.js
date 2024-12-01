var ordenes={};
 ordenes = {
	initOrdenes : function(){
        		$('#misOrdenes').on('click',function(){
                    _llenarTablaOrdenes();
        		});
                
                $('#misMovimientos').on('click', function(){
                    _llenarTablaMovimientos();
                });
                
                $('#miEstadoCuenta').on('click', function(){
                   _llenarTablaEstadoCuenta(); 
                });
                
                $('#misClientes').on('click', function(){
                   _llenarTablaClientes(); 
                });
                
                jQuery('#modalEditarCliente').on('hidden.bs.modal', function (e) {
//                    jQuery(this).removeData('bs.modal');
                    jQuery(this).find('.panel-body').empty();
                });
                
                $('#btnOpcionCliente').on('click', function(){
                    var tipo = $('#nTipo').val();
                    if (tipo == 2) {
                        EditarClientes(proveedor);
                    }else{
                        AgregarClientes(proveedor);
                    }
                });
                $('#btnAgregarCliente').on('click', function(){
                    cargarModalEditCliente(1);
                });
                
                $(document).on('click', '#verDetalleClientes', function(){
                    idProveedor = this.attributes['data-idProveedor'].value;
                    sReferencia = this.attributes['data-referencia'].value;
                    
                    cargaDetalleMovimientos(idProveedor,sReferencia);
                })
	},
    initBotonesOrdenes : function(){

        $(document).on('click','#verDetalleOrden',function(e){
            
            nIdOrden = this.attributes['data-orden'].value;
            sReferencia = this.attributes['data-referencia'].value;
            cargarModalOrden(nIdOrden);
            $('#modalDetalleOrden').modal();
        });
                    
        $('#btnBuscarO').click(function(){
            _llenarTablaOrdenes();
        });
        
        $('#p_dFechaInicioO, #p_dFechaFinO').datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function(){
            $(this).datepicker('hide'); 
            $(this).blur();
        });
    },
    initBotonesMovimientos: function(){
        $('#btnBuscarM').click(function(){
           _llenarTablaMovimientos();
        });
        $('#p_dFechaInicioM, #p_dFechaFinM').datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function(){
            $(this).datepicker('hide'); 
            $(this).blur();
        });
    },
    initBotonesEstadoCuenta: function(){
        $('#btnBuscar').click(function(){
            _llenarTablaEstadoCuenta();
        });
        $('#p_dFechaInicio, #p_dFechaFin').datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function(){
            $(this).datepicker('hide'); 
            $(this).blur();
        });
    }

}
$(function(){
	ordenes.initOrdenes();
    ordenes.initBotonesOrdenes();
    ordenes.initBotonesMovimientos();
    ordenes.initBotonesEstadoCuenta();
});

function _llenarTablaOrdenes(){
    showSpinner();
    tablaDataOrdenes = '<table id="dataOrdenes" class="display table table-bordered table-striped" style=" width: auto;">'
                            +'<thead>'
                                +'<tr>'
                                    +'<th id="thCuenta">ID</th>'
                                    +'<th id="thDetalles">Status</th>'
                                    +'<th id="thId">Cliente</th>'
                                    +'<th id="thRFC">Concepto</th>'
                                    +'<th id="thRazonSocial">Vigencia</th>'
                                    +'<th id="thNombre">Monto Orden</th>'
                                    +'<th id="thCorreo">Saldo Orden</th>'
                                    
                                    +'<th id="thDetalles">Correo</th>'
                                    +'<th id="thDetalles">Referencia</th>'
                                    +'<th id="thDetalles">Detalles</th>'
                                +'</tr>'
                            +'</thead>'  
                            +'<tbody >'
                            +'</tbody>'
                        +'</table>';

    $("#tablaOrdenes").html(tablaDataOrdenes);
    // var datosOrdenes = $("#dataOrdenes").DataTable();
    // datosOrdenes.fnClearTable();
    // datosOrdenes.fnDestroy();

    var sFechaI = $('#p_dFechaInicioO').val();
    var sFechaF = $('#p_dFechaFinO').val();
    
    $.post(BASE_URL +"/paynau/ajax/soporte/getOrdenesProveedor.php",
    {
        nIdProveedor : $('#nIdProveedor').val(),
        dFechaIni : sFechaI,
                            dFechafin : sFechaF
    }, 
    function(response){
         var obj = jQuery.parseJSON(response);
         
          jQuery.each(obj, function(index,value) {
                                  var monto = accounting.formatMoney(accounting.toFixed(obj[index]['nMontoOrden'],2),'$');
                                  var saldo = accounting.formatMoney(accounting.toFixed(obj[index]['nSaldoOrden'],2),'$');
         var colorEstatus = obj[index]['nIdEstatus'] == 1 ? 'style="color: #FF0000";' : 'style="color: #22AA22;"';
         $('#dataOrdenes tbody').append('<tr>'+

                '<td> '+obj[index]['nIdOrden']+'</td>'+
                '<td '+colorEstatus+'><span>'+obj[index]['sEstatus']+'</span></td>'+
                '<td>'+obj[index]['sNombreCliente']+'</td>'+
                '<td>'+obj[index]['sNombreConcepto']+'</td>'+
                '<td> '+obj[index]['dFecVigencia']+'</td>'+
                '<td>'+monto+'</td>'+
                '<td>'+saldo+'</td>'+
                '<td> '+obj[index]['sCorreo']+'</td>'+
                '<td> '+obj[index]['sReferencia']+'</td>'+
                // '<td > '+obj[index]['nIdTipoPago']+'</td>'+

                '<td > <button id="verDetalleOrden" data-orden='+obj[index]['nIdOrden']+' data-referencia ="'+obj[index]['sReferencia']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
                '</tr>');
                tipoPago = obj[index]['nIdTipoPago'].split();
                
          });
          $("#dataOrdenes").DataTable(settings);
    })
    .fail(function(resp){
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });
}

function _llenarTablaMovimientos() {
    showSpinner();
    var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
                            "oLanguage": {
                            "sZeroRecords": "No se encontraron registros",
                            "sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sSearch": "Buscar:"  ,
                            "sInfoFiltered": " - filtrado de _MAX_ registros",
                            "oPaginate": {
                            "sNext": "Siguiente",
                            "sPrevious": " Anterior"
                                    }
                            },
                            "bSort" :false
                            };

    $("#dataClientes tbody").empty();
    var datos = $("#dataClientes").DataTable();
    datos.fnClearTable();
    datos.fnDestroy();

    var tabla = $("#tblGridBox2").DataTable();
    tabla.fnClearTable();
    tabla.fnDestroy();
    document.getElementById('detalleMovimientos').style.display='none';
    document.getElementById('titulo').style.display='none';
    var sFechaI = $('#p_dFechaInicioM').val();
    var sFechaF = $('#p_dFechaFinM').val();
    $.post(BASE_URL +"/paynau/ajax/soporte/getMovimientosProveedor.php",
    {
        nTipo : 1,
        nIdProveedor : $('#nIdProveedor').val(),
        dFechaIni : sFechaI,
        dFechafin : sFechaF
    }, 
    function(response){
        var obj = jQuery.parseJSON(response);

         jQuery.each(obj, function(index,value) {
        var montoOrden = accounting.formatMoney(accounting.toFixed(obj[index]['nMontoOrden'],2),'$');
        var montoPendiente = accounting.formatMoney(accounting.toFixed(obj[index]['nMontoPendiente'],2),'$');
        var idOrden = obj[index]['nIdEstatus'] == 1 ? 'style="color: #FF0000;"' : 'style="color: #22AA22;"';
        $('#dataClientes tbody').append('<tr>'+

                    '<td><span class="status-pill smaller"></span><span>'+obj[index]['nIdOrdenCobro']+'</span></td>'+
                    '<td>'+obj[index]['sReferencia']+'</td>'+
                    '<td> '+obj[index]['sNombre']+'</td>'+
                    '<td>'+obj[index]['Concepto']+'</td>'+
                    '<td '+idOrden+'> '+obj[index]['Estatus']+'</td>'+
                    '<td>'+obj[index]['dFecRegistro']+'</td>'+
                    '<td>'+montoOrden+'</td>'+
                    '<td> '+montoPendiente+'</td>'+
                    '<td > <button id="verDetalleClientes" data-idProveedor='+obj[index]['nIdProveedor']+' data-referencia ="'+obj[index]['sReferencia']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
                    '</tr>');
         });
         datos.DataTable(settings);
    })
    .fail(function(resp){
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });
}

function _llenarTablaEstadoCuenta(){
    showSpinner();
    $('#nSaldoActual').val(accounting.formatMoney(0));
    $('#nSaldoPendiente').val(accounting.formatMoney(0));
    $('#nSaldoFinal').val(accounting.formatMoney(0));
    var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
                                            "oLanguage": {
                                            "sZeroRecords": "No se encontraron registros",
                                            "sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
                                            "sLengthMenu": "Mostrar _MENU_ registros",
                                            "sSearch": "Buscar:"  ,
                                            "sInfoFiltered": " - filtrado de _MAX_ registros",
                                            "oPaginate": {
                                            "sNext": "Siguiente",
                                            "sPrevious": " Anterior"
                                                    }
                                            },
                                            "bSort" :false
                                            };

    $("#dataEstadoCuenta tbody").empty();
    var datos = $("#dataEstadoCuenta").DataTable();
    datos.fnClearTable();
    datos.fnDestroy();
    
    var sFechaI = $('#p_dFechaInicio').val();
    var sFechaF = $('#p_dFechaFin').val();
    $.post(BASE_URL +"/paynau/ajax/soporte/getEstadoCuentaProveedor.php",
    {
        nIdProveedor : $('#nIdProveedor').val(),
        dFechaIni : sFechaI,
        dFechafin : sFechaF
    }, 
    function(response){
        var obj = jQuery.parseJSON(response);
        conteo = obj.Data.length;
        if(conteo > 0){
            
            $('#nSaldoActual').val(accounting.formatMoney(obj.SaldoActual));
            $('#nSaldoPendiente').val(accounting.formatMoney(obj.SaldoPendiente));
            $('#nSaldoFinal').val(accounting.formatMoney(obj.Saldofinal));
            obj = obj.Data;
            jQuery.each(obj, function(index,value) {
                var saldoIni = accounting.formatMoney(accounting.toFixed(obj[index]['nSaldoInicial'],2),'$');
                var abono = accounting.formatMoney(accounting.toFixed(obj[index]['nAbono'],2),'$');
                var cargo = accounting.formatMoney(accounting.toFixed(obj[index]['nCargo'],2),'$');
                var saldoFin = accounting.formatMoney(accounting.toFixed(obj[index]['nSaldoFinal'],2),'$');
                $('#dataEstadoCuenta tbody').append('<tr>'+
                    '<td><span class="status-pill smaller"></span><span>'+obj[index]['nIdMovimiento']+'</span></td>'+
                    '<td><span class="status-pill smaller"></span><span>'+obj[index]['dFecMovimiento']+'</span></td>'+
                    '<td>'+obj[index]['sDescripcion']+'</td>'+
                    '<td> '+obj[index]['sNombre']+'</td>'+
                    '<td>'+saldoIni+'</td>'+
                    '<td>'+abono+'</td>'+
                    '<td>'+cargo+'</td>'+
                    '<td>'+saldoFin+'</td>'+
                    '</tr>'
                );
            });
                 datos.DataTable(settings);
        }else{
            jAlert("No hay registros");
        }
    })
    .fail(function(resp){
        alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
    }).always(function(){
        hideSpinner();
    });
}

function _llenarTablaClientes(){
        showSpinner();
        var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
                                "oLanguage": {
                                "sZeroRecords": "No se encontraron registros",
                                "sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
                                "sLengthMenu": "Mostrar _MENU_ registros",
                                "sSearch": "Buscar:"  ,
                                "sInfoFiltered": " - filtrado de _MAX_ registros",
                                "oPaginate": {
                                "sNext": "Siguiente",
                                "sPrevious": " Anterior"
                                        }
                                },
                                "bSort" :false
                                };

        $("#dataDatosCliente tbody").empty();
        var datos = $("#dataDatosCliente").DataTable();
        datos.fnClearTable();
        datos.fnDestroy();
        
        $.post(BASE_URL +"/paynau/ajax/soporte/getDatosCliente.php",
        {
            nIdProveedor : $('#nIdProveedor').val()
        }, 
        function(response){
            var obj = jQuery.parseJSON(response);
            conteo = obj.Data.length;
            if(conteo > 0){
                
            obj = obj.Data;
            jQuery.each(obj, function(index,value) {
            Proveedor = obj[index]['nIdProveedor'];
            idContacto = obj[index]['nIdContacto'];
            nIdCollect = obj[index]['nIdCollect'];
            nListaGrupos = obj[index]['nListaGrupos'];
            estatus = obj[index]['nIdEstatus'];
            nombreAll = obj[index]['sNombreCompleto'];
            nombre = obj[index]['sNombre'];
            apellidoM = obj[index]['sApellidoMaterno'];
            apellidoP = obj[index]['sApellidoPaterno'];
            correo = obj[index]['sCorreo'];
            celular = obj[index]['sCelular'];
            $('#dataDatosCliente tbody').append('<tr>'+

                        '<td><span class="status-pill smaller"></span><span>'+nombreAll+'</span></td>'+
                        '<td><span class="status-pill smaller"></span><span>'+correo+'</span></td>'+
                        '<td>'+celular+'</td>'+
                        '<td><button id="modificarCliente" onclick="cargarModalEditCliente('+2+",'"+Proveedor+"','"+idContacto+"','"+nIdCollect+"','"+nListaGrupos+"','"+estatus+"','"+nombre+"','"+apellidoP+"','"+apellidoM+"','"+correo+"','"+celular+"'"+');" data-idProveedor="'+obj[index]['nIdProveedor']+'" data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Modificar"><span class="fa fa-undo"></span></button>'+
                        '<td><button id="eliminarCliente" onclick="EliminarCliente('+Proveedor+",'"+idContacto+"'"+');" data-idProveedor='+Proveedor+' data-contacto ="'+idContacto+'" data-placement="top" rel="tooltip" class="btn habilitar btn-default btn-xs"><span class="fa fa-times"></span></button>'+
                        '</tr>');

             });
             datos.DataTable(settings);
            }else{
                jAlert("No hay registros");
            }
        })
        .fail(function(resp){
                alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        }).always(function(){
            hideSpinner();
        });
}




function cargarModalEditCliente(tipo,idProveedor,idContacto,nIdCollect,nListaGrupos,estatus,sNombre,apellidoP,appellidoM,sCorreo,sCelular){
//        tipo = 1;
        idProveedor = (tipo == 2 ? idProveedor : 0);
        idContacto = (tipo == 2 ? idContacto : 0);
        nIdCollect = (tipo == 2 ? nIdCollect : 0);
        nListaGrupos = (tipo == 2 ? nListaGrupos : "");
        estatus = (tipo == 2 ? estatus : "");
        sNombre = (tipo == 2 ? sNombre : "");
        appellidoM = (tipo == 2 ? appellidoM : "");
        apellidoP = (tipo == 2 ? apellidoP : "");
        sCorreo = (tipo == 2 ? sCorreo : "");
        sCelular = (tipo == 2 ? sCelular : "");
        if (tipo == 2) {
            $('#btnOpcionCliente').html("Guargar");
            $('.titulo-modal').html("Editar Clientes");
            $('#nTipo').val(tipo);
        }else {
            $('#btnOpcionCliente').html("Agregar");
            $('.titulo-modal').html("Agregar Clientes");
            $('#nTipo').val(tipo);
        }

        $('#modalEditarCliente').modal({backdrop:'static', keyboard:'false'});
        var formEditarClientes = '<form action=""  method="post" id="formEditarCliente" class="form-horizontal">'+
            '<div class="form-group">'+
                '<input type="hidden" name="nIdProveedor" id="nIdProveedor"  value="'+idProveedor+'"/>'+
                '<input type="hidden" name="nidContacto" id="nidContacto"  value="'+idContacto+'"/>'+
                '<input type="hidden" name="nIdCollect" id="nIdCollect"  value="'+nIdCollect+'"/>'+
                '<input type="hidden" name="nListaGrupos" id="nListaGrupos"  value="'+nListaGrupos+'"/>'+
                '<input type="hidden" name="estatus" id="estatus"  value="'+estatus+'"/>'+
                '<label for="exampleInputEmail1">Nombre</label>'+
                '<input type="text" class="form-control" name="sNombre" id="sNombre" value="'+sNombre+'">'+
                '<br>'+
                '<label for="exampleInputEmail1">Apellido paterno</label>'+
                '<input type="text" class="form-control" name="apellidoP" id="apellidoP" value="'+apellidoP+'">'+
                '<br>'+
                '<label for="exampleInputEmail1">Apellido materno</label>'+
                '<input type="text" class="form-control" name="appellidoM" id="appellidoM" value="'+appellidoM+'">'+
                '<br>'+
                '<label for="exampleInputEmail1">Celular</label>'+
                '<input type="text" class="form-control" name="sCelular" maxlength="10" id="sCelular" value="'+sCelular+'">'+
                '<br>'+
                '<label for="exampleInputEmail1">Correo</label>'+
                '<input type="text" class="form-control" name="sCorreo" id="sCorreo" value="'+sCorreo+'">'+
                '<br>'+
            '</div>'+
	'</form>';
        $('#modalEditarCliente .panel-body ').append(formEditarClientes);
}

function EditarClientes(prov){
    var nIdProveedor = $('#nIdProveedor').val();
    var nidContacto = $('#nidContacto').val();
    var nIdCollect = $('#nIdCollect').val();
    var nListaGrupos = $('#nListaGrupos').val();
    var estatus = $('#estatus').val();
    var sNombre = $('#sNombre').val();
    var appellidoM = $('#appellidoM').val();
    var apellidoP = $('#apellidoP').val();
    var sCelular = $('#sCelular').val();
    var sCorreo = $('#sCorreo').val();
    var campos = "";
    var error = "";
        if (sNombre == undefined || sNombre.trim() == '') {
            campos += 'Nombre\n';
        }
        if (apellidoP == undefined || apellidoP.trim() == '') {
            campos += 'Appellido Paterno\n';
        }
        if (sCelular == undefined || sCelular.trim() == '') {
            campos += 'Celular\n';
        }
        if (sCorreo == undefined || sCorreo.trim() == '') {
            campos += 'Correo\n';
        }
            if (campos != null && campos != "") {
                var black = (campos != "")? "Los siguientes datos son Obligatorios : " : "";
                jAlert(black + '\n' + campos+'\n' );
                event.preventDefault();
            }else {
                $.post(BASE_URL+"/paynau/ajax/soporte/modificarClientes.php",
                {
                    nIdProveedor : nIdProveedor,
                    nIdContacto : nidContacto,
                    nIdCollect : nIdCollect,
                    nListaGrupos : nListaGrupos,
                    estatus : estatus,
                    sNombre : sNombre,
                    appellidoM : appellidoM,
                    apellidoP : apellidoP,
                    sCelular : sCelular,
                    sCorreo : sCorreo
                },
                function(response){
                    var obj = jQuery.parseJSON(response);
                    if (obj.Codigo == 0) {
                        alert(obj.Mensaje);
                        $('#modalEditarCliente').modal('hide');
                        _llenarTablaClientes();
                    }else{
                        jAlert(obj.Mensaje);
                    }
                })
            }

}

function AgregarClientes(prov){
    var Proveedor = prov;
    var Collect = $('#nIdCollect').val();
    var ListaGrupos = $('#nListaGrupos').val();
    var Nombre = $('#sNombre').val();
    var AppellidoM = $('#appellidoM').val();
    var ApellidoP = $('#apellidoP').val();
    var Celular = $('#sCelular').val();
    var Correo = $('#sCorreo').val();
    var campos = "";
    if (Nombre == undefined || Nombre.trim() == '') {
            campos += 'Nombre\n';
        }
        if (ApellidoP == undefined || ApellidoP.trim() == '') {
            campos += 'Apellido Paterno\n';
        }
        if (Celular == undefined || Celular.trim() == '') {
            campos += 'Celular\n';
        }
        if (Correo == undefined || Correo.trim() == '') {
            campos += 'Correo\n';
        }
        if (campos != null && campos != "") {
            var black = (campos != "")? "Los siguientes datos son Obligatorios : " : "";
            jAlert(black + '\n' + campos+'\n' );
            event.preventDefault();
        }else{
            $.post(BASE_URL +"/paynau/ajax/soporte/agregarCliente.php",
            {
                Proveedor : Proveedor,
                Collect : Collect,
                Nombre : Nombre,
                ApellidoM : AppellidoM,
                ApellidoP : ApellidoP,
                Correo : Correo,
                Celular : Celular,
                ListaGrupos : ListaGrupos

            },
            function(response){
                var obj = jQuery.parseJSON(response);
                if (obj.Data[0].nCodigo === 0) {
                    alert(obj.Data[0].sMensaje);
                    $('#modalEditarCliente').modal('hide');
                    _llenarTablaClientes();
                }else{
                    alert(obj.Data[0].sMensaje);
                }
            });
        }
}

function EliminarCliente(Prov,Contacto){
    var result = confirm ( "¿Está seguro de eliminar?" );
    if (result) {
        $.post(BASE_URL +"/paynau/ajax/soporte/eliminarCliente.php",
        {
            nIdProveedor :Prov,
            nIdContacto :Contacto
        },
        function(response){
            var obj = jQuery.parseJSON(response);
            if (obj.Data[0].nCodigo == 0) {
                alert(obj.Data[0].sMensaje);
                _llenarTablaClientes();
            }else{
                jAlert(obj.Data[0].sMensaje);
            }
        });
    }
}
function cargarModalOrden(nIdOrden){
	$('#dataDetallePagoOrden tbody').empty();
    var datosPagoOrden = $("#dataDetallePagoOrden").DataTable();
	datosPagoOrden.fnClearTable();
	datosPagoOrden.fnDestroy();

	
	
	$.post(BASE_URL +"/paynau/ajax/soporte/getDetalleOrden.php",
	{
		nIdOrden : nIdOrden
		
	}, 
	function(response){
		 var obj = jQuery.parseJSON(response);
		 var numeroPago = 1;
		  jQuery.each(obj, function(index,value) {

		 		$('#dataDetallePagoOrden tbody').append('<tr>'+
				'<td> '+obj[index]['nIdOrdenCobro']+'</td>'+
				'<td>'+numeroPago+'</td>'+
				'<td>'+obj[index]['sEstatus']+'</td>'+
				'<td>'+obj[index]['sNombre']+'</td>'+
				'<td>$'+obj[index]['nMontoOrden']+'</td>'+
				'<td>$'+obj[index]['nAbono']+'</td>'+
				'<td>$'+obj[index]['nSaldoOrden']+'</td>'+
				'<td>'+obj[index]['dFecVigencia']+'</td>'+
				'<td>'+obj[index]['dFecEnvio']+'</td>'+
				'<td>'+obj[index]['dFechaPago']+'</td>'+
				'</tr>');
				// tipoPago = obj[index]['nIdTipoPago'].split();
				numeroPago++;
		  });
		  datosPagoOrden.DataTable(settings);
	})
	.fail(function(resp){
			alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	});
}

var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
                                    "oLanguage": {
                                    "sZeroRecords": "No se encontraron registros",
                                    "sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
                                    "sLengthMenu": "Mostrar _MENU_ registros",
                                    "sSearch": "Buscar:"  ,
                                    "sInfoFiltered": " - filtrado de _MAX_ registros",
                                    "oPaginate": {
                                    "sNext": "Siguiente",
                                    "sPrevious": " Anterior"
                                        }
                                    },
                                    "bSort" :false
                                    };

                                                                        
function cargaDetalleMovimientos(idProveedor, nReferencia){
    var tabla = $('#tblGridBox2').DataTable();
    
    tabla.fnClearTable();
    tabla.fnDestroy();
        var sFechaI = $('#p_dFechaInicioM').val();
        var sFechaF = $('#p_dFechaFinM').val();
        $.post(BASE_URL + "/paynau/ajax/soporte/getMovimientosProveedor.php",
        {
            nTipo : 2,
            nIdProveedor : idProveedor,
            nReferencia : nReferencia,
            dFechaIni : sFechaI,
            dFechafin : sFechaF
        },
        function(response){
            
            var obj = jQuery.parseJSON(response);            
            conteo = obj.length;
                
                if (conteo > 0) {                    
                    
                document.getElementById('detalleMovimientos').style.display='block';
                document.getElementById('titulo').style.display='block';
                    jQuery.each(obj, function(index, value){
                        $('#tblGridBox2 tbody').append('<tr>'+
                                '<td style="text-align:center;">'+obj[index]['nIdMovimiento']+'</td>'+
                                '<td style="text-align:center;">'+obj[index]['sReferencia']+'</td>'+
                                '<td style="text-align:center;">'+obj[index]['nAbono']+'</td>'+
                                '<td style="text-align:center;">'+obj[index]['sNombre']+'</td>'+
                                '<td style="text-align:center;">'+obj[index]['dFecRegistro']+'</td>'+
                                '<td style="text-align:center;">'+obj[index]['dHora']+'</td>'+
                        '</tr>');
                        
                    });
                        tabla.DataTable(settingsMovimiento);
                    
                    document.getElementById("tblGridBox2").style.display="inline-table";
                    document.getElementById("tblGridBox2").style.width="100%";
                }else{
                    document.getElementById('detalleMovimientos').style.display='none';
                    document.getElementById('titulo').style.display='none';
                    jAlert("no se encontro informacion");
                }
        }).fail(function(resp){
            jAlert("Ha ocurrido un error" + resp);
        });
}

//$('#modalEditarCliente').modal();