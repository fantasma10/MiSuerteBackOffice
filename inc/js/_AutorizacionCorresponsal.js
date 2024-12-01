
function showComprobanteDomicilio(idCategoria, categoria, idComprobante){
	var params = {
		idCategoria		: idCategoria,
		categoria		: categoria,
		idComprobante	: idComprobante
	}

	simpleLoadModal("../../../inc/Ajax/_Clientes/getComprobanteDomicilio.php", params, "modalContent")
}

function simpleLoadModal(url, params, div){
	$.post(url, params,
	function(response){
		$("#"+div).html(response);
	});
}