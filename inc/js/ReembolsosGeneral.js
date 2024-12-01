/* "inicia" los componenetes de la pantalla de Consulta y Registro de los Reembolsos */
function initComponentsReembolsosGeneral(){
	$('#radioConsulta, #radioCrear').on('click', seleccionarPantalla);
}


function seleccionarPantalla(radio){
	var valorSeleccioando = radio.currentTarget.value; // 1 Consulta	2 Crear

	if(valorSeleccioando == 1){// Cargar la pantalla de Consulta
		cargarContenidoHtml(BASE_PATH  + '/_Contabilidad/Pagos/Reembolsos/pantallaConsulta.php', 'htmlContent', 'initComponentReembolsosConsulta()');
	}
	if(valorSeleccioando == 2){
		cargarContenidoHtml(BASE_PATH  + '/_Contabilidad/Pagos/Reembolsos/pantallaCrear.php', 'htmlContent', 'initComponentsReembolsoManual()');
	}
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

function cerrarModal(){
	$('#divTbl').empty();
}