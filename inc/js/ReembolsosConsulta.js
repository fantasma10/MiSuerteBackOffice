
function initComponentReembolsosConsulta(){

	$('#txtCadena, #txtSubCadena, #txtCorresponsal').alpha({
		allow : '-0123456789',
		allowLatin: true,
		allowOtherCharSets: true
	});

	$('#txtNumCta').prop('maxlength', 10);

	var urlCat = BASE_PATH + '/inc/Ajax/_Clientes/getListaCategoria.php';
	//AutoCompletar CAdena
	if($('#idCadena').length && $('#txtCadena').length){
		autoCompletaGeneral('txtCadena', 'idCadena', urlCat, 'nombreCadena', 'idCadena', {categoria : 1}, renderItemCadena);
	}

	if($('#idCadena').length && $('#txtCadenaCor').length){
		autoCompletaGeneral('txtCadenaCor', 'idCadena', urlCat, 'nombreCadena', 'idCadena', {categoria : 1}, renderItemCadena);
	}
	//AutoCompletar SubCadena
	if($('#idSubCadena').length && $('#txtSubCadena').length){
		
		$("#txtSubCadena").keyup(function(){
			var cadena = $("#idCadena").val();
			autoCompletaGeneral('txtSubCadena', 'idSubCadena', urlCat, 'nombreSubCadena', 'idSubCadena', {categoria : 2, idCadena : cadena}, renderItemSubCadena);
		});
		$("#txtSubCadena").keypress(function(){
			var cadena = $("#idCadena").val();
			autoCompletaGeneral('txtSubCadena', 'idSubCadena', urlCat, 'nombreSubCadena', 'idSubCadena', {categoria : 2, idCadena : cadena}, renderItemSubCadena);
		});
	}
	//AutoCompletar Corresponsal
	if($("#txtCorresponsal").length){
		$("#txtCorresponsal").keypress(function(){
			var cadena		= $("#idCadena").val();
			var subcadena	= $("#idSubCadena").val();
			var parametros	= {categoria : 3, idCadena : cadena, idSubCadena : subcadena}

			autoCompletaGeneral('txtCorresponsal', 'idCorresponsal', urlCat, 'nombreCorresponsal', 'idCorresponsal', parametros, renderItemCorresponsal);
		});
	}

	$("#txtCadena, #txtSubCadena, #txtCorresponsal").keyup(function(e){
		var targ	= e.target;
		var id		= targ.id;
		var tip 	= id.substring(0, 3);
		var last	= id.substring(3, id.length);

		var val = $("#"+id).val();
		var valor = val.trim();

		var arr = {'txt' : 'id'};

		if(valor == ""){
			$("#" +arr[tip] + last).val(-1);
		}
	});

	$(":input").bind("paste", _denegar);
	$("#gridbox").delegate("input", "paste", _denegar);

	$('body').on('tablaLlena', function(ev, oT){
		dataTableObj.fnSettings().aoColumns[4].sClass = 'align-right';
		dataTableObj.fnSettings().aoColumns[5].sClass = 'align-right';

		dataTableObj.$('img').tooltip({
			"delay": 0,
			"track": true,
			"fade": 250					  
		});
	});
	
	$("#fecha").datepicker().on('changeDate', function(event){
		var fecha_seleccionada  = obtenerFecha(event.date);
		var hoy                 = obtenerFecha(new Date());
	});
}

function _denegar(e){
	e.preventDefault();
	return false;
}

function renderItemCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "</a>" )
	.appendTo( ul );
}

function renderItemSubCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "<br>" + item.nombreCadena +"</a>" )
	.appendTo( ul );
}

function renderItemCorresponsal( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label +"</a>" )
	.appendTo( ul );
}

function verReembolso(idCorte){
	$("#corner").html("Ver Reembolso");

	cargarContenidoHtml(BASE_PATH  + '/_Contabilidad/Pagos/Reembolsos/Consulta.php', 'divTbl', 'iniciaEditarReembolso(' + idCorte + ')');
}

function buscarReembolsos(){

	var params = getParams($('#formBusqueda').serialize());

	$('#botones_excel').show();

	var extraHeaders	= "";
	var extraCells		= "";
	//coordinador de contabilidad
	
	if(ES_ESCRITURA){
		if(ID_PERFIL == 3 || ID_PERFIL == 1){
			extraHeaders = "<th>Eliminar</th>";
			//extraHeaders = "<th>Eliminar</th>";
			extraCells = "<td></td>";
			//extraCells = "<td></td>";
		}//contabilidad base
		else if(ID_PERFIL == 9){
			extraHeaders = "<th>Editar</th>";
			extraCells = "<td></td>";
			//extraHeaders = "<th>Editar</th>";
			//extraCells = "<td></td>";			
		}
	}

	var tabla = "<table id='tblGridBox' class='display table table-bordered table-striped dataTable'><thead><th>Cadena</th><th>SubCadena</th><th>Corresponsal</th><th>Cuenta</th><th>Cuenta Contable</th><th>Importe</th><th>Fecha</th><th>Justificaci&oacute;n</th><th>Ver<th>Estatus</th></th>" + extraHeaders + "</thead>";
	tabla += "<tbody></tbody></table>";

	$('#gridbox').empty().html(tabla).show();

	//console.log(params);

	llenaDataTable('tblGridBox', params, BASE_PATH + '/inc/Ajax/_Contabilidad/buscarReembolsos.php');
}

function descargaExcel(todo){

	var url = BASE_PATH + '/inc/Ajax/_Contabilidad/ReembolsosExcel.php';
	showExcelCommon(todo, url, '#formBusqueda');
}