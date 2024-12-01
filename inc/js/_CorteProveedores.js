
function initCorte(){

	$("#ddlProveedor").on('change', function(event){
		var idProveedor = $(this).val();

		cargarStore(BASE_PATH + '/inc/Ajax/stores/storeConfiguracionCorte.php', 'cmbTipoCorte', {idProveedor : idProveedor}, {text : 'descripcion', value : 'idConfiguracion'});
	});

	// Llenar combo de Proveedores
	cargarStore(BASE_PATH + '/inc/Ajax/stores/storeProveedores.php', 'ddlProveedor', {}, {text : 'nombreProveedor', value : 'idProveedor'});
	
	$("#fecha11").datepicker().on('changeDate', function(event){
					var fecha_seleccionada  = obtenerFecha(event.date);
					var hoy                 = obtenerFecha(new Date());

					if(fecha_seleccionada < hoy){
						$(this).val("");
						alert("La Fecha de Pago no puede ser menor al día de Hoy");
					}
	});
}

	
function corteProveedores(){

	var params = getParams($("#formFiltros").serialize());

	if(params.idProveedor == undefined || params.idProveedor <= 0 || params.idProveedor == ""){
		alert("Seleccione Proveedor");return false;
	}

	if(params.idConfiguracion == undefined || params.idConfiguracion <= 0 || params.idConfiguracion == ""){
		alert("Seleccione Tipo de Corte");return false;
	}

	if(params.fecha1 == undefined || params.fecha1 == ""){
		alert("Seleccione Fecha de Inicio"); return false;
	}

	if(params.fecha2 == undefined || params.fecha2 == ""){
		alert("Seleccione Fecha Final");return false;
	}

	if(params.fecha2 < params.fecha1){
		alert("La Fecha de Inicio debe ser menor o igual a la Fecha Final");return false;
	}


	
	$.post(BASE_PATH + "/inc/Ajax/_Contabilidad/Pagos/ComisionesProveedor.php",
		params,
		function(response){
			if(!$("#ordertabla").length){
				$("#divRES").append('<table id="ordertabla" border="0" cellspacing="0" cellpadding="0" class="tablesorter tasktable"><thead><tr><th class="cabecera headerSortUp">Total</th><th class="cabecera">Producto</th><th class="cabecera headerSortUp">Importe</th><th class="cabecera">Comisión Cliente</th><th class="cabecera">SubTotal</th><th class="cabecera">IVA</th><th class="cabecera">Importe Total</th><th class="cabecera">Comisión Ganada</th><th class="cabecera">Importe Neto</th></tr></thead><tbody></tbody><tfoot></tfoot></table>');
			}
			else{
				$("#ordertabla >tbody").empty();
				$("#ordertabla >tfoot").empty();
			}

			if(response.data.body.length > 0){
				var row = 0;

				$("#totalreg").val(response.data.body.length);

				/*if($("#fecha11").length == 0){
					
					$("#formFiltros").append($("<div class='form-group'></div>").append("<label class='col-lg-2'>Fecha de Pago</label>").append($('<div class="col-lg-2"></div>').append('<input type="text" id="fecha11" name="fecha11" class="form-control form-control-inline input-medium default-date-picker" onpaste="return false;" data-date-format="yyyy-mm-dd" maxlength="10" value="" onKeyPress="return validaFecha(event,\'fecha11\')" onKeyUp="validaFecha2(event,\'fecha11\')">')));
					
					
				}*/
				
				$("#divFechaPago").attr("class", "form-group col-xs-4");

				
						

				/*$("#fecha11").on("blur", function(event){
					var fecha_seleccionada = $(this).val();

					if(myTrim(fecha_seleccionada) != ""){
						var hoy = obtenerFecha(new Date());

						if(fecha_seleccionada < hoy){
							$(this).val("");
							alert("La Fecha de Pago no puede ser menor al día de Hoy");
						}
					}
				});*/

				$.each(response.data.body, function(index, item){
					var tr = "";
					$.each(item, function(i, el) {
						tr += "<td>"+el+"</td>";
					});

					$("#ordertabla >tbody").append('<tr class="even">'+tr+'</tr>');
					row++;
				});

				var tr = "";
				$.each(response.data.footer, function(ix, element){
					tr += "<td style='color:green;font-weight:bold;'>"+element+"</td>";
				});

				$("#ordertabla >tbody").append('<tr class="even"><td colspan="8"></td></tr>');
				$("#ordertabla >tfoot").append('<tr id="trTotales" class="even">'+tr+'</tr>');

				if(response.data.body.length > 0){
					showBtnCorte();
				}
				else{
					hideBtnCorte();
				}
			}
			else{
				if($("#fecha11").length){
					$("#fecha11").unbind('blur');
					$("#formFiltros div[class='form-group']").last().fadeOut().remove();
				}
				$("#ordertabla >tbody").append($("<tr><td colspan='9'>No se encontraron resultados</td></tr>"));
			}
		},
		"json"
	);
}

function showBtnCorte(){
	if($('#btnCrearCorte').length == 0){
		$('#ordertabla').after('<button class="btn btn-xs btn-info pull-right" style="margin-top: 10px; margin-left: 20px;" onclick="crearCorte()" id="btnCrearCorte"> Crear Corte </button>')
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

	var params = getParams($('#formFiltros').serialize());

	if(params.idProveedor == undefined || params.idProveedor <= 0 || params.idProveedor == ""){
		alert("Seleccione Proveedor");return false;
	}

	if(params.idConfiguracion == undefined || params.idConfiguracion <= 0 || params.idConfiguracion == ""){
		alert("Seleccione Tipo de Corte");return false;
	}

	if(params.fecha1 == undefined || params.fecha1 == ""){
		alert("Seleccione Fecha de Inicio"); return false;
	}
	else{
		if(!isDate(params.fecha1)){
			alert("Seleccione una Fecha de Inicio V\u00E1lida");
		}
	}

	if(params.fecha2 == undefined || params.fecha2 == ""){
		alert("Seleccione Fecha Final");return false;
	}
	else{
		if(!isDate(params.fecha2)){
			alert("Seleccione una Fecha Final V\u00E1lida");
		}
	}

	if(params.fecha2 < params.fecha1){
		alert("La Fecha de Inicio debe ser menor o igual a la Fecha Final");return false;
	}

	var fechaPago = $("#fecha11").val();
	if(!isDate(fechaPago)){
		alert("Seleccione una fecha de Pago V\u00E1lida");
		return false;
	}

	//obtener el numero de registros encontrados
	var regs = $('#totalreg').val();
	// Si se encontraron resultados se crea el corte
	if(regs > 0){
		var valores = new Array();

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

function isDate(txtDate)
{
	var currVal = txtDate;
	if(currVal == '')
		return false;

	var rxDatePattern = /^(\d{4})(-)(\d{2})(-)(\d{2})$/;
	var dtArray = currVal.match(rxDatePattern);

	if (dtArray == null) 
		return false;

	dtMonth	= dtArray[3];
	dtDay	= dtArray[5];
	dtYear	= dtArray[1];        

	if(dtMonth < 1 || dtMonth > 12){
		return false;
	}
	else if (dtDay < 1 || dtDay> 31){
		return false;
	}
	else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31){
		return false;
	}
	else if (dtMonth == 2){
		var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		if(dtDay > 29 || (dtDay ==29 && !isleap)){
			return false;
		}
	}
	return true;
}