function initComponentsAsignarFacturas(){
	$("#noFactura").alphanum({
		allowOtherCharSets: false
	});

	$('#tipoDocumento').on('tiposcargados', function(){
		$('#tipoDocumento').prop('disabled', true);
		$('#tipoDocumento').val(1);

	});
	// LLenar combo de Tipos de Documento
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoDocumento.php', 'tipoDocumento', {}, {text : 'nombreDocumento', value : 'idTipoDocumento'}, {}, 'tiposcargados');	

	var idTipo = $('#idTipoProveedor').val();
	autoCompletaGeneral('txtProv', 'idProveedor', BASE_PATH + '/inc/Ajax/stores/storeProveedores.php', 'nombreProveedor', 'idProveedor', {tipoProv : idTipo}, _funcion);

	$('#txtProv').keyup(function(e){
		
		var val = $("#txtProv").val();
		var valor = val.trim();

		if(valor == ""){
			$("#idProveedor").val(-1);
		}
	});

	$('body').delegate('.check', 'click', seleccionar);

	$('#gridbox2').delegate('#tblGridBox2 tbody tr', 'click',  function(){
		console.log(event.target);
		if(event.target.type != 'checkbox'){
			console.log(this);
			var rowIndex = dataTableObj.fnGetPosition(this);
			console.log(rowIndex);
			var checkBox = $(".check[row='" + rowIndex + "']").trigger('click');
		}
	});
}

function seleccionar(){
	var el = event.target;

	var at = getAttrs(el);

	var numCuenta = at.numcuenta;

	var disabled = $(".check[numcuenta='"+numCuenta+"']").is(':checked');

	$(".check[numcuenta!='"+ numCuenta +"']").prop('disabled', disabled);
}


function BuscarFacturaReciboAsignacion(){
	// habilitar el combo de los tipos de documento para que el metodo serialize lo pueda poner en los parámetros
	$('#tipoDocumento').prop('disabled', false);
	// preparar y mostrar la tabla
	$('#gridbox2').html('<table id="tblGridBox2" class="display table table-bordered table-striped"><thead><tr><th>Tipo Dcto</th><th>No. Factura/Recibo</th><th>Razón Social</th><th>No. Cuenta</th><th>Fecha Factura/Recibo</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Total</th><th>Estatus</th><th>Detalle</th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');
	$('#gridbox2').show();
	// preparar los parametros
	var parametros = getParams($("#formBusquedaFac").serialize());
	parametros.asignacion = 1;
	parametros.idEstatus = 1; // 1 = estatus pendiente
	parametros.idProveedor = cfgCorte.idProveedor;
	parametros.corte = 0;
	// despues de tener listos los parametros, deshabilitar el combo de tipos de documento para que solamente filtre por facturas
	$('#tipoDocumento').prop('disabled', true);
	// poblar la tabla
	llenaDataTable("tblGridBox2", parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/BuscaFacturaRecibo.php");
}

function asignarFactura(e){

	if(cfgCorte != undefined){
		var facturasSeleccionadas = $("input:checked").length;
		if ( facturasSeleccionadas > 0 ) {
			if(confirm("Asignar Factura a Corte Seleccionado")){
	
				var importeFactura = 0;
				var facturas = new Array();
	
				$.each($("input:checked"),function(a, b){
					importeFactura += toFloat($(b).attr("total"));
					facturas.push($(b).attr('idfactura'));
				});0
	
				facturas = facturas.join("\|");
	
				var descripcion = "";
	
				if(importeFactura != cfgCorte.importeCorte){
					descripcion = obtenerDescripcion();
				}
	
				var params			= cfgCorte;
				params.idFacturas	= facturas;
				params.descripcion	= descripcion;
				params.tipoCorte	= 1;
	
				$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/AsignarFacturaACorte.php',
					params,
					function(response){
						if(showMsg(response)){
							alert(response.msg);
						}
						else{
							BuscarCorteProveedor();
							BuscarFacturaReciboAsignacion();
						}
					},
					"json"
				);
			}
		} else {
			alert("No es posible asignar factura, ya que no se ha seleccionado ninguna factura.");
		}
	}
	else{
		alert("No es posible asignar la factura, ya que no se ha seleccionado ningun corte");
	}
}

/*function asignarFactura(e){
	if(cfgCorte != undefined){

		var link = e.target;

		var idFactura		= $(link).attr('idfactura');
		var importeFactura	= $(link).attr('total');

		if(confirm("Asignar Factura a Corte Seleccionado")){

			var descripcion = "";

			if(importeFactura != cfgCorte.importeCorte){
				descripcion = obtenerDescripcion();
			}

			var params			= cfgCorte;
			params.idFactura	= idFactura;
			params.descripcion	= descripcion;

			$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/AsignarFacturaACorte.php',
				params,
				function(response){
					if(showMsg(response)){
						alert(response.msg);
					}
					else{
						BuscarCorteProveedor();
					}
				},
				"json"
			);
		}

	}
	else{
		alert("No es posible asignar la factura, ya que no se ha seleccionado ningun corte");
	}
}*/

function _funcion( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.nombreProveedor + "</a>" )
	.appendTo( ul );
}