function initPwd(){

	initValidacion();

	function initValidacion(){
		$('#txtSPwd').alphanum({
			allowSpace         : false,
			allowOtherCharSets : false
		});

		$('#txtSPwd').on('keyup', function(e){
			if(e.keyCode == 13){
				var pwd = $('#txtSPwd').val();

				if(pwd == undefined || pwd == ''){
					alert('Es necesaria una contraseña para continuar');
					return false;
				}	

				validarpwd(pwd);
			}

		})

		$('#btnEntrar').on('click', function(e){
			var pwd = $('#txtSPwd').val();

			if(pwd == undefined || pwd == ''){
				alert('Es necesaria una contraseña para continuar');
				return false;
			}
			
			validarpwd(pwd);
		});

	}

	function validarpwd(pwd){
		$.ajax({
			url			: '../../inc/Ajax/_Proveedores/Telcel/validarpwd.php',
			type		: 'POST',
			dataType	: 'json',
			data		: {
				pwd	: pwd
			},
		})
		.done(function(resp){
			if(resp.bExito == false){
				alert(resp.sMensaje);
			}
			else{
				showTblProveedores();
			}
		})
		.fail(function() {
			console.log("error");
		});
		
	}

	function showTblProveedores(){
		$.ajax({
			url			: '../../inc/Ajax/_Proveedores/Telcel/showTblProveedores.php',
			type		: 'POST',
			dataType	: 'json'
		})
		.done(function(resp){
			if(resp.bExito == true){

				var tbl = initTbl();

				$('.panel-tbl-proveedores').html(tbl);
				var rows = armarRows(resp.data);
				$('.panel-tbl-proveedores table').append(rows);
				llenarCombosProveedores(resp.data);

				initBtnGuardar();
			}
		})
		.fail(function(){
			console.log("error");
		});
		
	}

	function initBtnGuardar(){
		$('.btnGuardaProveedor').on('click', function(e){
			guardarCambioProv(e);
		});
	}

	function guardarCambioProv(e){
		var btn		= e.target;
		var input	= $(btn).siblings(':input[name=idProveedor]');
		var td		= $(btn).closest('tr').children()[2];
		var cmb		= $(td).children()[0];

		var nIdProvTmp = $(cmb).val();

		if(nIdProvTmp == undefined || nIdProvTmp == '' || nIdProvTmp <= 0){
			alert('Seleccione Proveedor');
			return false;
		}

		var params = {
			nIdProveedor	: $(input).val(),
			nIdProvTmp		: nIdProvTmp
		}

		$.ajax({
			url			: '../../inc/Ajax/_Proveedores/Telcel/guardarCambioProv.php',
			type		: 'POST',
			dataType	: 'json',
			data		: params,
		})
		.done(function(resp){
			if(resp.bExito == false){
				alert(resp.sMensaje);
			}
			else{
				showTblProveedores();
			}
		})
		.fail(function(){
			console.log("error");
		});
		
	}

	function initTbl(){
		var tbl = '<table class="table table-bordered" width="100%" id="tbl-proveedores">';
		tbl += '<tr>';
		tbl += '<th width="25%" style="padding:10px;">Nombre Proveedor</th>';
		tbl += '<th width="25%" style="padding:10px;">Proveedor Temporal</th>';
		tbl += '<th width="25%" style="padding:10px;" align="center">Asignar Proveedor</th>';
		tbl += '<th width="25%" style="padding:10px;" align="center">Guardar</th>';
		tbl += '</tr>';
		tbl += '</table>';

		return tbl;
	}

	function armarRows(drows){
		var numprovs = drows.length;
		var rows

		for(var i=0; i<numprovs; i++){
			var data = drows[i];
			rows += '<tr>';
			rows += '<td width="25%" style="padding:10px;">'+data.nombreProveedor+'</td>';
			rows += '<td width="25%" style="padding:10px;">'+data.nombreProveedorProvisional+'</td>';
			rows += '<td width="25%" align="center">';
			rows += '<select class="form-control cmb-proveedor">';
			rows += '<option>--</option>';
			rows += '</select>';
			rows += '</td>';
			rows += '<td width="25%" align="center">';
			rows += '<button type="button" class="btnGuardaProveedor">Guardar</button>';
			rows += '<input type="hidden" name="idProveedor" value="'+data.idProveedor+'"/>';
			rows += '</td>';
			rows += '</tr>';
		}

		return rows;
	}

	function llenarCombosProveedores(drows){
		var numprovs = drows.length;

		$('.cmb-proveedor').empty();
		var option		= document.createElement("option");
		option.text		= '--';
		option.value	= '-1';
		$('.cmb-proveedor').append(option);

		for(var i=0; i<numprovs; i++){
			var data = drows[i];

			var option		= document.createElement("option");
			option.text		= data.nombreProveedor;
			option.value	= data.idProveedor;
			$('.cmb-proveedor').append(option);
		}
	}
}