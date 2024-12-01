dataTableObj = {}
//gIdProveedor = 0;
function initComponentsConsultaFacturasRecibos(){

	$('#txtNumCta').prop('maxlength', 10);

	var checkin1 = $('#txtFechaInicio').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin1.hide();
		}
	).data('datepicker');

	var checkin2 = $('#txtFechaFinal').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin2.hide();
		}
	).data('datepicker');

	var checkin3 = $('#txtFechaFact').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
		function(ev){
			checkin3.hide();
		}
	).data('datepicker');

	$("#noFactura").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false
	});

	try{
		$("#txtNumFactura").alphanum({
			allowOtherCharSets: false
		});		
	}
	catch(e){
		console.log(e);
	}

	// LLenar combo de Tipos de Documento
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeTipoDocumento.php', 'tipoDocumento', {}, {text : 'nombreDocumento', value : 'idTipoDocumento'});
	// Llenar combo de Proveedores
	cargarStoreProveedores();
	// Llenar combo de Estatus
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeEstatusData_Contable.php', 'idEstatus', {}, {text : 'descEstatus', value : 'idEstatus'});
}

function cargarStoreProveedores(){
	var tipoProv = $('#idTipoProveedor').val();
	if(ID_TIPO_PROVEEDOR == 0){
		cargarStore(BASE_PATH + '/inc/Ajax/stores/storeProveedores.php', 'ddlProv', {tipoProv : tipoProv}, {text : 'nombreProveedor', value : 'idProveedor'});
	}
	else{
		cargarStore(BASE_PATH + '/inc/Ajax/stores/storeAcreedores.php', 'ddlProv', {tipoProv : 1}, {text : 'nombreProveedor', value : 'idProveedor'}, {});
	}
}

function FindDatosProv(){
	var id = event.currentTarget.id;
	var idProveedor = txtValue(id);

	if(idProveedor > -1){
		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/DatosProveedor.php',
			{
				idProveedor		: idProveedor,
				idTipoProveedor	: ID_TIPO_PROVEEDOR
			},
			function(response){
				delete(response.data.NumCuenta)
				simpleFillFields(response.data, 'txt');
				console.log(gIdProveedor, idProveedor);
				if((gIdProveedor != idProveedor) && idProveedor != undefined){
					//console.log('validarNumeroDeFactura');
					$('body').trigger('validarNumeroDeFactura');
				}
			}
		, 'json');
	} else {
		if(Existe('txtNumCta')) setValue('txtNumCta','');
		if(id == 'ddlProveedor'){
			validaTipoDcto();
		}
	}
}

function FindDatosProv2(){
	var id = event.currentTarget.id;
	var idProveedor = txtValue(id);

	if(idProveedor > -1){
		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/DatosProveedor.php',
			{
				idProveedor		: idProveedor,
				idTipoProveedor	: ID_TIPO_PROVEEDOR
			},
			function(response){
				simpleFillFields(response.data, 'txt');
			}
		, 'json');
	} else {
		if(Existe('txtNumCuenta')) setValue('txtNumCuenta','');
	}
}

function BuscarFacturaRecibo(){

	var extraHeaders	= '';
	var extraCells		= '';

	var extraHeaders	= "";
	var extraCells		= "";

	if(ES_ESCRITURA){
		//coordinador de contabilidad y admin
		if(ID_PERFIL == 3 || ID_PERFIL == 1){
			extraHeaders = "<th>Editar</th><th>Eliminar</th>";
			extraCells = "<td></td><td></td>";
		}//contabilidad base
		else if(ID_PERFIL == 9){
			extraHeaders = "<th>Editar</th>";
			extraCells = "<td></td>";
		}
	}

	$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Tipo Dcto</th><th>No. Factura/Recibo</th><th>Razón Social</th><th>No. Cuenta</th><th>Fecha Factura/Recibo</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Total</th><th>Estatus</th><th>Detalle</th><th></th><th>Corte</th>'+extraHeaders+'</tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>'+extraCells+'</tr></tbody></table>');
	$('#botones_excel').show();
	$('#gridbox').show();

	var parametros = getParams($("#formBusqueda").serialize());
	parametros.idProveedor = parametros.ddlProveedor;
	llenaDataTable("tblGridBox", parametros, BASE_PATH + "/inc/Ajax/_Contabilidad/BuscaFacturaRecibo.php");
}

function AbrirDetalleFacturaOriginal(tipoDocumento, numeroCuenta, noFactura){
	return window.open(BASE_PATH + "/_Contabilidad/FacturasRecibos/Consulta.php?tipoDocumento="+tipoDocumento+"&numeroCuenta="+numeroCuenta+"&noFactura="+noFactura,null, "height=600,width=1100,status=yes,toolbar=yes,menubar=no,location=yes,scrollbars=1,resizable=1");
}

function AbrirDetalleFactura(tipoDocumento, numeroCuenta, noFactura){

	var idTipoProveedor = $("#idTipoProveedor").val();
	var url = BASE_PATH + "/_Contabilidad/FacturasRecibos/Consulta.php?tipoDocumento="+tipoDocumento+"&numeroCuenta="+numeroCuenta+"&noFactura="+noFactura+"&tipoProveedor="+idTipoProveedor;
	cargarContenidoHtml(url, 'divTbl', '');
}

function showExcel(todo){

	var parametros	= getParams($("form").serialize());
	var oBusqueda	= dataTableObj._fnDataToSearch();
	var strToFind	= oBusqueda.oPreviousSearch.sSearch;

	var paging			= dataTableObj.fnPagingInfo();
	parametros.start	= (todo == 1)? 0 : paging.iStart;
	parametros.end		= (todo == 1)? paging.iTotal : paging.iEnd;
	parametros.strToFind= (todo == 1)? '' : strToFind;

	parametros.iSortCol_0	= dataTableObj.fnSettings().aaSorting[0][0];
	parametros.sSortDir_0	= dataTableObj.fnSettings().aaSorting[0][1];

	var params = "";
	$.each(parametros, function(index, val){
		params += index + "=" + val + "&";
	});

	$.fileDownload(BASE_PATH + "/inc/Ajax/_Contabilidad/ListaExcel.php?" + params, {
		successCallback: function(url) {
			//OcultarEmergente();
		},
		failCallback: function(responseHtml, url){
			//OcultarEmergente();
			alert("Ha ocurrido un error");
		}
	});
	return false;
}

function editar(id){
	//externo
	if($("#idTipoProveedor").val() == 1){
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaCrearExt.php', 'divTbl', 'initComponentsVariosEditar();loadDocumento(' + id + ')', '');
	}
	//interno
	if($("#idTipoProveedor").val() == 0){
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaCrear.php', 'divTbl', 'initComponentsFacturasRecibosEditar();loadDocumento(' + id + ')', '');
	}

}

function loadDocumento(idDoc){
	$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/loadDocumento.php',
		{
			idDocumento		: idDoc,
			idTipoProveedor	: ID_TIPO_PROVEEDOR
		},
		function(response){
			//gIdProveedor = response.data.ddlProveedor;
			$('#txtAlta').val(2);
			
			if(ID_TIPO_PROVEEDOR == 1){
				$("#ddlProveedor").on('provextloaded', function(event){
					$(this).find('option').last().remove();
					$(this).val(response.data.ddlProveedor);
				});
			}

			fillFieldsChange(response.data, '');
			
			//$("#txtRazonSocial").val($("#ddlProveedor option:selected").text());		
			
			document.getElementById('txtTipoDcto').onchange = function (){
				validaTipoDctoAModificar();
			}
			
			document.getElementById('btnNuevaFactura').value = "Guardar Cambios";
		},
		'json'
	);
}



function eliminar(idDoc){
	if(confirm("\u00BFDesea Eliminar el Elemento Seleccionado?")){
		$.post(BASE_PATH + "/inc/Ajax/_Contabilidad/eliminarDocumento.php",
			{
				idFactura : idDoc
			},
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				//else{
					BuscarFacturaRecibo();
				//}
			},
			'json'
		);
	}
}

function cerrarModal(){
	$('#divTbl').empty();
}