// funcion para 'inicializar' la creacion de los cortes, cuando se cargue el contenido del divRes que es el resultado de la consulta de los movimientos de los proveedores
// se mostrara u ocultara el boton de crear corte, segun los resultados
function initValidarCortes(){
	// cuando se termine de cargar el contenido, mostrar u ocultar el botón de crear corte, según sea el caso
	/*$('body').on('contenidocargado', muestraCrearCorte);

	// esconder el boton de crear corte cuando se limpie el resultado en pantalla
	$('body').on('clearres', hideBtnCorte);

	// Limpiar el resultado en pantalla al cambiar alguna de las fechas
	$('#fecha1, #fecha2').on('change', function(ev){
		ClearRes();	
	});

	$('#fecha1, #fecha2').datepicker().on('changeDate',
	function(ev){
		ClearRes();	
	}).data('datepicker');*/
}

//funcion para mostrar u ocultar el boton de crear corte
/*function muestraCrearCorte(){
	// Despues de que se carga el contenido en el divRES, obtenemos el valor de un hidden con id 'totalreg'
	var regs = $('#totalreg').val();
	var idProveedor = $('#ddlProveedor').val();
	var idFamilia	= $('#ddlFamilia').val();
	console.log(regs, ES_ESCRITURA, idProveedor, idFamilia);
	// Si se encontraron resultados y el usuario tiene permisos de escritura se crea y se muestra el boton para crear el corte
	if(regs > 0 && ES_ESCRITURA && idProveedor != -2 && (idFamilia == -2 || idFamilia >= 0)){
		showBtnCorte();
	}
	else{// se destruye el boton para crear el corte
		hideBtnCorte();
	}
}*/

function showBtnCorte(){
	if($('#btnCrearCorte').length == 0){
		$('.panel-body').append('<button class="btn btn-xs btn-info pull-right" style="margin-top: 10px; margin-left: 20px;" onclick="crearCorte()" id="btnCrearCorte"> Crear Corte </button>')
	}
	else{
		$('#btnCrearCorte').fadeIn();
	}
}

function hideBtnCorte(){
	if($('#btnCrearCorte').length){
		$('#btnCrearCorte').fadeOut();
		$('#btnCrearCorte').remove();
	}
}

function crearCorte(){
	//obtener el numero de registros encontrados
	var regs = $('#totalreg').val();
	// Si se encontraron resultados se crea el corte
	if(regs > 0){
		var valores = new Array();

		var params = getParams($('#formFiltros').serialize());

		// obtener los totales de la tabla
		$('#trTotales').find('td').each(function () {
			valores.push($(this).html());
		});
		// obtener los headers y asignarlos como propiedades del objeto params
		$('#ordertabla tr').eq(0).each(function () {
			var cont = 0;
			$(this).find('th').each(function () {
				var prop = accentsTidy($(this).html());
				params[prop] = valores[cont];
				cont++;
			});
		});

		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/crearCorteProveedorInterno.php',
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
			},
			"json"
		);

	}
	else{
		//alert("No hay registros para crear el corte");
	}
}

function accentsTidy(s){
	var r=s.toLowerCase();
	r = r.replace(new RegExp(/\s/g),"");
	r = r.replace(new RegExp(/[àáâãäå]/g),"a");
	r = r.replace(new RegExp(/æ/g),"ae");
	r = r.replace(new RegExp(/ç/g),"c");
	r = r.replace(new RegExp(/[èéêë]/g),"e");
	r = r.replace(new RegExp(/[ìíîï]/g),"i");
	r = r.replace(new RegExp(/ñ/g),"n");                
	r = r.replace(new RegExp(/[òóôõö]/g),"o");
	r = r.replace(new RegExp(/œ/g),"oe");
	r = r.replace(new RegExp(/[ùúûü]/g),"u");
	r = r.replace(new RegExp(/[ýÿ]/g),"y");
	r = r.replace(new RegExp(/\W/g),"");
	return r;
}


/*
**	FUNCIONES NUEVAS PARA CAMBIOS A CORTES
*/

// consulta y muestra la lista de familias con checkbox en el area de los filtros del reporte
function desplegarFamilias(){
	$.post(BASE_PATH + "/inc/Ajax/stores/storeFamilias.php",
		{},
		function(response){
			var obj = response.data;

			$.each(obj, function(index, item) {
				var id = "fam"+item.idFamilia;

				$("#divFamilias").append($("<div class='col-lg-3'></div>").append($("<input type='checkbox' value='"+item.idFamilia+"' id='"+id+"'><label for='"+id+"'>"+item.descFamilia+"</label>")));
			});
		},
		"json"
	);
}

// funcion para cargar la informacion del reporte
function BuscarProveedores2(i){
	var parametros = "";
	var proveedor = document.getElementById("ddlProveedor").value;
	//var familia = document.getElementById("ddlFamilia").value;

	var array_familias = new Array();

	$("input[type=checkbox]:checked").each(function(){
		array_familias.push($(this).val());
	});

	var familia = array_familias.join(",");

	if(proveedor < -1)
		proveedor = '';
	if(familia < -1)
		familia = '';
	var fecIni = document.getElementById("fecha1").value;
	
	if(fecIni != ""){
		if(validaFechaRegex("fecha1")){
			var fecFin = document.getElementById("fecha2").value;
			if(fecFin != ""){
				if(validaFechaRegex("fecha2")){
					if(fecFin >= fecIni){
						Emergente();
						parametros = "proveedor="+proveedor+"&familia="+familia+"&fecha1="+fecIni+"&fecha2="+fecFin;
						BuscarParametros("../../inc/Ajax/_Reportes/BuscaReporteProveedores2.php",parametros,'',i);
						Mostrar();
					}else{
						alert("La Fecha Inicial debe ser menor o igual a la Fecha Final");	
					}
				}else{
					alert("El formato de la fecha final es incorrecto");
				}
			}else{
				alert("Favor de seleccionar una Fecha Final");
			}
		}else{
			alert("El formato de la fecha inicial es incorrecto");
		}
	}else{alert("Favor de seleccionar una Fecha Inicial");}	
}