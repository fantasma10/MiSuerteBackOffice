//Creacion de Reembolsos

function initComponentsReembolsoManual(){

	$(":input").on('focus', function(ev){
		var id = ev.currentTarget.id;
		$('#'+id).removeClass('invalido');
	});

	$("#txtdescripcion").prop('maxlength', '200');

	cargarStore("../../../inc/Ajax/stores/storeCadenas.php", "ddlCad", {}, {text : 'nombreCadena', value : 'idCadena'}, {}, 'cadenaloaded');

	var checkin = $('#txtfecha').datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(){
		checkin.hide();
	}).data('datepicker');

	if(!ES_ESCRITURA){
		setReadOnly();
	}

	$('#txtdescripcion').alpha({
		allowLatin			: true,
		allowOtherCharSets	: false,
		maxLength			: 45
	});
}

function loadStoreSubCadena(){
	var params = {
		idCadena : $('#ddlCad').val()
	}

	cargarStore("../../../inc/Ajax/stores/storeSubCadenas.php", "ddlSubCad", params, {text : 'nombreSubCadena', value : 'idSubCadena'}, {}, 'subcadenaloaded');
	limpiaStore("ddlCorresponsal");
}

function loadStoreCorresponsal(){
	var params = {
		idCadena	: $('#ddlCad').val(),
		idSubCadena	: $('#ddlSubCad').val()
	}

	cargarStore("../../../inc/Ajax/stores/storeCorresponsales.php", "ddlCorresponsal", params, {text : 'nombreCorresponsal', value : 'idCorresponsal'}, {}, 'corresponsalloaded');
}

function crearReembolsoManual(){

	var parametros = "";

	var idReembolso		= document.getElementById("idReembolso").value;
	var cadena			= document.getElementById("ddlCad").value;
	var subcadena		= document.getElementById("ddlSubCad").value;
	var corresponsal	= document.getElementById("ddlCorresponsal").value;
	var importe			= document.getElementById("txtimporte").value;
	var descripcion		= document.getElementById("txtdescripcion").value;
	var fecha			= txtValue("txtfecha");

	var numCuenta		= document.getElementById('lblnocuenta').innerHTML;

	var errores = 0;

	var error = "";

	if(cadena == -1 && subcadena == -1 && corresponsal == -1){
		errores++;
		error += "-Seleccione Cadena, SubCadena y Corresponsal\n";
	}

	if(numCuenta == '' || numCuenta <= 0 || numCuenta =='No tiene'){
		errores++;
		error += "-El N\u00FAmero de Cuenta es Inv\u00E1lido\n";
	}

	if(importe == '' || importe <= 0 || importe == undefined){
		errores++;
		error += "-El Importe es Inv\u00E1lido\n";
	}

	if(fecha == ''){
		errores++;
		error += "-La Fecha es Inv\u00E1lida\n";
	}

	if(descripcion == ''){
		errores++;
		error += "-La Justificaci\u00F3n es Obligatoria";
	}

	if(errores == 0){
		var parametros= "idReembolso=" + idReembolso + "&cadena="+cadena+"&subcadena="+subcadena+"&corresponsal="+corresponsal+"&importe="+importe+"&descripcion="+descripcion+"&fecha="+fecha;
		var params = getParams(parametros);

		//if(idReembolso == 0){
			$.post(BASE_PATH + "/inc/Ajax/_Contabilidad/ReembolsoManual.php",
				params,
				function(response){
					if(showMsg(response)){
						alert(response.msg);
					}
					else{
						alert(response.msg);
					}
					if(idReembolso == 0){
						/*if(response.success == true){*/
							$("#formReembolsos").get(0).reset();
							$("#idReembolso").val(0);
							$("#lblnocuenta").html("");
							$("#cantforelo").html("");
							$("#cantforelo, #lblnocuenta").empty("");
						/*}*/
						//location.reload();
					}
					else{
						buscarReembolsos();
					}
				},
				'json'
			);
		/*}
		else{
			alert("Editar el Reembolso");
		}*/
	}else{
		alert(error);
	}
	
}

function setReadOnly(){
	$('#htmlContent :input').prop('disabled', true);
}

function eliminarReembolso(idReembolso, event){
	event.preventDefault();

	if(confirm("\u00BFDesea Eliminar el Reembolso?")){
		$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/eliminarReembolso.php',
			{
				idReembolso : idReembolso
			},
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(reloadPage(response)){
					buscarReembolsos();
				}
			},
			'json'
		);
	}
}

function editarReembolso(idCorte){
	event.preventDefault();
	$("#corner").html("Editar Reembolso");
	cargarContenidoHtml(BASE_PATH  + '/_Contabilidad/Pagos/Reembolsos/pantallaCrear.php', 'divTbl', 'initComponentsReembolsoManual();iniciaEditarReembolso(' + idCorte + ')');
}

function iniciaEditarReembolso(idCorte){

	$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/cargarReembolso.php',
		{
			idCorte : idCorte
		},
		function(response){
			$('#ddlCad').on('cadenaloaded', function(){
				$('#ddlCad').val(response.data.ddlCad);
				document.getElementById('lblnocuenta').innerHTML = response.data.numCuenta;
				document.getElementById('cantforelo').innerHTML = response.data.saldoCuenta;
			});

			$('#ddlSubCad').on('subcadenaloaded', function(){
				$('#ddlSubCad').val(response.data.ddlSubCad);
				$('#ddlSubCad').attr('disabled', false);
				loadStoreCorresponsal();
				document.getElementById('lblnocuenta').innerHTML = response.data.numCuenta;
				document.getElementById('cantforelo').innerHTML = response.data.saldoCuenta;
			});

			$('#ddlCorresponsal').on('corresponsalloaded', function(){
				$('#ddlCorresponsal').val(response.data.ddlCorresponsal);
				$('#ddlCorresponsal').attr('disabled', false);
				document.getElementById('lblnocuenta').innerHTML = response.data.numCuenta;
				document.getElementById('cantforelo').innerHTML = response.data.saldoCuenta;
			});

			$("body").on("doneFill", function(){
				console.log($("#lblnocuenta"), response.data.numCuenta);
				document.getElementById('lblnocuenta').innerHTML = response.data.numCuenta;
				document.getElementById('cantforelo').innerHTML = response.data.saldoCuenta;
			});

			fillFieldsChange(response.data, '');
			
		},
		'json'
	);

	$('#lblbtn').empty().html("Guardar Cambios");
	$('#btnCreaEditaReembolso').unbind('click');
	$('#btnCreaEditaReembolso').removeAttr('onclick');
	$('#btnCreaEditaReembolso').bind('click', function(){
		crearReembolsoManual();
	});
}

function editaReembolso(){
	var params = getParams($('#formCrearReembolso').serialize());


	var idCorte = params.idReembolso;
	if(idCorte != undefined && idCorte > 0){

	}
	else{
		alert("No es posible Actualizar el Reembolso, es necesario cargarlo de nuevo");
	}

}

function isFormValid(idForm){
	var form = $('#' + idForm);

	$.each(form[0], function(index, item){
		var allowBlank = $(item).attr('allowBlank');
		var type = item.type;
		var value = $(item).val();
		value = value.trim();

		var seguir = true;

		switch(type){
			case 'hidden':
				if(value != '' && value > 0){seguir = true;}else{seguir = false;}
			break;

			case 'text':
				if(value != ''){seguir = true;}else{seguir = false;}
			break;

			case 'select-one':
				if(value >= 0){seguir = true;}else{seguir = false;}
			break;
		}

		if(allowBlank == "false" && seguir == false){
			console.log(item.id);
			$("#" + item.id).addClass('invalido');
		}
		console.log(allowBlank, type, value, seguir);
	});
}