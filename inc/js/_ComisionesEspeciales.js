
$(function(){
	$(":input").bind('paste', function(){return false;});

	$(":input").numeric();

	$(".importesCom").attr('maxlength', '18');
	
	$(".perCom").attr('maxlength', '6');

	$("#impComEspecial").attr('maxlength', '6');

	$(".perCom, #impComEspecial").change(function(e){
		var valor = this.value;
		if(valor > 99.999){
			var targ	= e.target;
			var id		= targ.id;

			$("#"+id).val(99.999);
		}
	});

	// solo se puede guardar importe o porcentaje de comision, si escribe importe de comision entonces el porcentaje se hace 9 y viceversa
	/*$(".importesCom, .perCom").keyup(function(e){
		var targ	= e.target;
		var id		= targ.id;
		var tip 	= id.substring(0, 3);
		var last	= id.substring(3, id.length);

		var val = $("#"+id).val();
		var valor = val.trim();

		var arr = {'per' : 'imp', 'imp' : 'per'};

		if(valor != "" && valor > 0){
			$("#" +arr[tip] + last).val('0.00');
		}
	});*/

	$("#btnGuardarComisiones").click(guardarComisiones);
});

function regresaA(url, idCadena, idSubCadena, idCorresponsal){
	submitFormPost(url, {idCadena : idCadena, idSubCadena : idSubCadena, idCorresponsal : idCorresponsal});
}

function eliminarPermisos(idPermiso){
	var params = {
		idPermiso	: idPermiso,
	}

	$.post("../inc/Ajax/_ComisionesEspeciales/deletePreComision.php", params,
		function(response){
			if(showMsg(response)){
				alert(response.msg);
			}
			else{
				var idCadena		= $("#idCadena").val();
				var idSubCadena		= $("#idSubCadena").val();
				var idCorresponsal	= $("#idCorresponsal").val();
				var idVersion		= $("#idVersion").val();

				cargaTabla(idCadena, idSubCadena, idCorresponsal);
				cargaComboProductos(idVersion, idCadena, idSubCadena, idCorresponsal);
			}
		},
		"json"
	)
}

function editarPermisos(idPermiso){
	var params = {
		idPermiso	: idPermiso,
	}

	//showPanels();

	loadForm("../inc/Ajax/_ComisionesEspeciales/getComision.php", params, '', '');
}

function cargaComboProductos(idVersion, idCadena, idSubCadena, idCorresponsal){
	$.post("../inc/Ajax/_ComisionesEspeciales/comboProductosPre.php",
	{
		idVersion	: idVersion,
		idCadena	: idCadena,
		idSubCadena	: idSubCadena,
		idCorresponsal	: idCorresponsal
	}, function(response){
		$("#divComboProducto").html(response);
	});
}

function guardarComisiones(){
	var items = $("#formComisiones :input");
	var params = {}

	$("#formComisiones").find(':input').each(function(){
		var elemento = this;
		params[elemento.id] = elemento.value;
	});

	if(!params.idPermiso || params.idPermiso == 0){
		if(params.idSubCadena == -1){
			prioridad = 2;
		}

		if(params.idCorresponsal > 0){
			prioridad = 3;
		}
		params['prioridad'] = prioridad;
	}

	var fn = 'cargaTabla('+params.idCadena+','+params.idSubCadena+', '+params.idCorresponsal+');hidePanels();cargaComboProductos('+params.idVersion+','+params.idCadena+','+params.idSubCadenaR+','+params.idCorresponsalR+');';
	fn += 'cargaComboProductos('+params.idVersion+', '+params.idCadena+', '+params.idSubCadena+', '+params.idCorresponsal+');';
	submitForm('../inc/Ajax/_ComisionesEspeciales/guardaComision.php', params, fn);
}

function muestraDivParent(){
	$(".divShowTablaParent").show();
}

function cargaTabla(idCadena, idSubCadena, idCorresponsal){
	$.post("../inc/Ajax/_ComisionesEspeciales/getPreComisiones.php",
	{
		idCadena		: idCadena,
		idSubCadena		: idSubCadena,
		idCorresponsal	: idCorresponsal
	},
	function(response){
		if(response != ""){
			$("#divShowTabla").html(response);
			$(".divShowTablaParent").show();
		}
		else{
			$("#divShowTabla").html(response);
			$(".divShowTablaParent").hide();	
		}
	})
}

function cargaComision(idGrupo, idVersion, idCadena, idSubCadena, idCorresponsal){
	var idProducto = $("#ddlProducto").val();

	$("#idProducto").val(idProducto);

	if(idProducto == "" || idProducto == -1){
		alert("Seleccine un Producto");
		return false;
	}

	if(idSubCadena == -1){
		prioridad = 2;
	}

	if(idCorresponsal > 0){
		prioridad = 3;
	}

	var params = {
		idVersion	: idVersion,
		idGrupo		: idGrupo,
		idCadena	: idCadena,
		idSubCadena	: idSubCadena,
		idPrioridad	: prioridad,
		idProducto	: idProducto
	}

	loadForm("../inc/Ajax/_ComisionesEspeciales/getComision.php", params, showPanels);
}

function showPanels(){
	$(".divInvisible").show();
}

function hidePanels(){
	$(".divInvisible").hide();
}

function loadForm(url, params, functionDone, functionResp){
	$.post(url,
	params,
	function(response){
		if(showMsg(response)){
			alert(response.msg);
			hidePanels();
		}
		else{
			showPanels();
			$.each(response.data, function(index, val){
				if($("#"+index).length){
					$("#"+index).val(val);	
				}
			});
		}
	}, "json");
}

function submitForm(url, params, functionResp){
	$.post(url,
	params,
	function(response){
		if(showMsg(response)){
			alert(response.msg);
		}
		else{
			eval(functionResp);
		}
	}, "json");
}