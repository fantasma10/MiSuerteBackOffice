function initComponentsAsignarFacturas(){

	tipoCorte = 3;

	$("#noFactura").alphanum({
		allowOtherCharSets: false
	});

	$('#tipoDocumento').on('tiposcargados', function(){
		$('#tipoDocumento').prop('disabled', true);
		$('#tipoDocumento').val(1);

	});
	// LLenar combo de Tipos de Documento
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoDocumento.php', 'tipoDocumento', {}, {text : 'nombreDocumento', value : 'idTipoDocumento'}, {}, 'tiposcargados');	
}


function BuscarFacturaAsignacion(){
	
	// habilitar el combo de los tipos de documento para que el metodo serialize lo pueda poner en los parámetros
	$('#tipoDocumento').prop('disabled', false);
	// preparar y mostrar la tabla
	$('#gridbox2').html('<table id="tblGridBox2" class="display table table-bordered table-striped"><thead><tr><th>Tipo Dcto</th><th>No. Factura/Recibo</th><th>Razón Social</th><th>No. Cuenta</th><th>Fecha Factura/Recibo</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Total</th><th>Estatus</th><th>Detalle</th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');
	$('#gridbox2').show();
	// preparar los parametros
	var parametros = getParams($("#formBusquedaFac").serialize());
	parametros.asignacion	= 1;
	parametros.idEstatus	= 1; // 1 = estatus pendiente
	//parametros.numeroCuenta	= $($('input:checked')[0]).attr('numcuenta');
	parametros.corte		= 0;
	// despues de tener listos los parametros, deshabilitar el combo de tipos de documento para que solamente filtre por facturas
	$('#tipoDocumento').prop('disabled', true);
	// poblar la tabla
	llenaDataTable("tblGridBox2", parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/BuscaFacturasGrupos.php");
}

function asignarFactura(e){
	
	var importeTotal = 0;
	var cortes = new Array();
	$.each($("input:checked"),function(a, b){
		importeTotal += toFloat($(b).attr("importe"));
		cortes.push($(b).attr('idcorte'));
	});

	cortes = cortes.join("\|");

	var link = e.target;

	var idFactura		= $(link).attr('idfactura');
	var importeFactura	= $(link).attr('total');

	if(confirm("Asignar Factura a Corte Seleccionado")){

		var descripcion = "";

		if(importeFactura != importeTotal){
			descripcion = obtenerDescripcion();
		}

		var params			= {};
		params.idFactura	= idFactura;
		params.descripcion	= descripcion;
		params.cortes		= cortes;
		params.tipoCorte	= 4;

		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/AsignarFacturaACorte.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				else{
					buscarCorteGrupo();
					BuscarFacturaAsignacion();
				}
			},
			"json"
		);
	}
}

function asignarFactura2(e){
	var importeTotal = 0;
	var cortes = new Array();
	
	var importeFactura = 0;
	var facturas = new Array();
	var diferenciaAceptable = 10.00;
	
	$.each($("input:checked"),function(a, b){
		if($(b).attr('idcorte')){
			importeTotal += toFloat($(b).attr("importe"));
			cortes.push($(b).attr('idcorte'));
		}else if($(b).attr('idfactura')){
			importeFactura += toFloat($(b).attr("total"));
			facturas.push($(b).attr('idfactura'));
		}	
	});

	facturas = facturas.join("\|");
	cortes = cortes.join("\|");
	
	if ( facturas != "" && facturas != null) {
		if(confirm("Asignar Facturas a Cortes Seleccionados")){
		
			var descripcion = "";
			if(importeFactura != importeTotal){
				var diferencia = importeFactura - importeTotal;
				if ( diferencia < 0 ) {
					diferencia = diferencia * -1;
				}
				if ( diferencia > diferenciaAceptable ) {
					descripcion = obtenerDescripcion();
					if ( descripcion == "" || descripcion == null ) {
						return false;
					}
				}
			}
		
			var params			= {};
			
			if(noInputs > 1){
				params.tipoRelacion = 1;
			}else{
				params.tipoRelacion = 2;
			}
			
			params.idFacturas	= facturas;
			params.descripcion	= descripcion;
			params.cortes		= cortes;
			params.tipoCorte	= 4;
		
			$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/AsignarFacturaACorte.php',
				params,
				function(response){
					if(showMsg(response)){
						alert(response.msg);
					}
					else{
						buscarCorteGrupo();
						BuscarFacturaAsignacion();
					}
				},
				"json"
			);
		}
	} else {
		alert("Para asignar es necesario seleccionar una factura.");
	}
}

