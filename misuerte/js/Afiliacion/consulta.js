$( document ).ready(function() {
	var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
	"oLanguage": {
		"sZeroRecords": "No se encontraron registros",
		"sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sSearch": "Buscar:"  ,
		"sInfoFiltered": " - filtrado de _MAX_ registros",
		"oPaginate": {
			"sNext": "Siguiente",
			"sPrevious": " Anterior"
		}
	},
	"bSort" :false
	};

$("#nombreComercial").alphanum({
	allow				: '-',
	allow				: '.',
	allowNumeric		: true,
	allowOtherCharSets	: true,
	maxLength			: 50
});
$("#beneficiario").alphanum({
	allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
	allowNumeric		: false,
	allowOtherCharSets	: false,
	maxLength			: 100
});

$("#telefono").prop('maxlength', 10);	
$('#telefono').mask('(00) 0000-0000');

$("#correo").alphanum({
	allow				: '-.@_',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 120
});

$("#comision").prop('maxlength', 6);
$("#comision").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#liquidacion").prop('maxlength', 6);
$("#liquidacion").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#perComision").prop('maxlength', 6);
$("#perComision").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#clabe").prop('maxlength', 18);
$("#clabe").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referencia").prop('maxlength', 10);
$("#referencia").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referenciaAlfa").alphanum({
	allow				: '-',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 20
});	

$("#nombreComercialCadena").alphanum({
	allow				: '-',
	allow				: '.',
	allowNumeric		: true,
	allowOtherCharSets	: true,
	maxLength			: 50
});
$("#beneficiarioCadena").alphanum({
	allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
	allowNumeric		: false,
	allowOtherCharSets	: false,
	maxLength			: 100
});

$("#telefonoCadena").prop('maxlength', 10);	
$('#telefonoCadena').mask('(00) 0000-0000');

$("#correoCadena").alphanum({
	allow				: '-.@_',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 120
});	


$("#comisionCadena").prop('maxlength', 6);
$("#comisionCadena").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#liquidacionCadena").prop('maxlength', 6);
$("#liquidacionCadena").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#perComisionCadena").prop('maxlength', 6);
$("#perComisionCadena").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});


$("#clabeCadena").prop('maxlength', 18);
$("#clabe").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referenciaCadena").prop('maxlength', 10);
$("#referencia").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referenciaAlfaCadena").alphanum({
	allow				: '-',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 20
});



//Carga de Datos de los emisores
tablaProveedor = "";
getClientes();
function getClientes(){
		$.post("../../../misuerte/ajax/Afiliacion/consulta.php",{
			tipo:1
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);
					jQuery.each(obj, function(index,value) {

						estatus = obj[index]['estatus'];
						nombre = obj[index]['nombre'];



						$('#ordertablaE tbody').append('<tr><td>'+obj[index]['nombre']+'</td>'+
							'<td style="text-align:center;">'+obj[index]['retencion']+'</td>'+
							'<td style="text-align:right;">'+obj[index]['liquidacion']+'</td>'+
							'<td style="text-align:right;"> $'+obj[index]['comision']+'</td>'+
							'<td style="text-align:center;"> %'+(obj[index]['porcentajeComision']*100)+'</td>'+
							'<td style="width: 13%!important;"><button id="verProveedor" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn habilitar btn-default btn-xs" data-id='+obj[index]['id']+' data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							'</td></tr>');
					});
					$("[rel=tooltip]").tooltip();
					tablaProveedor = $("#ordertablaE").DataTable(settings);	
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})

//Carga de Datos de las Cadenas

		$.post("../../../misuerte/ajax/Afiliacion/consulta.php",{
			tipo: 2
		},
		function(response){		
			var obj = jQuery.parseJSON(response);
					//console.log(obj);
					jQuery.each(obj, function(index,value) {

						estatus = obj[index]['estatus'];
						nombre = obj[index]['nombre'];


						$('#ordertablaR tbody').append('<tr><td>'+obj[index]['nombre']+'</td>'+
							'<td style="text-align:center;">'+obj[index]['retencion']+'</td>'+
							'<td style="text-align:right;">'+obj[index]['liquidacion']+'</td>'+
							'<td style="text-align:right;"> $'+obj[index]['comision']+'</td>'+
							'<td style="text-align:center;"> %'+(obj[index]['porcentajeComision']*100)+'</td>'+
							'<td style="width: 13%!important;"><button data-id='+obj[index]['id']+' id="verCliente" data-placement="top" rel="tooltip" title="Ver Informacion" class="btn btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							'</td></tr>');
					});	
					$("[rel=tooltip]").tooltip();	
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
	}


//Switcheo de tablas

$("#proveedor").click(function () {
	var clase = $("#proveedor").hasClass("active").toString();
	if(clase != "true"){
		$("#proveedor").addClass("active");
		$("#cliente").removeClass("active");
		document.getElementById("clienteInfo").style.display="none"; 
		var tablaReceptor = $("#ordertablaR").DataTable();
		tablaReceptor.fnDestroy();
		var tablaProveedor = $("#ordertablaE").DataTable(settings);
		$( "#cliente" ).prop( "checked", false );
		tabla="#ordertablaE #E tr";
		document.getElementById("ordertablaR").style.display="none";
		document.getElementById("tablaProveedores").style.display="inline";
		document.getElementById("tablaReceptores").style.display="none";
		document.getElementById("ordertablaE").style.width="100%";
		document.getElementById("ordertablaE").style.display="inline-table";
	}	
});

$("#cliente").click(function () {	
	var clase = $("#cliente").hasClass("active").toString();
	if(clase != "true"){ 
		$("#cliente").addClass("active");
		$("#proveedor").removeClass("active");
		document.getElementById("proveedorInfo").style.display="none";
		$( "#proveedor" ).prop( "checked", false );
		tablaProveedor.fnDestroy();
		var tablaReceptor = $("#ordertablaR").DataTable(settings);
		tabla="#ordertablaR #R tr";
		document.getElementById("ordertablaE").style.display="none";
		document.getElementById("tablaProveedores").style.display="none";
		document.getElementById("tablaReceptores").style.display="inline";
		document.getElementById("ordertablaR").style.display="inline-table";
		document.getElementById("ordertablaR").style.width="100%";
	}
	});

});

// ver informacion del emisor
$(document).on('click', '#verProveedor',function (e) {
	var id = $(this).data("id");
	$("#proveedorId").val(id);
	tipo = 3;
	cargaDatosProveedor(id,tipo);
	document.getElementById("clienteInfo").style.display="none";
	document.getElementById("proveedorInfo").style.display="block";

	$("#nombreComercial").addClass("lectura");
	$("#beneficiario").addClass("lectura");
	$("#telefono").addClass("lectura");
	$("#correo").addClass("lectura");
	$("#comision").addClass("lectura");
	$("#perComision").addClass("lectura");
	$("#liquidacion").addClass("lectura");
	$("#retencion").addClass("lectura");
	$("#clabe").addClass("lectura");
	$("#referencia").addClass("lectura");
	$("#referenciaAlfa").addClass("lectura");
	$("#pagoComisiones").addClass("lectura");

	$("#host").addClass("lectura");
	$("#port").addClass("lectura");
	$("#user").addClass("lectura");
	$("#password").addClass("lectura");
	$("#remoteFolder").addClass("lectura");
	$("#folderLocal").addClass("lectura");
	$("#fileName").addClass("lectura");
	$("#fileExtension").addClass("lectura");

	$("#host").prop('readonly', true);
	$("#port").prop('readonly', true);
	$("#user").prop('readonly', true);
	$("#password").prop('readonly', true);
	$("#remoteFolder").prop('readonly', true);
	$("#folderLocal").prop('readonly', true);
	$("#fileName").prop('readonly', true);
	$("#fileExtension").prop('readonly', true);

	$("#pagoComisiones").prop('readonly', true);

	$("#nombreComercial").prop('readonly', true);
	$("#beneficiario").prop('readonly', true);
	$("#telefono").prop('readonly', true);
	$("#correo").prop('readonly', true);
	$("#comision").prop('readonly', true);
	$("#perComision").prop('readonly', true);
	$("#liquidacion").prop('readonly', true);
	$("#retencion").prop('readonly', true);
	$("#clabe").prop('readonly', true);
	$("#referencia").prop('readonly', true);
	$("#referenciaAlfa").prop('readonly', true);
	$("#retencion").prop('disabled', true);

	if(ID_PERFIL == 1 || ID_PERFIL == 5){
		$('#edicion').empty();
		botonEdicion = '<button class="btn btn-xs btn-info " data-id='+id+' id="editProveedor" style="margin-right: 16px; margin-bottom: 10px;"><span class="fa fa-pencil"></span> Editar</button>';
		$('#edicion').append(botonEdicion);
	}

	$('html,body').animate({
    		scrollTop: $("#proveedorInfo").offset().top
	}, 2000);
});


//Edicion de Emisor//
$(document).on('click', '#editProveedor',function (e) {
	var id = $(this).data("id");
	$("#proveedorId").val(id);
	document.getElementById("clienteInfo").style.display="none";
	document.getElementById("proveedorInfo").style.display="block";
	$("#nombreComercial").removeClass("lectura");
	$("#beneficiario").removeClass("lectura");
	$("#telefono").removeClass("lectura");
	$("#correo").removeClass("lectura");
	$("#comision").removeClass("lectura");
	$("#perComision").removeClass("lectura");
	$("#liquidacion").removeClass("lectura");
	$("#retencion").removeClass("lectura");
	$("#clabe").removeClass("lectura");
	$("#referencia").removeClass("lectura");
	$("#referenciaAlfa").removeClass("lectura");
	$("#pagoComisiones").removeClass("lectura");

	$("#host").removeClass("lectura");
	$("#port").removeClass("lectura");
	$("#user").removeClass("lectura");
	$("#password").removeClass("lectura");
	$("#remoteFolder").removeClass("lectura");
	$("#folderLocal").removeClass("lectura");
	$("#fileName").removeClass("lectura");
	$("#fileExtension").removeClass("lectura");

	$("#pagoComisiones").prop('readonly', false);
	$("#host").prop('readonly', false);
	$("#port").prop('readonly', false);
	$("#user").prop('readonly', false);
	$("#password").prop('readonly', false);
	$("#remoteFolder").prop('readonly', false);
	$("#folderLocal").prop('readonly', false);
	$("#fileName").prop('readonly', false);
	$("#fileExtension").prop('readonly', false);

	$("#nombreComercial").prop('readonly', false);
	$("#beneficiario").prop('readonly', false);
	$("#telefono").prop('readonly', false);
	$("#correo").prop('readonly', false);
	$("#comision").prop('readonly', false);
	$("#perComision").prop('readonly', false);
	$("#liquidacion").prop('readonly', false);
	$("#retencion").prop('readonly', false);
	$("#clabe").prop('readonly', false);
	$("#referencia").prop('readonly', false);
	$("#referenciaAlfa").prop('readonly', false);
	$("#retencion").prop('disabled', false);


	if(ID_PERFIL == 1){

		$('#tokenDiv').empty();
		boton ='<button id="nuevoToken" class="btn btn-default btn-xs"><span class="fa fa-refresh"></span>Generar Nuevo Token</button>';
		$('#tokenDiv').append(boton);

	}
	$('html,body').animate({
    		scrollTop: $("#proveedorInfo").offset().top
	}, 2000);
});

$(document).on('click', '#nuevoToken',function (e) {

		var token = $("#rfc").val();
		$.post("../../paycash/ajax/Afiliacion/consultaClientes.php",{
			token : token,
			tipo:9
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			$("#token").val(obj.token);
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})

});



//Carga de la informacion del proveedor
function cargaDatosProveedor(id,tipo){
$.post("../../misuerte/ajax/Afiliacion/consulta.php",{
			id : id,
			tipo:tipo
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			console.log(obj);
			if(obj.length == 0){
				alert("No se encontro informacion");
				document.getElementById("proveedorInfo").style.display="none";
				var inputs = document.getElementsByTagName("input");
				for(var i=0;i<inputs.length;i++){
					inputs[i].value = "";
				}
			}else{
				jQuery.each(obj, function(index,value) {
					$("#nombreComercial").val(obj[index]['nombreComercial']);
					$("#razonSocial").val(obj[index]['razonSocial']);
					$("#rfc").val(obj[index]['rfc']);
					$("#beneficiario").val(obj[index]['beneficiario']);
					$("#telefono").val(obj[index]['telefono']);
					$("#correo").val(obj[index]['correo']);
					$("#comision").val(obj[index]['comision']);
					$("#liquidacion").val(obj[index]['liquidacion']);
					$("#pagoComisiones").val(obj[index]['comisiones']);
					$("#perComision").val(obj[index]['porcentajeComision']*100	);
					$("#clabe").val(obj[index]['clabe']);
					$("#retencion").val(obj[index]['retencion']);
					$("#txtCalle").val(obj[index]['calle']);
					$("#int").val(obj[index]['numeroInterior']);
					$("#ext").val(obj[index]['numeroExterior']);
					$("#txtCP").val(obj[index]['codigoPostal']);
					$("#cmbColonia").val(obj[index]['colonia']);
					$("#cmbEstado").val(obj[index]['estado']);
					$("#tipoEmisor").val(obj[index]['tipoEmisor']);
					$("#cmbMunicipio").val(obj[index]['municipio']);
					$("#referencia").val(obj[index]['numerica']);
					$("#referenciaAlfa").val(obj[index]['alfanumerica']);
					$("#cuentaContable").val(obj[index]['cuentaContable']);

					$("#host").val(obj[index]['host']);
					$("#port").val(obj[index]['port']);
					$("#user").val(obj[index]['user']);
					$("#password").val(obj[index]['pass']);
					$("#remoteFolder").val(obj[index]['folderRemote']);
					$("#folderLocal").val(obj[index]['localFolder']);
					$("#fileName").val(obj[index]['file']);
					$("#fileExtension").val(obj[index]['extension']);				
					analizarCLABE2(obj[index]['clabe']);
			});
			}
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}


//Guardado de datos editados//
$(document).on('click', '#actualizarProveedor',function (e) {

	var correo = $("#correo").val();
	validacionCorreo = validar_email(correo);
   
	var nombreComercial = $("#nombreComercial").val();
	var beneficiario = $("#beneficiario").val();
	var telefono = $("#telefono").val();
	var correo = $("#correo").val();
	var comision = $("#comision").val();
	var perComision = $("#perComision").val();
	var liquidacion = $("#liquidacion").val();
	var retencion = $("#retencion option:selected").val();
	var clabe = $("#clabe").val();
	var referencia = $("#referencia").val();
	var referenciaAlfa = $("#referenciaAlfa").val();
	var idBanco = $("#banco").val();
	var idProveedor = $("#proveedorId").val();

	var host = $("#host").val();
	var port = $("#port").val();
	var user = $("#user").val();
	var password = $("#password").val();
	var remoteFolder = $("#remoteFolder").val();
	var folderLocal = $("#folderLocal").val();
	var fileName = $("#fileName").val();
	var fileExtension = $("#fileExtension").val();
	var pagoComisiones = $("#pagoComisiones").val();

	if(perComision != 0){
		perComision = perComision / 100;
	}else{
		perComision = 0;
	}

	var lack = "";
	var error = "";

	if(nombreComercial == undefined || nombreComercial.trim() == '' || nombreComercial <= 0){
		lack +='Nombre Comercial\n';
	}

	if(beneficiario == undefined || beneficiario.trim() == '' || beneficiario <= 0){
		lack +='Beneficiario\n';
	}

	if(telefono == undefined || telefono.trim() == '' ){
		lack +='Telefono\n';
	}

	if(correo == undefined || correo.trim() == '' ){
		lack +='Correo\n';
	}

	if(comision == undefined || comision.trim() == '' ){
		lack +='Comision\n';
	}


	if(liquidacion == undefined || liquidacion.trim() == '' || liquidacion <= 0){
		lack +='Dias para liquidar pagos\n';
	}


	if(clabe == undefined || clabe.trim() == '' || clabe <= 0){
		lack +='Cuenta CLABE\n';
	}


	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		jAlert(black + '\n' + lack+'\n' );
		event.preventDefault();
	}
	else{
		analizar = analizarCLABE2(clabe);
		if(validacionCorreo == false){
			jAlert('El correo no es valido');
		}else{
			if(analizar == true){
				var $this = $(this);
				$this.button('loading');

		$.post("../../misuerte/ajax/Afiliacion/consulta.php",{
			nombreComercial : nombreComercial,
			beneficiario : beneficiario,
			telefono : telefono,
			correo : correo,
			comision : comision ,
			liquidacion : liquidacion,
			clabe : clabe,
			retencion : retencion,
	 		referencia: referencia,
	 		referenciaAlfa: referenciaAlfa,
	 		banco: idBanco,
	 		perComision : perComision,
	 		idProveedor : idProveedor,
	 		host : host,
			port : port,
			user : user,
			password : password,
			remoteFolder : remoteFolder,
			folderLocal : folderLocal,
			fileName : fileName ,
			fileExtension : fileExtension,
			pagoComisiones : pagoComisiones,
			tipo: 4
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			if(obj.showMessage == 500){
				jAlert(obj.msg);
				$this.button('reset');
			}else{
				jAlert(obj.sMensaje);
				setTimeout("location.reload()", 3000);
			}
		})
		.fail(function(response){
				$this.button('reset');
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
		}else{
			jAlert('La CLABE escrita es incorrecta. Favor de verificarla');
		}
	  }
	}
});



//Inhabilitar Emisor
$(document).on('click', '#confirmacionBorradoProveedor',function (e) {
		var id = $(this).data("id");
		$("#proveedorId").val(id);
		$("#estatusEmisor").val(1);
		$('#confirmacion p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea Borrar este emisor :" +nombre;
		$('#confirmacion p').append(texto);
});

$(document).on('click', '#confirmacionHabilitarEmisor',function (e) {
		var id = $(this).data("id");
		$("#proveedorId").val(id);
		$("#estatusEmisor").val(0);
		$('#confirmacion p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea Habilitar este emisor :" +nombre;
		$('#confirmacion p').append(texto);
});

$(document).on('click', '#borrarEmisor',function (e) {
		var $this = $(this);
		$this.button('loading');
		id = $("#proveedorId").val();
		estatus = $("#estatusEmisor").val();
		actualizaEstatus(id,estatus);
});


//Actualizacion de estatus del emisor
function actualizaEstatus(id,estatus){
	$.post("../../paycash/ajax/Afiliacion/consultaClientes.php",{
			idEmisor : id,
			estatus : estatus,
			tipo: 5
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			if(obj.showMessage == 500){
				jAlert(obj.msg);
				$("#borrarEmisor").button('reset');
			}else{
				jAlert(obj.sMensaje);
				setTimeout("location.reload()", 3000);
			}
		})
		.fail(function(response){
		$("#borrarEmisor").button('reset');
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}

//Ver datos de la cadena
$(document).on('click', '#verCliente',function (e) {
	var id = $(this).data("id");
	$("#clienteId").val(id);
	tipo = 6;
	cargaDatosCliente(id,tipo);
	document.getElementById("clienteInfo").style.display="block";
	document.getElementById("proveedorInfo").style.display="none";

	$("#nombreComercialCadena").addClass("lectura");
	$("#beneficiarioCadena").addClass("lectura");
	$("#numSocio").addClass("lectura");
	$("#liquidacionComisiones").addClass("lectura");
	$("#telefonoCadena").addClass("lectura");
	$("#correoCadena").addClass("lectura");
	$("#comisionCadena").addClass("lectura");
	$("#perComisionCadena").addClass("lectura");
	$("#liquidacionCadena").addClass("lectura");
	$("#retencionCadena").addClass("lectura");
	$("#clabeCadena").addClass("lectura");
	$("#referenciaCadena").addClass("lectura");
	$("#referenciaAlfaCadena").addClass("lectura");
	
	$("#nombreComercialCadena").prop('readonly', true);
	$("#beneficiarioCadena").prop('readonly', true);
	$("#numSocio").prop('readonly', true);
	$("#liquidacionComisiones").prop('readonly', true);
	$("#telefonoCadena").prop('readonly', true);
	$("#correoCadena").prop('readonly', true);
	$("#comisionCadena").prop('readonly', true);
	$("#perComisionCadena").prop('readonly', true);
	$("#liquidacionCadena").prop('readonly', true);
	$("#retencionCadena").prop('readonly', true);
	$("#clabeCadena").prop('readonly', true);
	$("#referenciaCadena").prop('readonly', true);
	$("#referenciaAlfaCadena").prop('readonly', true);
	$("#retencionCadena").prop('disabled', true);


	if(ID_PERFIL == 1 || ID_PERFIL == 5){
		$('#edicionCadena').empty();
		botonEdicion = '<button class="btn btn-xs btn-info " data-id='+id+' id="editCadena" style="margin-right: 16px; margin-bottom: 10px;"><span class="fa fa-pencil"></span> Editar</button>';
		$('#edicionCadena').append(botonEdicion);
	}


	$('html,body').animate({
    		scrollTop: $("#clienteInfo").offset().top
	}, 2000);
});

// GEneracion de nuevo token para la cadena mismo que se envia por correo
$(document).on('click', '#nuevoTokenCadena',function (e) {

		var token = $("#rfcCadena").val();
		$.post("../../paycash/ajax/Afiliacion/consultaClientes.php",{
			token : token,
			tipo:9
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			$("#tokenCadena").val(obj.token);
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})

});

//Editar datos cadena
$(document).on('click', '#editCadena',function (e) {
	var id = $(this).data("id");
	$("#clienteId").val(id);
	document.getElementById("clienteInfo").style.display="block";
	document.getElementById("proveedorInfo").style.display="none";
	$("#nombreComercialCadena").removeClass("lectura");
	$("#beneficiarioCadena").removeClass("lectura");
	$("#telefonoCadena").removeClass("lectura");
	$("#correoCadena").removeClass("lectura");
	$("#comisionCadena").removeClass("lectura");
	$("#perComisionCadena").removeClass("lectura");
	$("#liquidacionCadena").removeClass("lectura");
	$("#retencionCadena").removeClass("lectura");
	$("#clabeCadena").removeClass("lectura");
	$("#referenciaCadena").removeClass("lectura");
	$("#referenciaAlfaCadena").removeClass("lectura");
	$("#adicionalCadena").removeClass("lectura");
	$("#perAdicionalCadena").removeClass("lectura");
	$("#numSocio").removeClass("lectura");
	$("#liquidacionComisiones").removeClass("lectura");


	$("#numSocio").prop('readonly', false);
	$("#liquidacionComisiones").prop('readonly', false);
	$("#nombreComercialCadena").prop('readonly', false);
	$("#beneficiarioCadena").prop('readonly', false);
	$("#telefonoCadena").prop('readonly', false);
	$("#correoCadena").prop('readonly', false);
	$("#comisionCadena").prop('readonly', false);
	$("#perComisionCadena").prop('readonly', false);
	$("#liquidacionCadena").prop('readonly', false);
	$("#retencionCadena").prop('readonly', false);
	$("#clabeCadena").prop('readonly', false);
	$("#referenciaCadena").prop('readonly', false);
	$("#referenciaAlfaCadena").prop('readonly', false);
	$("#retencionCadena").prop('disabled', false);


	if(ID_PERFIL == 1){

		$('#tokenDivCadena').empty();
		boton ='<button id="nuevoTokenCadena" class="btn btn-default btn-xs"><span class="fa fa-refresh"></span>Generar Nuevo Token</button>';
		$('#tokenDivCadena').append(boton);

	}

	$('html,body').animate({
    		scrollTop: $("#clienteInfo").offset().top
	}, 2000);
});


//Carga de la infromacion de la cadena
function cargaDatosCliente(id,tipo){
$.post("../../misuerte/ajax/Afiliacion/consulta.php",{
			id : id,
			tipo:tipo
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			console.log(obj);
			if(obj.length == 0){
				alert("No se encontro informacion");
				document.getElementById("clienteInfo").style.display="none";
				var inputs = document.getElementsByTagName("input");
				for(var i=0;i<inputs.length;i++){
					inputs[i].value = "";
				}
			}else{
				jQuery.each(obj, function(index,value) {
					$("#nombreComercialCadena").val(obj[index]['nombreComercial']);
					$("#razonSocialCadena").val(obj[index]['razonSocial']);
					$("#rfcCadena").val(obj[index]['rfc']);
					$("#beneficiarioCadena").val(obj[index]['beneficiario']);
					$("#numSocio").val(obj[index]['socio']);
					$("#telefonoCadena").val(obj[index]['telefono']);
					$("#correoCadena").val(obj[index]['correo']);
					$("#comisionCadena").val(obj[index]['comision']);
					$("#liquidacionComisiones").val(obj[index]['pagoComisiones']);
					$("#liquidacionCadena").val(obj[index]['liquidacion']);
					$("#perComisionCadena").val(obj[index]['porcentajeComision']*100);
					$("#clabeCadena").val(obj[index]['clabe']);
					$("#retencionCadena").val(obj[index]['retencion']);
					$("#txtCalleCadena").val(obj[index]['calle']);
					$("#intCadena").val(obj[index]['numeroInterior']);
					$("#extCadena").val(obj[index]['numeroExterior']);
					$("#txtCPCadena").val(obj[index]['codigoPostal']);
					$("#cmbColoniaCadena").val(obj[index]['colonia']);
					$("#cmbEstadoCadena").val(obj[index]['estado']);
					$("#cmbMunicipioCadena").val(obj[index]['municipio']);
					$("#referenciaCadena").val(obj[index]['numerica']);
					$("#referenciaAlfaCadena").val(obj[index]['alfanumerica']);
					$("#cuentaContableCadena").val(obj[index]['cuentaContable']);				
					$("#idAccesoCadena").val(obj[index]['id']);
					analizarCLABE2(obj[index]['clabe']);
			});
			}
		})
		.fail(function(response){
					alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}



//Guardado de datos editados de la cadena//
$(document).on('click', '#actualizarCliente',function (e) {


	var correo = $("#correoCadena").val();
	validacionCorreo = validar_email(correo);
   
	var nombreComercial = $("#nombreComercialCadena").val();
	var beneficiario = $("#beneficiarioCadena").val();
	var telefono = $("#telefonoCadena").val();
	var correo = $("#correoCadena").val();
	var comision = $("#comisionCadena").val();
	var perComision = $("#perComisionCadena").val();
	var comisionAdicional = $("#adicionalCadena").val();
	var pagoComisiones = $("#liquidacionComisiones").val();
	var numSocio = $("#numSocio").val();
	var perComisionAdicional = $("#perAdicionalCadena").val();
	var liquidacion = $("#liquidacionCadena").val();
	var retencion = $("#retencionCadena option:selected").val();
	var clabe = $("#clabeCadena").val();
	var referencia = $("#referenciaCadena").val();
	var referenciaAlfa = $("#referenciaAlfaCadena").val();
	var idBanco = $("#bancoCliente").val();
	var idCliente = $("#clienteId").val();
	
	if(perComision != 0){
		perComision = perComision / 100;
	}else{
		perComision = 0;
	}


	var lack = "";
	var error = "";

	if(nombreComercial == undefined || nombreComercial.trim() == '' || nombreComercial <= 0){
		lack +='Nombre Comercial\n';
	}

	if(beneficiario == undefined || beneficiario.trim() == '' || beneficiario <= 0){
		lack +='Beneficiario\n';
	}

	if(telefono == undefined || telefono.trim() == '' ){
		lack +='Telefono\n';
	}

	if(correo == undefined || correo.trim() == '' ){
		lack +='Correo\n';
	}

	if(comision == undefined || comision.trim() == '' ){
		lack +='Comision\n';
	}


	if(liquidacion == undefined || liquidacion.trim() == '' || liquidacion <= 0){
		lack +='Dias para liquidar pagos\n';
	}

	if(clabe == undefined || clabe.trim() == '' || clabe <= 0){
		lack +='Cuenta CLABE\n';
	}


	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		jAlert(black + '\n' + lack+'\n' );
		event.preventDefault();
	}
	else{
		analizar = analizarCLABE2(clabe);

		if(validacionCorreo == false){
			jAlert('El correo no es valido');
		}else{
			if(analizar == true){
			var $this = $(this);
			$this.button('loading');
		$.post("../../misuerte/ajax/Afiliacion/consulta.php",{
			nombreComercial : nombreComercial,
			beneficiario : beneficiario,
			telefono : telefono,
			correo : correo,
			comision : comision ,
			liquidacion : liquidacion,
			clabe : clabe,
			retencion : retencion,
	 		referencia: referencia,
	 		referenciaAlfa: referenciaAlfa,
	 		banco: idBanco,
	 		perComision : perComision,
	 		idCliente : idCliente,	
	 		pagoComisiones : pagoComisiones,
	 		socio:numSocio,
			tipo: 7
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			if(obj.showMessage == 500){
				jAlert(obj.msg);
				$this.button('reset');
			}else{
				jAlert(obj.sMensaje);
				setTimeout("location.reload()", 3000);
			}
		})
		.fail(function(response){
				$this.button('reset');
				jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
	}else{
			jAlert('La CLABE escrita es incorrecta. Favor de verificarla');
	}
	}
}
});




//Inhabilitar Cadena
$(document).on('click', '#confirmacionBorradoCadena',function (e) {
		var id = $(this).data("id");
		$("#clienteId").val(id);
		$("#estatusCadena").val(1);
		$('#confirmacionCadena p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea inhabilitar esta cadena :" +nombre;
		$('#confirmacionCadena p').append(texto);
});

$(document).on('click', '#confirmacionHabilitarCadena',function (e) {
		var id = $(this).data("id");
		$("#clienteId").val(id);
		$("#estatusCadena").val(0);
		$('#confirmacionCadena p').empty();
		var nombre = $(this).data("name");
		var texto = "Desea Habilitar esta cadena :" +nombre;
		$('#confirmacionCadena p').append(texto);
});

$(document).on('click', '#borrarCadena',function (e) {
		var $this = $(this);
		$this.button('loading');
		id = $("#clienteId").val();
		estatus = $("#estatusCadena").val();
		actualizaEstatusCadena(id,estatus);
});



function actualizaEstatusCadena(id,estatus){
	$.post("../../paycash/ajax/Afiliacion/consultaClientes.php",{
			idCliente : id,
			estatus : estatus,
			tipo: 8
		},
		function(response){
			var obj = jQuery.parseJSON(response);
			if(obj.showMessage == 500){
				jAlert(obj.msg);
				$("#borrarCadena").button('reset');
			}else{
				jAlert(obj.sMensaje);
				setTimeout("location.reload()", 3000);
			}
		})
		.fail(function(response){
		$("#borrarEmisor").button('reset');
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
		})
}

function analizarCLABE(){
	var CLABE = event.target.value;

	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
			).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("#banco").val(banco.bancoID);
					$("#nombreBanco").val(banco.nombreBanco);
					$("#bancoCliente").val(banco.bancoID);
					$("#nombreBancoCliente").val(banco.nombreBanco);
			});
		}
		else{
			jAlert('La CLABE escrita es incorrecta. Favor de verificarla');
			$("[name='banco'], [name='nombreBanco'], [name='numCuenta']").val("");
		}
	}
	else{
		$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");	
	}
}

function analizarCLABE2(clabe){// Analiza la clabe interbancaria cuando llega de la llamada que carga los datos
	var CLABE = clabe;
	var respuesta= "";
	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			respuesta = true;
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
			).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("#banco").val(banco.bancoID);
					$("#nombreBanco").val(banco.nombreBanco);
					$("#bancoCliente").val(banco.bancoID);
					$("#nombreBancoCliente").val(banco.nombreBanco);
			});
		}
		else{
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
			 respuesta = false;
		}
	}
	else{
		$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");	
		respuesta = false;
	}
	return respuesta;
}