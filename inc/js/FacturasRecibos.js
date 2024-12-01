/* "inicia" los componenetes de la pantalla de Consulta y Captura de las Facturas y Recibos de Proveedores Internos */
function initComponentsFacturasRecibosGlobal(){
	$('#radioConsulta, #radioCrear').on('click', seleccionarPantalla);
}


function seleccionarPantalla(radio){
	gIdProveedor = 0;
	ID_TIPO_PROVEEDOR = 0;
	var valorSeleccioando = radio.currentTarget.value; // 1 Consulta	2 Crear

	if(valorSeleccioando == 1){// Cargar la pantalla de Consulta
		cargarContenidoHtml('../../_Contabilidad/FacturasRecibos/pantallaConsulta.php', 'htmlContent', 'initComponentsConsultaFacturasRecibos()');
	}
	if(valorSeleccioando == 2){
		cargarContenidoHtml('../../_Contabilidad/FacturasRecibos/pantallaCrear.php', 'htmlContent', 'initComponentsFacturasRecibos()');
	}
}

/* "inicia" los componentes de la pantalla de Consulta y Captura de las Facturas y Recibos de Proveedores Externos */
function initComponentsFacturasRecibosVariosGlobal(){
	$('#radioConsulta, #radioCrear').on('click', seleccionarPantallaExt);
}

function seleccionarPantallaExt(radio){
	gIdProveedor = 0;
	ID_TIPO_PROVEEDOR = 1;
	var valorSeleccioando = radio.currentTarget.value; // 1 Consulta	2 Crear

	if(valorSeleccioando == 1){// Cargar la pantalla de Consulta
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaConsulta.php', 'htmlContent', 'setProveedor(1);initComponentsConsultaFacturasRecibos();');
	}
	if(valorSeleccioando == 2){
		cargarContenidoHtml(BASE_PATH + '/_Contabilidad/FacturasRecibos/pantallaCrearExt.php', 'htmlContent', 'initComponentsVarios()');
	}
}

function setProveedor(idTipo){
	$('#idTipoProveedor').val(idTipo);
}

function cargarContenidoHtml(url, div, functionAfterResponse, params){
	var parametros = (params != undefined)? params : {};
	$.post(url,
		parametros,
		function(response){
			$('#'+div).empty().html(response);
			eval(functionAfterResponse);
		}
	);
}