$(function(){
	$("#seleccionarCliente").on("click", function(){
		altaSucursales();
	});
});

function initConsultaCliente() {
	autoCompletaCliente('txtCliente', 'idCliente', 'esSubcadena', BASE_PATH + '/inc/Ajax/_Afiliaciones/getListaCategoria.php', 'nombreSubCadena', 'idSubCadena', 'esSubcadena', {idEstatus : 0, categoria : 2}, renderItemCadena);
}

function renderItemCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "</a>" )
	.appendTo( ul );
}

function altaSucursales() {
	var idCliente = $("#idCliente").val();
	if ( idCliente == "" || idCliente == null ) {
		alert( "Es necesario seleccionar un Cliente para poder avanzar al siguiente paso" );
		return false;
	} else {
		//window.location = "formnew5.php?id=" + idCliente;
		var URL = "formnew5.php?idCliente=" + idCliente;
		$("#formBuscarCliente").attr("action", URL);
		$("#formBuscarCliente").submit();
	}
}

/*
	txtField	string	: id del textbox en el cual se va a autocompletar
	idField		string	: id del campo en el que se va a poner el id del item seleccionado
	url			string	: url del archivo php que nos devolverá los datos para la lista
	valueText	string	: nombre del campo devuelto por la consulta que queremos que se visualice en el textbox autocompletable
	valueId		string	: nombre del campo devuelto por la consulta que queremos que se ponga en el campo de idField
	adParams	object	: parametros adicionales ej
	{
		idCadena	: 2
	}
*/
function autoCompletaCliente(txtField, idField, idField2, url, valueTxt, valueId, valueId2, adParams, nuevaFn){
	$("#"+txtField).autocomplete({
		source: function( request, respond ) {
			$.post(url,
				formatParams(adParams, {texto : request.term, pais : request.term, text : request.term, term : request.term})
			,
			function( response ) {
				if(!response.data){
					respond(response);
				}
				else{
					respond(response.data);
				}
			}, "json" );					
		},
		minLength: 1,
		focus: function( event, ui ) {
			var select = eval("ui.item." + valueTxt);
			$("#"+txtField).val(select);
			$("#"+ idField).val("");
			return false;
		},
		select: function( event, ui ) {
			var id = eval("ui.item."+valueId);
			var esClienteAntiguo = eval("ui.item."+valueId2);
			$("#"+ idField).val(id);
			$("#"+idField2).val(esClienteAntiguo);
			return false;
		},
		close: function(event, ui){
			var valorId = $("#"+ idField).val();
			/*if(valorId == "" || valorId == undefined){
				$("#"+txtField).val("");
			}*/
		}
	})
	.data( "ui-autocomplete" )._renderItem = nuevaFn || function( ul, item ){
		return $( '<li>' )
		.append( "<a>" + eval("item." + valueTxt) + "</a>" )
		.appendTo( ul );
	};
}
