
function initConsultaSucursal(){

	$(":input").bind('paste', function(){return false;});

	$('#txtSucursal, #txtCliente').alphanum({
		allow				: 'áéíóúÁÉÍÓÚñÑ',
		allowNumeric		: true,
		allowOtherCharSets	: false
	});

	$('#txtTelefono').alphanum({
		disallow			: '',
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 15
	});

	autoCompletaGeneral('txtSucursal', 'idSucursal', BASE_PATH+'/inc/Ajax/_Afiliaciones/listaSucursal.php', 'nombreCorresponsal', 'idSucursal', {}, renderItemSucursal);
	autoCompletaGeneral('txtTelefono', 'idSucursal', BASE_PATH+'/inc/Ajax/_Afiliaciones/listaSucursal.php', 'nombreCorresponsal', 'idSucursal', {}, renderItemSucursal);
	//autoCompletaGeneral('txtCliente', 'idAfiliacion', BASE_PATH+'/inc/Ajax/_Afiliaciones/listaClientes.php', 'nombreCliente', 'idCliente', {}, renderCliente);

	$("#txtCliente").autocomplete({
		source: function( request, respond ) {
			$.post(BASE_PATH+'/inc/Ajax/_Afiliaciones/listaClientes.php',
				 {texto : request.term, pais : request.term, text : request.term, term : request.term, real : 1}
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
			var select = ui.item.nombreCliente;
			$("#txtCliente").val(select);
			$("#idAfiliacion").val("");
			$("#idSubCadena").val(0);
			return false;
		},
		select: function( event, ui ) {
			$("#idAfiliacion").val(ui.item.idCliente);
			$("#idSubCadena").val(ui.item.idSubCadena);
			return false;
		},
		close: function(event, ui){
			var valorId = $("#idAfiliacion").val();
			if(valorId == "" || valorId == undefined){
				$("#txtCliente").val("");
			}
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ){
		return $( '<li>' )
		.append( "<a> ID : "+ item.idCliente + " " + item.nombreCliente + "</a>" )
		.appendTo( ul );
	};

	$("#txtSucursal, #txtTelefono").on('keyup', function(){
		var id = event.target.id;
		var value = event.target.value;

		var cfg = {
			txtSucursal	: 'txtTelefono',
			txtTelefono		: 'txtSucursal'
		}

		var txt = eval("cfg."+id);

		if(value == "" || value == undefined){
			$("#"+txt).prop('disabled', false);
			$("#txtCliente").prop('disabled', false);
		}
		else{
			$("#"+txt).prop('disabled', true);

			$("#txtCliente").prop('disabled', true);
			$("#txtCliente").val("");
			$("#idAfiliacion").val("");
		}
	});

	$("#txtCliente").on('keyup', function(){
		var id = event.target.id;
		var value = event.target.value;

		if(value == "" || value == undefined){
			$("#txtSucursal, #txtTelefono").prop('disabled', false);
			$("#idAfiliacion").val("");
		}
		else{
			$("#txtSucursal, #txtTelefono").prop('disabled', true);
			$("#txtSucursal, #txtTelefono").val("");
		}
	});


}

function buscarSucursales(){
	var idSucursal		= $('#idSucursal').val();
	var idAfiliacion	= $('#idAfiliacion').val();
	idSubCadena		= $('#idSubCadena').val();

	console.log("idSucursal => ", idSucursal, "idAfiliacion => ", idAfiliacion);

	if(idSucursal == "" && idAfiliacion == ""){
		alert("Seleccione Sucursal o Cliente para continuar");
	}
	else{
		if(idSucursal != ""){
			window.location = "Sucursal.php?idSucursal=" + idSucursal;
		}
		else if(idAfiliacion != ""){
			mostrarListaSucursales(idAfiliacion);
		}
	}

}

function mostrarListaSucursales(idAfiliacion){
	var table = "<table id='tblGridBox' class='display table table-bordered table-striped dataTable'><thead>";
	table += "<th>ID</th>";
	table += "<th>Nombre Sucursal</th>";
	table += "<th>Direcci&oacute;n</th>";
	table += "<th>Tel&eacute;fono</th>";
	table += "<th>Ver</th>";
	table+="</thead><tbody></tbody></table>";

	$("#htmlListaSucursales").empty().html(table);

	llenaDataTable('tblGridBox', {idAfiliacion : idAfiliacion, idSubCadena : idSubCadena}, BASE_PATH + "/inc/Ajax/_Afiliaciones/getSucursales2.php");
}

function renderItemSucursal( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.idSucursal + " " + item.nombreCorresponsal + "</a>" )
	.appendTo( ul );
}

function renderCliente( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.idCliente + " " + item.nombreCliente + "</a>" )
	.appendTo( ul );
}

function validarExpediente(idExpediente){

	switch(idExpediente){
		case '1':
			return true;
		break;

		case '2':
			return true;
		break;

		case '3':
			return true;
		break;

		default :
			return false
		break;
	}
}