$(document).ready(function(){

    $('#closepdf').click(function(){$('#fileViewer').attr('src', ''); $('#pdfvisor').css('display','none')});

    initInputFiles();
    //cargaemisores();

    var maxField = 5; //Limite de inputs para agregar correos
    var addButton = $('.add_button'); //identififcador del boton que agrega los inputs
    var wrapper = $('.field_wrapper'); //contenedor de los inputs
   /* var fieldHTML = '<div class="col-xs-12">'+
    '<input type="text" id="int" class="form-control m-bot15" name="correos" style="width: 300px; display:inline-block;">'+
    '<button  class="remove_button btn btn-sm inhabilitar" id="remove" style="margin-left:3px;width:150px">Quitar  <i class="fa fa-minus-circle" aria-hidden="true"></i></button>'+
					'</div>'; //Nuevo campo para agregar correo
    var x = 1; //Initial field counter is 1

    $(document).on('click', '.add_button', function(e){
        if(x < maxField){ // Chequeo de contador maximo de inputs
            x++; // incremento del contador
            $(wrapper).append(fieldHTML); // Se agrega el campo nuevo para captura de correo
        }
    });
    $(document).on('click', '.remove_button', function(e){ // se remueve el campo de que este a lado del boton
    	e.preventDefault();
    	if (x > 1){
    		$(this).parent('div').remove();
        	x--; // Se decrementa el conteo de campos
        }
    });*/


    $('#p_nIdPais').val(164); //Default México
	var selector = document.getElementById("p_sTelefono");
	$('#p_sTelefono').mask('(00) 0000-0000') ;
	//$('#cuentaContable').mask('000-0000-000');
	$('#p_sNombreEstado, #p_sNombreCiudad, #p_sNombreEstado').prop('disabled', true);

	$("#p_sNombreComercial").alphanum({
		allow				: '-.,',
		allowNumeric		: true,
		allowOtherCharSets	: true,
		maxLength			: 50
	});

	$("#p_sRazonSocial").alphanum({
		allow				: '-.,',
		allowNumeric		: true,
		allowOtherCharSets	: true,
		maxLength			: 50
	});

	$("#p_sRFC").alphanum({
        allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 12
	});
    $("#host,#remoteFolder, #txtColonia, #txtCiudad, #txtEstado ").alphanum({
        allow				: ':-.,/',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 45
	});
    $("#user, #password").alphanum({

		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 45
	});
	$("#p_sRFC").attr('style', 'text-transform: uppercase;');

	$("#p_sNombreContacto").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: false,
		allowOtherCharSets	: false,
		maxLength			: 100
	});

	$("#p_sTelefono").prop('maxlength', 10);
	$('#p_sTelefono').mask('(00) 0000-0000');

	$("#p_sCorreo").alphanum({
		allow				: '-.@_',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 120
	});

	$("#p_sCalle").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 50
	});

	$("#p_sNumeroInterior").alphanum({
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 10
	});

	$("#ext, #port, #p_nIdEmisor").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false,
		maxDigits			: 10
	});

	$("#p_sCodigoPostal").prop('maxlength', 5);
	$("#p_sCodigoPostal").alphanum({
        allow               :'-',
        allowLatin          : false,  // a-z A-Z
	    allowOtherCharSets  : false,
       	allowNumeric		: true,
		allowOtherCharSets	: false,
	});


	$("#p_nImporteComision").prop('maxlength', 6);
	$("#p_nImporteComision").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : true,
		allowLeadingSpaces  : false
	});


	$("#p_nCostoTrasferencia").prop('maxlength', 6);
	$("#p_nCostoTrasferencia").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : true,
		allowLeadingSpaces  : false
	});

	$("#p_nPorcentajeComision").prop('maxlength', 6);
	$("#p_nPorcentajeComision").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : true,
		allowLeadingSpaces  : false
	});


	$("#p_sCLABE").prop('maxlength', 18);
	$("#p_sCLABE").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#p_sReferencia").prop('maxlength', 10);
	$("#p_sReferencia").numeric({
		allowPlus           : false,
		allowMinus          : false,
		allowThouSep        : false,
		allowDecSep         : false,
		allowLeadingSpaces  : false
	});

	$("#referenciaAlfa").alphanum({
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 20
	});

	$("#cuentaContable").alphanum({
		allow				: '-',
		allowNumeric		: true,
		allowOtherCharSets	: false,
		maxLength			: 12
	});




});


/////////////////////variables////

var diascoms = [];
var diasliqs = [];
var nCodigoPostal			= 0;
var nIdColonia				= 0;
var nIdEntidad				= 0;
var nIdCiudad				= 0;
var nIdPais		= 0;
var tipocliente = 0;
var notifpagos = 0;
var emiii = 0;
var integx = 0;

var correosenv  = [];
var cuentacorreos = 0;
var cortes=["lunes","martes","miercoles","jueves","viernes","sabado","domingo"];
var accion=0;

var lun = [];
var mar = [];
var mie = [];
var jue = [];
var vie = [];

var cobrardias = [];

var cuentadias = 0;

$("#guardarIntegrador").click(function () {
  var confi = confirm('¿Desea Guardar los datos del Integrador?');
  if(confi == true){
    accion=3;
    guardarintegrador();

    }
});

$('input[name="entrega"]').change(function(){

	if($('input[name=entrega]:checked').val() == '1000'){

		document.getElementById("datosFtp").style.display="none";
		$("#port").val(0);

	}else{

		document.getElementById("datosFtp").style.display="inline-block";

	}
});


function minmax(value, min, max)
{
    if(parseInt(value) < min || isNaN(parseInt(value))){
        alert("Debe seleccionar un monto mayor a cero");
        return 0;
    }else if(parseInt(value) > max){
        alert("El monto excede del maximo establecido de $ 100,000");
        return 100;
    }else{
        return value;
    }
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
				});
			}
			else{
				alert("La CLABE escrita es incorrecta. Favor de verificarla.");
				$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
			}
		}
		else{
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
		}
	}
	function validarDigitoVerificador( CLABE ) {
		var factoresDePeso = [ 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7 ];
		var productos = new Array();
		var digitoVerificador = 0;

		for ( var i = 0; i < factoresDePeso.length; i++ ) {
			productos[i] = CLABE.charAt(i) * factoresDePeso[i];
		}

		for ( var i = 0; i < productos.length; i++ ) {
			productos[i] = productos[i] % 10;
		}

		for ( var i = 0; i < productos.length; i++ ) {
			digitoVerificador += productos[i];
		}

		digitoVerificador = 10 - ( digitoVerificador % 10 );

		if ( digitoVerificador == 10 ) {
			digitoVerificador = 0;
		}

		return CLABE.charAt(17) == digitoVerificador;

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
					$("#bancoCadena").val(banco.bancoID);
					$("#nombreBancoCadena").val(banco.nombreBanco);
				});
			}
			else{
				alert("La CLABE escrita es incorrecta. Favor de verificarla.");
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





$("#guardarR").click(function () {
  var confr = confirm("Desea Guardar la Informaci\u00F3n del Receptor");
  if(confr == false){return;}

  //datos generales
	var nombreComercial = $("#nombreComercial").val();
	var razonSocial = $("#razonSocial").val();
	var rfc = $("#rfc").val();
  var integrador = $("#idIntegrador").val();
	var beneficiario = $("#beneficiario").val();
	var telefono = $("#telefono").val();
	var correo = $("#correo").val();

  //direccion
  var calle = $("#txtCalle").val();
	var numeroInterior = $("#int").val();
	var numeroExterior = $("#ext").val();
	var codigoPostal = $("#txtCP").val();
	var idPais = $("#cmbpais").val();
  var idColonia = $("#cmbColonia").val();
	var idEstado = $("#cmbEntidad").val();
	var idMunicipio = $("#cmbCiudad").val();
  //cmbColonia,cmbEntidad,cmbCiudad
  // datos bancarios

  var clabe = $("#clabe").val();
	var correo = $("#correo").val();
	validacionCorreo = validar_email(correo);
	analizar = analizarCLABE2(clabe);
  var idBanco = $("#banco").val();
	var referencia = $("#referencia").val();
	var referenciaAlfa = $("#referenciaAlfa").val();
	var cuentaContable = $("#cuentaContable").val();

  //var edocta = $('#txtNIdDocEstadoCuenta').val();
  //DOCUMENTOS
  //documentos

  var compdomint  = $("input[type='hidden'][name='nIdDoc'][idtipodoc='1']").val();
  var rfcdocint   = $("input[type='hidden'][name='nIdDoc'][idtipodoc='2']").val();
  var edoctaint   = $("input[type='hidden'][name='nIdDoc'][idtipodoc='4']").val();
  var contratoint = $("input[type='hidden'][name='nIdDoc'][idtipodoc='10']").val();

  //configuracion
  // liquidacion
  var liquidacionr = 0;
  var diasdeliq= 0 +'';//array comvertido a string
  //comision

  var tipolicomision = $('#idTipoCom').val();
	var diasdecom = diascoms + ''; //array comvertido a string

  var comisionr =  ($("#comisionr").val() == '')?0:$("#comisionr").val();
  var adicionalr = ($("#adicionalr").val() == '')?0:$("#adicionalr").val();

  var retencionr = $("#retencion option:selected").val();
  var montoMaximo = $("#monto_max").val();

  //validacion de datos generales

  /*if(perComision != 0){
		perComision = perComision / 100;
	}else{
		perComision = 0;
	}

	if(perAdicional != 0){
		perAdicional = perAdicional / 100;
	}else{
		perAdicional = 0;
	}*/

	var lack = "";
	var error = "";

	if(nombreComercial == undefined || nombreComercial.trim() == '' || nombreComercial <= 0){lack +='Nombre Comercial\n';}
  if(razonSocial == undefined || razonSocial.trim() == '' || razonSocial <= 0){lack +='Razon Social\n';}
  if(rfc == undefined || rfc.trim() == '' || rfc <= 0){lack +='RFC\n';}
  if(beneficiario == undefined || beneficiario.trim() == '' || beneficiario <= 0){lack +='Beneficiario\n';}
  if(telefono == undefined || telefono.trim() == '' ){lack +='Telefono\n';}
  if(correo == undefined || correo.trim() == '' ){lack +='Correo\n';}

  // validacion direccion
	if(calle == undefined || calle.trim() == '' ){lack +='Calle\n';}
  if(numeroExterior == undefined || numeroExterior.trim() == '' ){lack +='Numero Exterior\n';}
  if(codigoPostal == undefined || codigoPostal.trim() == '' || codigoPostal <= 0){lack +='Codigo Postal\n';}
  if(idColonia == undefined || idColonia.trim() == '' || idColonia <= 0){lack +='Colonia\n';}

  // validacion datos bancarios
  if(clabe == undefined || clabe.trim() == '' || clabe <= 0){lack +='Cuenta CLABE\n';}
	//if(edocta == undefined || edocta.trim() == '' || edocta == 0){lack +='Documento Estado de Cuenta \n';}

  //documentos
  if(compdomint == '' || compdomint == 0 ){lack +='Archivo Comprobante de Domicilio\n';}
  if(rfcdocint == '' || rfcdocint == 0 ){lack +='Archivo Comprobante de RFC\n';}
  if(edoctaint == '' || edoctaint == 0 ){lack +='Archivo Estado de Cuenta\n';}
  if(contratoint == '' || contratoint == 0 ){lack +='Archivo Contrato\n';}

  //validacion datos  de configuracion
  //liquidaciones

  // if(liquidacionr == -1){lack +='Tipo de Liquidaci\u00F3n\n';}
  //if(liquidacionr > 1 && diasliqs.length == 0 ){lack +='D\u00EDas de Liquidaci\u00F3n\n';}
  //if(cuentadias != 28){lack +='D\u00EDas de Liquidaci\u00F3n\n';}

  //comisiones
  if(tipolicomision == -1){lack +='Tipo de Pago Comisi\u00F3n\n';}
  if(tipolicomision > 1 && diascoms.length == 0 ){lack +='D\u00EDas de pago de Comisi\u00F3n\n';}

  // if(comisionr == undefined || comisionr == '' || comisionr == 0){lack +='Importe  de  comisi\u00F3n\n';}
  // if(adicionalr == undefined || adicionalr == '' ){lack +='Importe de  comisi\u00F3n Adicional\n';}
  if(retencion == -1){lack +='Retenci\u00F3n\n';}
  if(montoMaximo == -1){lack +='Monto Maximo';}

  // Mensaje de error en caso de no contener algun valor en la cassilla //
  if(lack != "" || error != ""){
    var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		jAlert(black + '\n' + lack+'\n' );
		event.preventDefault();
	}else{
    if(validacionCorreo == false){
      jAlert('El correo no es valido');
		}else{
      analizar = analizarCLABE2(clabe);
      if(analizar == true){
        validaMonto = minmax(montoMaximo,1,100000);
        if(validaMonto){
          var $this = $(this);
          $this.button('loading');

          $.post("../../paycash/ajax/Afiliacion/afiliacion.php",{
            // datos generales
            nombreComercial : nombreComercial,
            razonSocial : razonSocial,
            rfc : rfc,
            integrador:integrador,
            beneficiario : beneficiario,
            telefono : telefono,
            correo : correo,

            //direccion
            calle: calle,
  					numeroInterior: numeroInterior,
  					numeroExterior: numeroExterior,
  					codigoPostal: codigoPostal,
  					idColonia: idColonia,
  					idEstado: idEstado,
  					idMunicipio: idMunicipio,
            idPais: idPais,

            // datos  bancarios
            clabe : clabe,
            banco: idBanco,
            cuentaContable : cuentaContable,
            referencia: referencia,
            referenciaAlfa: referenciaAlfa,

            // edocta:edocta,
            //documentos
            compdomint :  compdomint,
            rfcdocint  :  rfcdocint,
            edoctaint  :  edoctaint,
            contratoint:  contratoint,

            //cofiguracion
            //liquidacion
            // liquidacionr:cobrardias,  //eliminado por la nueva configuracion
            diasdeliq:diasdeliq,//array comvertido a string

            //comisiones
            tipolicomision:tipolicomision,
            diasdecom:diasdecom, //array comvertido a string
            comisionr:comisionr,
            adicionalr:adicionalr,
            retencionr:retencionr,
            monto : montoMaximo,

            tipo: 2
          },

          function(response){
            var obj = jQuery.parseJSON(response);
            if(obj.showMessage == 500 || obj.nCodigo != 0){
              jAlert(obj.msg);
              $this.button('reset');
            }else{
              jAlert(obj.sMensaje);
              document.getElementById("guardarR").style.display="none";
              $this.button('reset');
            }
          })
          .fail(function(response){
            $this.button('reset');
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
          })
        }
      }else{
        jAlert('La clabe interbancaria es incorrecta');
      }
    }
  }
});

$("#p_sCodigoPostal").on('keyup', function(e){


    var code = e.keyCode || e.which;
    if (code != '9') {


            var cp = e.target.value;
            var paisy = ($("#p_nIdPais").val() != undefined)?$("#p_nIdPais").val():164;

            if(paisy  == 164){
                    buscarColonias(cp);
            }
    }
});



function RFCFormato(von){ //funcion para  el comportamiento del  texto RFC



	var rfc = event.target.value;

	if(rfc.length > 11){

    	if($('#p_nIdPais').val() == 164 & $('#p_sRFC').val().length == 12){ //verifica el formato del rfcde la persona moral es correcto

    		var rfcm = $('#p_sRFC').val();
    		if(verif_rfcm(rfcm) == false){
    			jAlert("Capture un RFC valido.");
    			return false;
    		}else{

    			validaExistencia(rfc,von);
    			return true;

    		}

    	}
    	if($('#p_nIdPais').val() == 164 & $('#p_sRFC').val().length < 12){
    		jAlert("Capture un RFC valido.");
    		return false
    	}
    }
}


function validaExistencia(rfc,vons){
	tipo = 6;
    if(vons == 1){tipo = 9;}
    if(vons == 2){tipo = 13;}
	  rfc = rfc;
	$.post("/ayddo/ajax/Integrador.php",{
		rfc: rfc,
		tipo: tipo
	},
	function(response){

		var obj = jQuery.parseJSON(response);
		jAlert(obj[0].msg);

	})

	.fail(function(response){
		alert('Ha ocurrido un error, no se pudo validar existencia de rfc');
	})
}


    function verif_rfcm(rfcs) {  //verifica RFC persona Moral

    	var for_rfc= /^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))/;
    	if(for_rfc.test(rfcs))
    		{ return true; }
    	else
    		{ return false; }
    }


    function cargarEstados(idPais){
    	cargarStore("../../paycash/ajax/Afiliacion/storeEstados.php", "cmbEstado", {idpais : idPais}, {text : 'descEstado', value : "idEstado"}, {}, 'estadosloaded');
    }

    function cargarMunicipios(idPais, idEstado){
    	cargarStore("../../paycash/ajax/Afiliacion/storeMunicipios.php", "cmbMunicipio", {idPais : idPais, idEstado : idEstado}, {text : 'descMunicipio', value : "idMunicipio"}, {}, 'municipiosloaded');
    }

    function cargarColonias(idPais, idEstado, idMunicipio){
	//cargarStore(BASE_PATH+"/inc/Ajax/stores/storeColonias.php", "cmbColonia", {idPais : idPais, idEstado : idEstado, idMunicipio : idMunicipio}, {text : 'descColonia', value : "idColonia"}, {}, 'ciudadesloaded');
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////SECCION DEL INTEGRADOR//////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function limpiabanco(){
   var clabei             = $("#p_sCLABE").val();

    if(clabei.length < 18){
        $("#p_nIdCuentaBanco").val('');
         $("#nombreBanco").val('');

    }

}

function diasliq(valores, dias){

diasliqs = [];

      if(valores == -1){

        $('#diasliq').html(' <label class=" control-label "> </label>');
    }

       if(valores == 1){

        $('#diasliq').html(' <p class=" control-label " style="text-align:justify; font-size:12px">El Corte de liquidación se hará del Primero al último día del mes anterior a la fecha de corte. La fecha de corte será el Primer día de cada mes </p>');
    }

    if(valores == 2){

        $('#diasliq').html(' <label class=" control-label chkbx"><input type="checkbox" id="dliq" name="dliq" value="2" class="" onclick="diasliquidaciones(this, this.value)"> Lunes </label> <label class=" control-label chkbx"><input type="checkbox" id="dliq"  name="dliq" value="3" class=" m-bot15" onclick="diasliquidaciones(this, this.value)"> Martes</label><label class=" control-label chkbx"><input type="checkbox" id="dliq"  name="dliq" value="4" class=" m-bot15" onclick="diasliquidaciones(this, this.value)"> Miercoles </label> <label class=" control-label chkbx"><input type="checkbox" id="dliq" name="dliq" value="5" class=" m-bot15" onclick="diasliquidaciones(this, this.value)"> Jueves</label><label class=" control-label chkbx"><input type="checkbox" id="dliq" name="dliq" value="6" class="m-bot15" onclick="diasliquidaciones(this, this.value)"> Viernes</label>');
    }

    if(valores == 3){

        $('#diasliq').html(' <label class=" control-label chkbx"> <input type="radio" id="rdliq" name ="dliq" value="2" class="" onclick="diasliquidacionesrad(this, this.value)"> Lunes</label> <label class=" control-label chkbx"><input type="radio" id="rdliq" name ="dliq" value="3" class=" m-bot15" onclick="diasliquidacionesrad(this, this.value)"> Martes</label><label class=" control-label chkbx"><input type="radio" id="rdliq" name ="dliq" value="4" class="m-bot15" onclick="diasliquidacionesrad(this, this.value)"> Miercoles</label> <label class=" control-label chkbx"><input type="radio" id="rdliq" name ="dliq" value="5" class=" m-bot15" onclick="diasliquidacionesrad(this, this.value)"> Jueves</label><label class=" control-label chkbx"><input type="radio" id="rdliq" name ="dliq" value="6" class=" m-bot15" onclick="diasliquidacionesrad(this, this.value)"> Viernes</label>');
    }


}

function diascom(valores, dias){
  diascoms = [];
  if(valores == -1){
    $('#diascom').html(' <label class=" control-label "> </label>');
  }

  if(valores == 1){
    $('#diascom').html(' <p class=" control-label " style="text-align:justify; font-size:12px">El Corte de Comisiones se hará del Primero al último día del mes anterior a la fecha de corte. La fecha de corte será el Primer día de cada mes </p>');
  }

  if(valores == 2){
    $('#diascom').html(' <label class=" control-label chkbx"> <input type="checkbox" id="dcom" name="dcom" value="2" class="" onclick="diascomisiones(this, this.value)" > Lunes</label> <label class=" control-label chkbx"><input type="checkbox" id="dcom" name="dcom" value="3" class="m-bot15" onclick="diascomisiones(this, this.value)"> Martes</label><label class=" control-label chkbx"><input type="checkbox" id="dcom" name="dcom" value="4" class=" m-bot15" onclick="diascomisiones(this, this.value)"> Miercoles</label> <label class=" control-label chkbx"><input type="checkbox" id="dcom"  name="dcom" value="5" class=" m-bot15" onclick="diascomisiones(this, this.value)"> Jueves</label><label class=" control-label chkbx"><input type="checkbox" id="dcom" name="dcom" value="6" class=" m-bot15" onclick="diascomisiones(this, this.value)"> Viernes</label>');
  }

  if(valores == 3){
    $('#diascom').html(' <label class=" control-label chkbx"> <input type="radio" id="dcom" name ="dcom" value="2" class="" onclick="diascomisionesrad(this, this.value)"> Lunes</label> <label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="3" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Martes</label><label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="4" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Miercoles</label> <label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="5" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Jueves</label><label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="6" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Viernes</label>');
  }

  if(valores == 4){
    $('#diascom').html(' <label class=" control-label chkbx"> <input type="radio" id="dcom" name ="dcom" value="2" class="" onclick="diascomisionesrad(this, this.value)"> Lunes</label> <label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="3" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Martes</label><label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="4" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Miercoles</label> <label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="5" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Jueves</label><label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="6" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Viernes</label>');
  }

  if(valores == 5){
    $('#diascom').html(' <label class=" control-label chkbx"> <input type="radio" id="dcom" name ="dcom" value="2" class="" onclick="diascomisionesrad(this, this.value)"> Lunes</label> <label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="3" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Martes</label><label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="4" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Miercoles</label> <label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="5" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Jueves</label><label class=" control-label chkbx"><input type="radio" id="dcom" name ="dcom" value="6" class=" m-bot15" onclick="diascomisionesrad(this, this.value)"> Viernes</label>');
  }
}



function diascomisiones(cb,valores){
  if(cb.checked==true){
    diascoms.push(valores);
    diascoms.sort();
  }

  if(cb.checked==false){
    for(var i = 0; i< diascoms.length; i++){
      while(diascoms[i] == valores) diascoms.splice(i,1);
    }
    diascoms.sort();
  }
}


function diasliquidaciones(cb,valores){
    if(cb.checked==true){
    diasliqs.push(valores);
    diasliqs.sort();
    }

    if(cb.checked==false){

        for(var i = 0; i< diasliqs.length; i++){ while(diasliqs[i] == valores) diasliqs.splice(i,1);}
        diasliqs.sort();


    }

}

function diasliquidacionesrad(cb,valores){

    diasliqs = [];
    diasliqs.push(valores);

}

function diascomisionesrad(cb,valores){

    diascoms = [];
    diascoms.push(valores);

}





var tablesToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , tmplWorkbookXML = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
      + '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>'
      + '<Styles>'
      + '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
      + '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
      + '</Styles>'
      + '{worksheets}</Workbook>'
    , tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>'
    , tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(tables, wsnames, wbname, appname) {
      var ctx = "";
      var workbookXML = "";
      var worksheetsXML = "";
      var rowsXML = "";

      for (var i = 0; i < tables.length; i++) {
        if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
        for (var j = 0; j < tables[i].rows.length; j++) {
          rowsXML += '<Row>'
          for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
            var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
            var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
            var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
            dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
            var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
            dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
            ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date')?' ss:StyleID="'+dataStyle+'"':''
                   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
                   , data: (dataFormula)?'':dataValue
                   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
                  };
            rowsXML += format(tmplCellXML, ctx);
          }
          rowsXML += '</Row>'
        }
        ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
        worksheetsXML += format(tmplWorksheetXML, ctx);
        rowsXML = "";
      }

      ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
      workbookXML = format(tmplWorkbookXML, ctx);



      var link = document.createElement("A");
      link.href = uri + base64(workbookXML);
      link.download = wbname || 'Workbook.xls';
      link.target = '_blank';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  })();


function habilitar1(ckb){
  if(ckb.checked==false){
    $('#p_nCostoTrasferencia').attr("disabled",true);
    $('#p_nCostoTrasferencia').val(0);

    $('#nIdTipofactura').attr("disabled",true);
    $('#nIdTipofactura').val(-1);
    $('#p_nIdPagoComision').attr("disabled",true);
    $('#p_nIdPagoComision').val(-1);

    $('#divcobtrans').css('display','none');
  }else{
    $('#p_nCostoTrasferencia').attr("disabled",false);
    $('#p_nIdTipofactura').attr("disabled",false);
    $('#p_nIdPagoComision').attr("disabled",false);
    $('#divcobtrans').css('display','block');
  }
}



function initInputFiles(){
  $(':input[type=file]').unbind('change');
  $(':input[type=file]').on('change', function(e){
    var input		= e.target;
    var nIdTipoDoc	= input.getAttribute('idtipodoc');
    var file = $(input).prop('files')[0];

    var formdata = new FormData();
		formdata.append('p_sDocumento',file);
		formdata.append('p_nIdDocumento', nIdTipoDoc);
		formdata.append('p_sRFC', $('#p_sRFC').val());
    formdata.append('usr',usr);
    formdata.append('tipo',5);

    if(file.type != 'application/pdf'){
      jAlert('El archivo debe ser formato pdf');
      return;
    }else{
      $.ajax({
        url			: '/ayddo/ajax/Integrador.php',
				type		: 'POST',

				contentType	: false,
				data		: formdata,
        mimeType :"multipart/form-data",
				processData	: false,
				cache		: false,
				dataType	: 'json',
      })
      .done(function(resp){
        if(resp.nIdDocumento > 0){
          //id="txtNIdDoc" idtipodoc="4"
          //$("input[type='checkbox'][value="+value+"][dp="+diaxx+"]")
          $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc="+nIdTipoDoc+"]").val(resp.nIdDocumento);
          jAlert('Documento Cargado Exitosamente!!');
        }else{
          jAlert(resp.mensaje);
        }
      })
      .fail(function(resp){
        console.log(resp);
        jAlert('Error al Intentar Subir el Archivo');
      });
    }
  });
}


function verdocumento(tipodocumento){
 
    var tipodocumnts = tipodocumento.attributes[4].value;
    
    var iddoc = $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc="+tipodocumnts+"]").val();
    var sdoc =  $("input[type='hidden'][name='p_sKeyDocumento'][idtipodoc="+tipodocumnts+"]").val();
    //alert(iddoc);
    if(iddoc == '' || iddoc == 0 ){jAlert('No se ha seleccionado ningun archivo');}else{
    
    $.post('/ayddo/ajax/Integrador.php',{nIdDocumento:iddoc,tipo:4},function(resp){
        if(!resp.ruta){jAlert('No Hay Documento para mostar');}else{verdocs(resp.ruta);}
    },"json");
    
    }
}

function verdocumentopremisor(tipodocumento){
 
  var tipodocumnts = tipodocumento.attributes[4].value;
    
    var iddoc = $("input[type='hidden'][name='nIdDoc'][idtipodoc="+tipodocumnts+"]").val();
    
    //alert(iddoc);
    if(iddoc == '' || iddoc == 0 ){jAlert('No se ha seleccionado ningun archivo');}else{
    
    $.post('/ayddo/ajax/premisor.php',{nIdDocumento:iddoc,tipo:3},function(resp){
        if(!resp.ruta){jAlert('No Hay Documento para mostar');}else{
          jQuery('#pdfdata').attr('data', resp.ruta);
          $('#pdfvisor').css('display','block');
        }
    },"json");
    
    }
}

function verdocumentoproveedor(tipodocumento){
 
  var tipodocumnts = tipodocumento.attributes[4].value;
    
    var iddoc = $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc="+tipodocumnts+"]").val();
    
    //alert(iddoc);
    if(iddoc == '' || iddoc == 0 ){jAlert('No se ha seleccionado ningun archivo');}else{
    
    $.post('/ayddo/ajax/proveedor.php',{nIdDocumento:iddoc,tipo:2},function(resp){
        if(!resp.ruta){jAlert('No Hay Documento para mostar');}else{
          jQuery('#pdfdata').attr('data', resp.ruta);
          $('#pdfvisor').css('display','block');
        }
    },"json");
    
    }
}

function verdocs(ruta){
    //$('#fileViewer').attr('src', $('#fileViewer').attr('src'));
    
    jQuery('#pdfdata').attr('data', '/ayddo/ajax/pdfoutside.php?pdf='+ ruta);
    
    $('#pdfvisor').css('display','block');

}


function customEmptyStore(id){
	var cmb		= document.getElementById(id);
	var length	= cmb.options.length;

	var i;
    for(i = cmb.options.length - 1 ; i >= 0 ; i--){
		cmb.remove(i);
    }
}

function customTrim(txt){
	txt = txt.toString();
	return txt.replace(/^\s+|\s+$/g, '');
}
//////////////////////////////////////////////////////////////////////
function buscarColonias(nCodigoPostal, nIdColonias){

	if(nCodigoPostal == undefined){
		resetDatosColonias();
		return false;
	}

	var sCodigoPostal = customTrim(nCodigoPostal.toString());

	//resetDatosColonias();
	if(sCodigoPostal.length > 5){
		resetDatosColonias();
		return false;
	}

	if(sCodigoPostal.length < 5 || sCodigoPostal.length > 5){
		resetDatosColonias();
		return false;
	}
///// id el combo colonia
	//$('#cmbColonia').prop('disabled', true);

	$.ajax({
		url			: '/ayddo/ajax/CodigoPostal.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {
		nCodigoPostal : sCodigoPostal
		}
	})
	.done(function(resp){
		if(resp.bExito == true){
			customLlenarComboColonia('p_nIdColonia', resp.data);
			customLlenarComboEstado('p_nIdEstado', resp.data);
			customLlenarComboCiudad('p_nIdCiudad', resp.data);

            if(nIdColonias == undefined){}else{

              $('#p_nIdColonia').val(nIdColonias);
            $('#p_nIdColonia').prop('disabled', true);
            }


		}
	})
	.fail(function() {
	})
	.always(function() {
		//$('#cmbColonia').prop('disabled', true);
	});

}


function resetDatosColonias(){
	customEmptyStore('p_nIdColonia');
	customEmptyStore('p_nIdEstado');
	customEmptyStore('p_nIdCiudad');
}
//cmbColonia,cmbEntidad,cmbCiudad
function customLlenarComboEstado(id, data){
	customEmptyStore('p_nIdEstado');
	var cmb		= document.getElementById(id);
	var option	= document.createElement("option");

	if(typeof option.textContent === 'undefined'){
		option.innerText = data[0].sDEstado;
	}
	else{
		option.textContent = data[0].sDEstado;
	}
	option.value	= data[0].nIdEstado;

	cmb.appendChild(option);
}

function customLlenarComboCiudad(id, data){
	customEmptyStore('p_nIdCiudad');
	var cmb		= document.getElementById(id);
	var option	= document.createElement("option");

	if(typeof option.textContent === 'undefined'){
		option.innerText = data[0].sDMunicipio;
	}
	else{
		option.textContent = data[0].sDMunicipio;
	}
	option.value	= data[0].nNumMunicipio;

	cmb.appendChild(option);
}

function customLlenarComboColonia(id, data){
	var data	= data;
	var length	= data.length;
	var cmb		= document.getElementById(id);

	customEmptyStore('p_nIdColonia');

	for(var i=0; i<length; i++){
		var option	= document.createElement("option");
		option.text	= data[i].sNombreColonia;

		if(typeof option.textContent === 'undefined'){
			option.innerText = data[i].sNombreColonia;
		}
		else{
			option.textContent = data[i].sNombreColonia;
		}
		option.value	= data[i].nIdColonia;

		cmb.appendChild(option);
	}
}

function customLlenarComboPais(id, data){
  var data	= data;
	var length	= data.length;
	var cmb		= document.getElementById(id);

	//customEmptyStore('cmbColonia');

	for(var i=0; i<length; i++){
		var option	= document.createElement("option");
		option.text	= data[i].sNombre;

		if(typeof option.textContent === 'undefined'){
			option.innerText = data[i].sNombre;
		}
		else{
			option.textContent = data[i].sNombre;
		}
		option.value	= data[i].nIdPais;

		cmb.appendChild(option);
	}
}

function ftpopt(valor){


    if(valor == 2){
        $('#datosFtp').css('display','block');
        $('#confcorreos').css('display','none');


    }else{
       $('#datosFtp').css('display','none');
       $('#confcorreos').css('display','block');

        notifpagos = valor;
    }

     if(valor == 1000){notifpagos = valor;}else{notifpagos = 0}

    console.log(notifpagos);

}


function mostrarmetodo(cbx){

    //console.log(cbx);

   if( cbx.checked==true){
       $('#divmetodoenlinea').css('display','block');
       tipocliente  = 1;
       console.log(tipocliente);

   }else{

     $('#divmetodoenlinea').css('display','none');
       tipocliente  = 0;
       console.log(tipocliente);
   }


}

function muestraenlinea(valx){
	tipocliente  = valx;
	if(valx == 0){
		$('#divenlinea').css('display','block');
	}else{
		$('#divenlinea').css('display','none');
	}
}


function cambiarmetodoentrega(valy){

   if(valy == -1){
		notifpagos = 0;
	}else{
		notifpagos = valy;
	}
    console.log(notifpagos);
}

function cambiacomtip(vals){



if(vals == 1){


    $('#p_nPorcentajeComision').val(0);
    $('#p_nPorcentajeComision').prop('disabled', true);
     $('#p_nImporteComision').prop('disabled', false);


}else{

    $('#p_nImporteComision').val(0);
    $('#p_nImporteComision').prop('disabled', true);
    $('#p_nPorcentajeComision').prop('disabled', false);
}



}

function habilitaredicion(tipoedi){
  $('input').attr('disabled', false);
  $('select').attr('disabled', false);
  $('.cbxliq').attr('disabled', true);

  $('#tlbconf :checkbox:checked').prop('disabled', false);
  $('#btncanceledit').css('display','block');
  $('#btneditar').css('display','none');
  $('#btnIntegrador').css('display','block');
  $('.remove_button').attr('disabled',false);

  $('#diaCorte_Lunes').attr('disabled',true);
  $('#diaCorte_Martes').attr('disabled',true);
  $('#diaCorte_Miercoles').attr('disabled',true);
  $('#diaCorte_Jueves').attr('disabled',true);
  $('#diaCorte_Viernes').attr('disabled',true);
  $('#diaCorte_Sabado').attr('disabled',true);
  $('#diaCorte_Domingo').attr('disabled',true);

  if(tipoedi == 4){
    $('#autpreem').css('display','none');
  }
  $('#p_sRFC').attr('disabled', 'disabled');
  $('#p_sIrs').attr('disabled', 'disabled');
}


function cancelaredicion(tipx){
    //alert(tipx);

    if(tipx == 1){

        //alert(tipx);

        $('input').attr('disabled', true);
        $('select').attr('disabled', true);
         $('input').attr('disabled', true);
        $('select').attr('disabled', true);
        $('#btncanceledit').css('display','none');
        $('#btneditar').css('display','block');
         $('#guardarcambios').css('display','none');
       $
        $('body').append('<form action=""  method="post" id="formintegsend"><input type="text" name="txtidinteg"  value="'+integx+'"/></form>');
        $( "#formintegsend" ).submit();

    }else if(tipx == 2){

        $('input').attr('disabled', true);
        $('select').attr('disabled', true);
        $('#btncanceledit').css('display','none');
        $('#btneditar').css('display','block');
        $('#btnIntegrador').css('display','none');

        $('body').append('<form action="" method="post" id="formidpost"><input type="text" value="'+integ+'" name="p_IdIntegrador"/></form>');
        $( "#formidpost" ).submit();

        }else if(tipx == 3){

            $('input').attr('disabled', true);
        $('select').attr('disabled', true);
        $('#btncanceledit').css('display','none');
        $('#btneditar').css('display','block');
        $('#btnIntegrador').css('display','none');

        $('body').append('<form action="" method="post" id="formidrec"><input type="text" value="'+Idreceptor+'" name="txtidreceptor"/></form>');
        $( "#formidrec" ).submit();

        }else if(tipx == 4){

           /* $('input').attr('disabled', true);
        $('select').attr('disabled', true);
        $('#btncanceledit').css('display','none');
        $('#btneditar').css('display','block');
        $('#guardarCE').css('display','none');*/

         $('body').append('<form action="" method="post" id="formidrec"><input type="hidden" value="'+preem+'" name="txtidpreem"/><input type="hidden" value="'+integ+'" name="txtidinteg"/></form>');
         $( "#formidrec" ).submit();

        }

}

function cargaproveedor(){
  if (idproveedor!= 0){
    $('#divIdIntegrador').css('display','block'); 
  $('input').attr('disabled', true);
  $('select').attr('disabled', true);
  $('.btnfiles').css('disabled',false); 

    //obtenerconfigliquidacioninteg(integ,1);

    $.post('/ayddo/ajax/Proveedor.php',{idproveedor:idproveedor,tipo:1},function(response){
      var obj = jQuery.parseJSON(response);
      if(obj.length == 0){
        jAlert('No se encontro informacion');
  
      var inputs = document.getElementsByTagName("input");
      for(var i=0;i<inputs.length;i++){
        inputs[i].value = "";
      }
    }else{
      var displayCorreos = 0;
      jQuery.each(obj, function(index,value) {

        $('.btnfiles').prop('disabled', false);
        $('#btneditar').css('display','block');
        $('#guardarProveedor').css('display','none');
        
        var proveedor=obj[index]["nIdProveedor"];
    $("#p_IdProveedor").val(proveedor);
    $("#p_sToken").val( obj[index]["sToken"]);
    $("#p_nIdIntegrador").val(obj[index]["nIdIntegrador"]);  

        //datos generales
    $("#p_sRFC").val( obj[index]["sRFC"]);
    $("#p_sIrs").val(obj[index]["sIrs"])
	  $("#p_sNombreComercial").val(obj[index]["sNombreComercial"]);
	  $("#p_sRazonSocial").val(obj[index]["sRazonSocial"]);
    $("#p_sNombreContacto").val(obj[index]["sNombreContacto"]);
    $("#p_sTelefono").val(obj[index]["sTelefonoContacto"]);
    $("#p_sCorreo").val(obj[index]["sCorreoContacto"]);

    //Dirección
    $("#p_sCalle").val( obj[index]["sCalle"]);
    $("#p_sNumeroExterior").val( obj[index]["sNumeroExterior"]);
    $("#p_sNumeroInterior").val( obj[index]["sNumeroInterior"]);
    $("#p_sCodigoPostal").val( obj[index]["sCodigoPostal"]);
    var nidPaisx = obj[index]['nIdPais'];
    $("#p_nIdPais").val(nidPaisx);
    seleccionapais(nidPaisx);
    if(nidPaisx == 164){
      nIdColonia = obj[index]['nIdColonia'];
      buscarColonias(obj[index]['sCodigoPostal'], obj[index]['nIdColonia']);
    }

    //Datos del banco
    $("#p_sCLABE").val(obj[index]['sClabeInterbancaria']);
    $("#p_nIdCuentaBanco").val(obj[index]['nIdCuentaBanco']);
    $("#p_sReferencia").val(obj[index]['sReferenciaAlfaNum']);


    //Documentos
    
      $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='1']").val(obj[index]['nIdDocumento1']);
      $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='2']").val(obj[index]['nIdDocumento2']);
      $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='3']").val(obj[index]['nIdDocumento3']);
      $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='4']").val(obj[index]['nIdDocumento4']);
     


    //Configuración de liquidacion
    //ProgramacionPagosIntegrador(integrador);

    //Cobro trasferencia
        /*
    var  cktrans  = obj[index]['nIdCobroTrasferencia'];
        if(cktrans == 1){
          $('#chkcobrotransferencia').attr('checked','checked');
          $('#p_nIdTipofactura').val(obj[index]['nIdTipofactura']);
          $('#p_nCostoTrasferencia').val(obj[index]['nCostoTrasferencia']);
          $('#divcobtrans').css('display','block');
        }

      //Comision
      $('#p_nIdPagoComision').val(obj[index]['nIdPagoComision']);
      diascom(obj[index]['nIdPagoComision'], 0);
      var DiasPagoComision = (obj[index]['nDiasPagoComision']== null)? '0': obj[index]['nDiasPagoComision'];
      var DiasPagoComision  = DiasPagoComision.split(',');

      for (var j = 0; j < DiasPagoComision.length; j++) {
        var DiasComision = DiasPagoComision[j];
         $('input[name ="dcom"][value="'+DiasComision+'"]').attr('checked','checked');
        }

      $('#p_nImporteComision').val(obj[index]['nImporteComision']);
      $('#p_nPorcentajeComision').val(obj[index]['nPorcentajeComision']);
      $('#p_nIdRetencion').val(obj[index]['nIdRetencion']);

      //Referencia y Notifiacion
      $('#p_nIdTipoReferencia').val(obj[index]['nIdTipoReferencia']);
      //$('#p_nIdNotificaPagos').val(obj[index]['nIdNotificaPagos']);
      var bitmap =  obj[index]['bitmap'];
      if(bitmap == 1000){
        $('#p_nIdNotificaPagos').val(bitmap);
        $('#confcorreos').css('display','block');

        separador = ",";
        correosenv = obj[index]['sListaCorreo'].split(separador);//falta validar si viene null

        if (displayCorreos == 0) {
          for (var i = 0; i < correosenv.length; i++) {
            $('#contenedordecorreos1').append('<div class="col-xs-12 formCorreos" ><input type="text" id="camposCorreos" class="form-control m-bot15 lecturaCorreos" name="correos" value="'+correosenv[i]+'" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreos btn btn-sm inhabilitar" id="remove" style="margin-left:3px;width:150px" value="'+correosenv[i]+'" onclick="removercorreo(this.value);"  disabled >Quitar  <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
          }
          displayCorreos = 1;
        }

      }else{
        $('#p_nIdNotificaPagos').val(2);

        if(bitmap == '1100' || bitmap == '1010' || bitmap == '1001'){
          document.getElementById("datosFtp").style.display="inline-block";
        }else{
          document.getElementById("datosFtp").style.display="none";
        }
        $('#p_nIdMetodoEntrega').val(bitmap);
      }

      //ojo n oexiste en el html
      $('input[name=entrega][value='+bitmap+']').attr('checked', true);

      $('#divenlinea').css('display','block');
      $('#chkenlinea').attr('checked','checked');
      $('#divmetodoenlinea').css('display','block');
      $('#p_nIdMetodoLinea').val(obj[index]['nIdMetodoLinea']);
        */
      });
    }
    }).fail(function(response){
					$this.button('reset');
					jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
				});
      }
}

function cargaintegrador(){
  if (integ!= 0){
    $('#divIdIntegrador').css('display','block'); 
  $('input').attr('disabled', true);
  $('select').attr('disabled', true);
  $('.btnfiles').css('disabled',false); 

    //obtenerconfigliquidacioninteg(integ,1);

    $.post('/ayddo/ajax/Integrador.php',{idintegrador:integ,tipo:1},function(response){
      var obj = jQuery.parseJSON(response);
      if(obj.length == 0){
        jAlert('No se encontro informacion');
  
      var inputs = document.getElementsByTagName("input");
      for(var i=0;i<inputs.length;i++){
        inputs[i].value = "";
      }
    }else{
      var displayCorreos = 0;
      jQuery.each(obj, function(index,value) {

        $('.btnfiles').prop('disabled', false);
        $('#btneditar').css('display','block');
        $('#guardarIntegrador').css('display','none');
        
        var integrador=obj[index]["nIdIntegrador"];
    $("#p_IdIntegrador").val(integrador);
    $("#p_sToken").val( obj[index]["sToken"]);
    $("#p_nIdEmisor").val(obj[index]["nIdEmisor"]);  

        //datos generales
    $("#p_sRFC").val( obj[index]["sRfc"]);
    $("#p_sIrs").val(obj[index]["sIrs"])
	  $("#p_sNombreComercial").val(obj[index]["sNombreComercial"]);
	  $("#p_sRazonSocial").val(obj[index]["sRazonSocial"]);
    $("#p_sNombreContacto").val(obj[index]["sNombreContacto"]);
    $("#p_sTelefono").val(obj[index]["sTelefonoContacto"]);
    $("#p_sCorreo").val(obj[index]["sCorreoContacto"]);

    //Dirección
    $("#p_sCalle").val( obj[index]["sCalle"]);
    $("#p_sNumeroExterior").val( obj[index]["sNumeroExterior"]);
    $("#p_sNumeroInterior").val( obj[index]["sNumeroInterior"]);
    $("#p_sCodigoPostal").val( obj[index]["sCodigoPostal"]);
    var nidPaisx = obj[index]['nIdPais'];
    $("#p_nIdPais").val(nidPaisx);
    seleccionapais(nidPaisx);
    if(nidPaisx == 164){
      nIdColonia = obj[index]['nIdColonia'];
      buscarColonias(obj[index]['sCodigoPostal'], obj[index]['nIdColonia']);
    }

    //Datos del banco
    $("#p_sCLABE").val(obj[index]['sClabeInterbancaria']);
    $("#p_nIdCuentaBanco").val(obj[index]['nIdCuentaBanco']);
    $("#p_sReferencia").val(obj[index]['sReferenciaAlfaNum']);


    //Documentos
    documentosIntegrador(integrador);

    //Configuración de liquidacion
    ProgramacionPagosIntegrador(integrador);

    //Cobro trasferencia

    var  cktrans  = obj[index]['nIdCobroTrasferencia'];
        if(cktrans == 1){
          $('#chkcobrotransferencia').attr('checked','checked');
          $('#p_nIdTipofactura').val(obj[index]['nIdTipofactura']);
          $('#p_nCostoTrasferencia').val(obj[index]['nCostoTrasferencia']);
          $('#divcobtrans').css('display','block');
        }

      //Comision
      $('#p_nIdPagoComision').val(obj[index]['nIdPagoComision']);
      diascom(obj[index]['nIdPagoComision'], 0);
      var DiasPagoComision = (obj[index]['nDiasPagoComision']== null)? '0': obj[index]['nDiasPagoComision'];
      var DiasPagoComision  = DiasPagoComision.split(',');

      for (var j = 0; j < DiasPagoComision.length; j++) {
        var DiasComision = DiasPagoComision[j];
         $('input[name ="dcom"][value="'+DiasComision+'"]').attr('checked','checked');
        }

      $('#p_nImporteComision').val(obj[index]['nImporteComision']);
      $('#p_nPorcentajeComision').val(obj[index]['nPorcentajeComision']);
      $('#p_nIdRetencion').val(obj[index]['nIdRetencion']);

      //Referencia y Notifiacion
      $('#p_nIdTipoReferencia').val(obj[index]['nIdTipoReferencia']);
      //$('#p_nIdNotificaPagos').val(obj[index]['nIdNotificaPagos']);
      var bitmap =  obj[index]['bitmap'];
      if(bitmap == 1000){
        $('#p_nIdNotificaPagos').val(bitmap);
        $('#confcorreos').css('display','block');

        separador = ",";
        correosenv = obj[index]['sListaCorreo'].split(separador);//falta validar si viene null

        if (displayCorreos == 0) {
          for (var i = 0; i < correosenv.length; i++) {
            $('#contenedordecorreos1').append('<div class="col-xs-12 formCorreos" ><input type="text" id="camposCorreos" class="form-control m-bot15 lecturaCorreos" name="correos" value="'+correosenv[i]+'" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreos btn btn-sm inhabilitar" id="remove" style="margin-left:3px;width:150px" value="'+correosenv[i]+'" onclick="removercorreo(this.value);"  disabled >Quitar  <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
          }
          displayCorreos = 1;
        }

      }else{
        $('#p_nIdNotificaPagos').val(2);

        if(bitmap == '1100' || bitmap == '1010' || bitmap == '1001'){
          document.getElementById("datosFtp").style.display="inline-block";
        }else{
          document.getElementById("datosFtp").style.display="none";
        }
        $('#p_nIdMetodoEntrega').val(bitmap);
      }

      //ojo n oexiste en el html
      $('input[name=entrega][value='+bitmap+']').attr('checked', true);

      $('#divenlinea').css('display','block');
      $('#chkenlinea').attr('checked','checked');
      $('#divmetodoenlinea').css('display','block');
      $('#p_nIdMetodoLinea').val(obj[index]['nIdMetodoLinea']);

      });
    }
    }).fail(function(response){
					$this.button('reset');
					jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
				});
      } 
}

function guardarintegrador(){
  //datos generales
var sToken= $("#p_sToken").val();
var nIdEmisor=$("#p_nIdEmisor").val();

var nIdMoneda=$("#p_nId_moneda").val();
var nIdPais=$("#p_nIdPais").val();
var sRFC=$("#p_sRFC").val();
var sIRS=$("#p_sIrs").val();
var sNombreComercial=$("#p_sNombreComercial").val();
var sRazonSocial =$("#p_sRazonSocial").val();
var sNombreContacto= $("#p_sNombreContacto").val();
var sTelefono=$("#p_sTelefono").val();
var sCorreo=$("#p_sCorreo").val();
validacionCorreo = validar_email(sCorreo);

 //Dirección
 var sCalle=$("#p_sCalle").val();
 var sNumeroExterior= $("#p_sNumeroExterior").val();
 var sNumeroInterior=$("#p_sNumeroInterior").val();
 var sCodigoPostal =$("#p_sCodigoPostal").val();
 var nIdColonia=$("#p_nIdColonia").val();
 var nIdCiudad=$("#p_nIdCiudad").val();
 var nIdEstado=$("#p_nIdEstado").val();
 
 //Direccion para extrangeros
 var txcolonia = $("#p_sNombreCiudad").val();
 var txciudad = $("#p_sCodigoPostal").val();
 var txestado = $("#p_sNombreEstado").val();

 //Datos bancarios
 var sCLABE=$("#p_sCLABE").val();
 var nIdCuentaBanco=$("#p_nIdCuentaBanco").val();
 var sReferencia=$("#p_sReferencia").val();

//Documentos

var docDomicilio=$("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='2']").val();
var docRfc=$("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='1']").val();
var docCuenta=$("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='3']").val();
var docContrato=$("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='4']").val();

//Liquidacion de pagos
var nIdProgramacion=$("#p_nIdProgramacion").val();
if (nIdProgramacion==1){
 /* var diaCortePago={"corte":"lunes","pago":$("#diaPago_Lunes").val(),
                    "corte":"martes","pago":$("#diaPago_Martes").val(),
                    "corte":"miercoles","pago":$("#diaPago_Miercoles").val(),
                    "corte":"jueves","pago":$("#diaPago_Jueves").val(),
                    "corte":"viernes","pago":$("#diaPago_Viernes").val(),
                    "corte":"sabado","pago":$("#diaPago_Sábado").val(),
                    "corte":"domingo","pago":$("#diaPago_Domingo").val()};*/
                    var diaCortePago=$("#diaPago_Lunes").val() + "|" + $("#diaPago_Martes").val() + "|" + $("#diaPago_Miercoles").val() + "|" + $("#diaPago_Jueves").val() + "|" + $("#diaPago_Viernes").val() + "|" + $("#diaPago_Sábado").val() + "|" + $("#diaPago_Domingo").val();
}
else{
  var diaCortePago=$("#diaPagoSelect").val();
}

//cobro trasferencia
var nIdTipofactura=$("#p_nIdTipofactura").val();
var nCostoTrasferencia=$("#p_nCostoTrasferencia").val();

//pago comision
var nIdPagoComision=$("#p_nIdPagoComision").val();
var diasdecom = diascoms + ''; //array comvertido a string
var nImporteComision=$("#p_nImporteComision").val();
var nPorcentajeComision=$("#p_nPorcentajeComision").val();
  if(nPorcentajeComision != 0){
    nPorcentajeComision = nPorcentajeComision / 100;
  }else{
    nPorcentajeComision = 0;
  }
var nIdRetencion=$("#p_nIdRetencion").val();

//referencia y comunicaciones
var nIdTipoReferencia=$("#p_nIdTipoReferencia").val();
var nIdNotificaPagos=$("#p_nIdNotificaPagos").val();

var	host ="";
var	port ="";
var	user ="";
var	password="";
var	remoteFolder ="";
var nIdMetodoEntrega="";

if (nIdNotificaPagos==1000){
  var correosOperaciones =  '';
    correosOperaciones = correosenv + ', sistemas@redefectiva.com';
}else{
  var nIdMetodoEntrega= $("#p_nIdMetodoEntrega").val();
  var	host = $("#host").val();
  var	port = $("#port").val();
  var	user = $("#user").val();
  var	password = $("#password").val();
  var	remoteFolder = $("#remoteFolder").val();
}

var nIdMetodoLinea=$("#p_nIdMetodoLinea").val();

var lack = "";
var error = "";


  //Validaciones

  if (nIdEmisor=='' || nIdEmisor  == undefined){
    lack +='Falta Capturar IdEmisor \n';
  }
  if (sToken.trim()=='' || sToken  == undefined){
    lack +='Falta Capturar El Token \n';
  }

  if(verif_rfcm(sRFC) == false){lack +='El formato del RFC es incorrecto\n';}
  if(nIdPais == 164){ 
    if(sRFC == undefined || sRFC.trim() == '' || sRFC <= 0){lack +='RFC\n';}
  }else{
    if(sRFC == undefined || sRFC.trim() == '' || sRFC <= 0){lack +='Id Oficial\n';}
    if (sIRS== undefined || sIRS.trim() == '' || sIRS <=0 ){lack +='Id Oficial\n'}
  }
  if(sNombreComercial == '' || sNombreComercial.length < 3){lack +='Nombre comercial de al menos 3 caracteres\n';}
  if(sRazonSocial == '' || sRazonSocial.length < 3){lack +='Razón Social de al menos 3 carácteres\n';}
  if(sNombreContacto == '' || sNombreContacto.length < 3){lack +='Nombre del contacto de al menos 3 carácteres\n';}
  if(sTelefono == '' || sTelefono.length < 10){lack +='Número de teléfono válido de 10 dígitos\n';}
  if(validar_email(sCorreo) == false){lack +='El formato del Correo Eletrónico es incorrecto, por favor Verifique\n';}

  //validaciones direccion
  if(sCalle == '' || sCalle.length < 3){lack +='Debe capturar el nombre de la calle de al menos 3 carácteres\n';}
  if(sNumeroExterior == ''){lack +='Numero exterior del domicilio\n';}
  if(sCodigoPostal == ''){lack +='Codigo postal\n';}
  if(nIdPais == 164){
    if(nIdColonia == undefined || nIdColonia.trim() == '' || nIdColonia <= 0){lack +='Colonia\n';}
  }else{
    if(txcolonia == undefined || txcolonia.trim() == '' || txcolonia.length < 3){lack +='Colonia\n';}
    if(txciudad == undefined || txciudad.trim() == '' || txciudad.length < 3){lack +='Ciudad\n';}
    if(txestado == undefined || txestado.trim() == '' || txestado.length < 3){lack +='Estado\n';}
  }

  //validaciones datos bancarios
  if(sCLABE == ''){lack +='Capture CLABE\n';}


//validacioned de documentos

   if(docDomicilio == '' || docDomicilio == 0 ){lack +='Comprobante de domicilio\n';}
  if(docRfc == '' || docRfc == 0 ){lack +='Comprobante de RFC\n';}
  if(docCuenta == '' || docCuenta == 0 ){lack +='Caratula de Estado de Cuenta\n';}
  if(docContrato == '' || docContrato == 0 ){lack +='Contrato\n';}

  
  //liquidacion 

  if (nIdProgramacion=='' || nIdProgramacion ==0 ){lack += 'Tipo de pago de liquidación\n';}

  if (nIdProgramacion==1){
    var dia=diaCortePago.split('|');
    for (var i=0; i < dia.length; i++) {
      if (dia[i]=='' || dia[i]==-1){
        lack += 'Día de pago'+cortes[iaCortePago[i]] + 'Lunes\n';
      }
   }

  }

   // transferencia
   if($('#chkcobrotransferencia').is(':checked')){
    contransfer= 1;
    if( nCostoTrasferencia == '' || nCostoTrasferencia == undefined ){lack +='Costo  por Transferencia\n';}
    if(nIdTipofactura == -1){lack +='Tipo de Facturaci\u00F3n  por Transferencia\n';}
  }else{
    contransfer= 0;
  }

 //comisiones

  if(nIdPagoComision == -1){lack +='Tipo de Pago Comisi\u00F3n\n';}
  if(nIdPagoComision > 1 && nIdPagoComision.length == 0 ){lack +='D\u00EDas de pago de Comisi\u00F3n\n';}
  if(nImporteComision == undefined || nImporteComision == '' || nImporteComision == 0){
          if(nPorcentajeComision == undefined || nPorcentajeComision == '' || nPorcentajeComision == 0){lack +='Porcentaje de  comisi\u00F3n\n';}
      }
  if(nPorcentajeComision == undefined || nPorcentajeComision == '' || nPorcentajeComision == 0){
      if(nImporteComision == undefined || nImporteComision == '' || nImporteComision == 0){lack +='Importe de  comisi\u00F3n\n';}
  }
  
  if(nIdRetencion == -1){lack +='Retenci\u00F3n\n';}

         
          //referencias  y comunicaciones

          if(nIdTipoReferencia == -1){lack +='¿C\u00F3mo el Emisor Genera sus Referencias?\n';}
          if(nIdNotificaPagos == -1){lack +='¿C\u00F3mo se notifican los pagos al Emisor?\n';}
          if(nIdNotificaPagos == 1000){
              //console.log(correosOperaciones);
              if(correosOperaciones == undefined || correosOperaciones.trim() == '' || correosOperaciones == ''){lack +='Correos para Reporte\n';}
           }
          if(nIdNotificaPagos == 2){

              if(nIdMetodoEntrega == -1 ){lack +='Método de Entrega\n';}
              if(host == undefined || host.trim() == '' || host <= 0){lack +='Host\n';}
              if(port == undefined || port.trim() == '' || port <= 0){lack +='Puerto de enlace\n';}
              if(user == undefined || user.trim() == '' || user <= 0){lack +='Usuario FTP\n';}
              if(password == undefined || password.trim() == '' || password <= 0){lack +='Password FTP\n';}
              if(remoteFolder == undefined || remoteFolder.trim() == '' || remoteFolder <= 0){lack +='Folder Remoto\n';}
          }


  if(lack != "" || error != ""){
    var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
    jAlert(black + '\n' + lack+'\n' );
    event.preventDefault();
  }else{
    if(validacionCorreo == false){
      jAlert('El correo no es v\u00E1lido');
    }else{
      
      if(nIdPais == 164){analizar = analizarCLABE2(sCLABE);}else{analizar = true;}
      if(analizar == true){
        var $this = $(this);
        $this.button('loading');
        //alert(emiii);
        $.post("/ayddo/ajax/Integradores.php",{
          //datos generales
          sToken:sToken,
          iIdEmisor:nIdEmisor,
          iIdIntegrador: integ,
          iIdMoneda: nIdMoneda, //1
          iIdPais: nIdPais,//2
          sRFC: sRFC,//3
          sIRS: sIRS,
          sNombreComercial: sNombreComercial,
          sRazonSocial: sRazonSocial,
          sNombreContacto:sNombreContacto,
          sTelefono:sTelefono,
          sCorreo:sCorreo,

          //Direccion para extrangeros
          sCalle:sCalle,
          sNumeroExterior:sNumeroExterior,
          sNumeroInterior:sNumeroInterior,
          sCodigoPostal:sCodigoPostal,
          iIdColonia:nIdColonia,
          iIdCiudad:nIdCiudad,
          iIdEstado:nIdEstado,

          //Datos bancarios
          sCLABE:sCLABE,
          iIdCuentaBanco:nIdCuentaBanco,
          sReferencia:sReferencia,

          //Documentos
          sIdDocumento:"",//json docomentos
          sdocDomicilio:docDomicilio,
          sdocRfc:docRfc,
          sdocCuenta:docCuenta,
          sdocContrato:docContrato,

          //Liquidacion de pagos
          iIdProgramacion:nIdProgramacion,
          sdiaCortePago:diaCortePago,
          
          //Cobro trasferencia
          iIdCobroTrasferencia:contransfer,
          iIdTipofactura:nIdTipofactura,
          sCostoTrasferencia:nCostoTrasferencia,

          //Pago comision
          iIdPagoComision:nIdPagoComision,
          sdiasdecom:diasdecom,
          sImporteComision:nImporteComision,
          sPorcentajeComision:nPorcentajeComision,
          iIdRetencion:nIdRetencion,

          //referencia y comunicaciones
          iIdTipoReferencia:nIdTipoReferencia,
          iIdNotificaPagos:nIdNotificaPagos,
          sHost:host,
          sPort:port,
          sUser:user,
          sPassword:password,
          sRemoteFolder:remoteFolder,
          sCorreosOperaciones:correosOperaciones,
          iIdMetodoLinea:nIdMetodoLinea,
          iIdMetodoEntrega:nIdMetodoEntrega,
          itipo: accion
          
        },function(res){
          jAlert(res.sMensaje,'Alert',function(){
            if (res.nIdIntegrador>0){
            integ=res.nIdIntegrador;
          }
            $('body').append('<form action="afiliacionIntegrador.php"  method="post" id="formemisorsend"><input type="text" name="p_IdIntegrador"  value="'+integ+'"/> </form>');
            $( "#formemisorsend" ).submit();
          });
          if(res.nCodigo == 0){ cancelaredicion();}
        },"JSON").fail(function(response){
          $this.button('reset');
          jAlert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
        })
      }else{
        jAlert('La clabe interbancaria es incorrecta');
      }
    }

   }
}
function actualizarintegrador(){
  var confi = confirm('¿Desea Actualizar la Infrmación del Emisor?');
  if(confi == true){
    accion=2;
    guardarintegrador();
  }
}

function ProgramacionPagosIntegrador(cte){
  $.post('/ayddo/ajax/Integrador.php',{idintegrador:cte,tipo:2},function(res){
    $.each(res,function(index,value){
          /*CONFIGURACION*/
        
          var tipoPago = res[index]['nTipoPago'];
        $("#p_nIdProgramacion").val(tipoPago);
        $("#nDiaCorte").attr("style","display:block");
        $("#diaDePago").remove();
        $("#relleno").remove();

        if (tipoPago == 1) {
          $("#tipoSeleccionado").append('<div class="form-group col-xs-6" id="diaDePago"><label class="control-label">Se paga el día: </label></div>');
          $(".diaSemana").each(function(index, element){
            $("#diaDePago").append('<select class="form-control m-bot15" id="diaPago_'+element.value+'" disabled><option value="-1" selected disabled hidden>Seleccione</option></select><br>');

            $(".diaSemana").each(function(indexSelect, elementSelect){
              if (indexSelect != 6 && indexSelect != 5) {
                $("#diaPago_"+element.value).append('<option value="'+indexSelect+'">'+elementSelect.value+'</option>');
              }
            });
            $('#diaPago_'+element.value).val(res[index]['nDiaPago']);
          });
        }else if (tipoPago == 2) {
          $("#relleno").remove();
          $("#nDiaCorte").attr("style","display:none");
          $("#tipoSeleccionado").append('<div class="form-group col-xs-3" id="relleno"></div><div class="form-group col-xs-6" id="diaDePago"><label class="control-label">Dia de pago del siguiente mes: </label></div>');

          $("#diaDePago").append('<select class="form-control m-bot15" id="diaPagoSelect" disabled><option value="-1" selected disabled hidden>Seleccione</option></select><br>');
          var dia = 1;
          while (dia <= 31) {
            $("#diaPagoSelect").append('<option value="'+dia+'">'+dia+'</option>');
            dia++;
          }

          $("#diaPagoSelect").val(res[index]['nDiaPago']);
        }else if (tipoPago == 3) {
          $("#relleno").remove();
          $("#nDiaCorte").attr("style","display:none");
          $("#tipoSeleccionado").append('<div class="form-group col-xs-3" id="relleno"></div><div class="form-group col-xs-6" id="diaDePago"><label class="control-label" id="labelDiaPago">Dia de pago siguiente inmediato</label></div>');

          $("#diaDePago").append('<select class="form-control m-bot15" id="diaPagoSelect" disabled><option value="-1" selected disabled hidden>Seleccione</option></select><br>');
          var dia = 1;
          while (dia <= 31) {
            $("#diaPagoSelect").append('<option value="'+dia+'">'+dia+'</option>');
            dia++;
          }

          $("#diaPagoSelect").val(res[index]['nDiaPago']);
        }
    });

    },"JSON");
}

function documentosIntegrador(cte){
  $.post('/ayddo/ajax/Integrador.php',{idintegrador:cte,tipo:3},function(res){
    $.each(res,function(index,value){
      if (res[index]['nIdTipoDocumento']==1){
        $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='1']").val(res[index]['nIdDocumento']);
       
      } else if (res[index]['nIdTipoDocumento']==2){
        $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='2']").val(res[index]['nIdDocumento']);
       
      } else if (res[index]['nIdTipoDocumento']==3){
        $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='3']").val(res[index]['nIdDocumento']);
        
      } else if (res[index]['nIdTipoDocumento']==4){
        $("input[type='hidden'][name='p_nIdDocumento'][idtipodoc='4']").val(res[index]['nIdDocumento']);
       
      }
      
    });

    },"JSON");

}

function cargaTipoFactura(){
  $.post("../ajax/Afiliacion/consultaClientes.php",{
    tipo : 17
  },function(response){
    var obj = jQuery.parseJSON(response);
    if (obj.length > 0) {
      $.each( obj, function( key, value ) {
        $('#tipofactura').append('<option value="'+value['nIdTipoFactura']+'">'+value['sNombre']+'</option>');
      });
    }
  });
}

function cargaValorIva(){
  $.post("../ajax/Afiliacion/consultaClientes.php",{
    tipo : 18
  },function(response){
    var obj = jQuery.parseJSON(response);
    if (obj.length > 0) {
      $.each( obj, function( key, value ) {
        if (value['nIdTipoIva'] == 1) {
          $('#iva').val(value['nValor']);
        }else{
          $('#ivaFronterizo').val(value['nValor']);
        }
      });
    }
  });
}


function agrergarcorreos(){
if(cuentacorreos > 4){
    $('#nuevocorreo').attr('disabled',true);
    jAlert('Solo puede Agregar 5 Correos'); return;
}else{

if(validar_email($('#nuevocorreo').val()) == false){jAlert('El formato del Correo Eletrónico es incorrecto, por favor Verifique'); return;}
   correosenv.push($('#nuevocorreo').val());
    cuentacorreos = cuentacorreos + 1;
    if(cuentacorreos > 4){$('#nuevocorreo').attr('disabled',true);}
   $('#nuevocorreo').val('');
    //alert(correosenv);
    $('#contenedordecorreos1').empty();
    	for (var i = 0; i < correosenv.length; i++) {

             $('#contenedordecorreos1').append('<div class="col-xs-12 formCorreos" ><input type="text" id="camposCorreos" class="form-control m-bot15 lecturaCorreos" name="correos" value="'+correosenv[i]+'" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreos btn btn-sm inhabilitar" id="remove" style="margin-left:3px;width:150px" value="'+correosenv[i]+'" onclick="removercorreo(this.value);">Quitar  <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');

		}


}

}


function  removercorreo(corr){

    cuentacorreos = cuentacorreos - 1;
    if(cuentacorreos < 5){$('#nuevocorreo').attr('disabled',false);}

      for(var i = 0; i< correosenv.length; i++){
   while(correosenv[i] == corr) correosenv.splice(i,1);
		}

         $('#contenedordecorreos1').empty();
    	for (var i = 0; i < correosenv.length; i++) {

             $('#contenedordecorreos1').append('<div class="col-xs-12 formCorreos" ><input type="text" id="camposCorreos" class="form-control m-bot15 lecturaCorreos" name="correos" value="'+correosenv[i]+'" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreos btn btn-sm inhabilitar" id="remove" style="margin-left:3px;width:150px" value="'+correosenv[i]+'" onclick="removercorreo(this.value);">Quitar  <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');

		}

}


function diasliquidaciones2(cb,valor){

      var diasOpAttr = cb.attributes;
      var diasOperaciones = "";
      for (i = 0; i < diasOpAttr.length; i++) {
        if (diasOpAttr[i].name == "dp") {
          diasOperaciones = diasOpAttr[i].value;
        }
      }
      var  diasdeoperaciones = diasOperaciones;

      if( cb.checked==true){

          cuentadias = cuentadias + parseInt(valor);

        $("input[type='checkbox'][value="+valor+"][a='a']").attr('disabled',true);
        $(cb).attr('disabled',false);
        if(diasdeoperaciones == 2){lun.push(valor);    }
        if(diasdeoperaciones == 3){mar.push(valor);}
        if(diasdeoperaciones == 4){mie.push(valor);}
        if(diasdeoperaciones == 5){jue.push(valor);}
        if(diasdeoperaciones == 6){vie.push(valor);}
       pushdias();
   }else{
      $("input[type='checkbox'][value="+valor+"][a='a']").attr('disabled',false);
     // trabajar en remover de los arrays el dia.
       if(diasdeoperaciones == 2){for(var i = 0; i< lun.length; i++){ while(lun[i] == valor) lun.splice(i,1);}}
       if(diasdeoperaciones == 3){for(var i = 0; i< mar.length; i++){ while(mar[i] == valor) mar.splice(i,1);}}
       if(diasdeoperaciones == 4){for(var i = 0; i< mie.length; i++){ while(mie[i] == valor) mie.splice(i,1);}}
       if(diasdeoperaciones == 5){for(var i = 0; i< jue.length; i++){ while(jue[i] == valor) jue.splice(i,1);}}
       if(diasdeoperaciones == 6){for(var i = 0; i< vie.length; i++){ while(vie[i] == valor) vie.splice(i,1);}}
       cuentadias = cuentadias - parseInt(valor);
       pushdias();
   }
}

function pushdias(){
    lun.sort();
    mar.sort();
    mie.sort();
    jue.sort();
    vie.sort();

    cobrardias = []; //vaia la variable para volverla a llenar

    var luns = [2,lun + ""];
    var mars = [3,mar + ""];
    var mies = [4,mie + ""];
    var jues = [5,jue + ""];
    var vies = [6,vie + ""];

    if(lun.length > 0){
      cobrardias.push(luns + "");
    }
    if(mar.length > 0){
      cobrardias.push(mars + "");
    }
    if(mie.length > 0){
      cobrardias.push(mies + "");
    }
    if(jue.length > 0){
      cobrardias.push(jues + "");
    }
    if(vie.length > 0){
      cobrardias.push(vies + "");
    }

 if(cuentadias == 28){
   $('#tabladeconfiguraciones').css('background-color','#eefff1')
 }else{
   $('#tabladeconfiguraciones').css('background-color','#f5f5f5')
 }
}



function seleccionapais(idpais){

    

    if(idpais == 164){
        $('#div-rfc label').html('RFC');
        $('#divDirnac').css('display','block');
        $('#divDirext').css('display','none');
        $('#p_sRFC').unmask();
        $('#div-irs').css('display','none');
        $('#p_sCodigoPostal').attr('maxlength',5);
    }else{
         $('#div-rfc label').html('Id Oficial');
         $('#divDirnac').css('display','none');
         $('#divDirext').css('display','block');
         $('#p_sRFC').prop('maxlength',13);
         $('#p_sTelefono').unmask();
         $('#div-irs').css('display','block');
         $('#p_sCodigoPostal').attr('maxlength',13);

    }

}


function cargapreemisor(idpre){
  // emiii = idpre;
  $.post("../../paycash/ajax/Afiliacion/consultaClientes.php",{
    id : idpre,
    tipo:15
  },
  function(response){
    var obj = jQuery.parseJSON(response);
		if(obj.length == 0){
			alert("No se encontro informacion");
			$("#emisorInfo").css('display','none');
			var inputs = document.getElementsByTagName("input");
			for(var i=0;i<inputs.length;i++){
				inputs[i].value = "";
			}
		}else{
      jQuery.each(obj, function(index,value) {
        $("#idaccesotxt").val(obj[index]['id']);
        $("#txttoken").val(obj[index]['token']);

        $("#nombreComercial").val(obj[index]['nombreComercial']);
				$("#razonSocial").val(obj[index]['razonSocial']);

        $("#idIntegrador").val(obj[index]['idIntegrador']);
        $("#txintegrador").val(obj[index]['intgrazsoc']);

        $("#idTipoLiq").val(obj[index]['tipliquidacion']);
        $("#idTipoCom").val(obj[index]['tipliqucomision']);

        diasliq(obj[index]['tipliquidacion'],0);
        diascom(obj[index]['tipliqucomision'], 0);

        $('#dliq').attr('disabled', true);
        $('#rdliq').attr('disabled', true);

        var liq = (obj[index]['disadeliquidacion']== null)? '0': obj[index]['disadeliquidacion'];
        var cms = (obj[index]['diasdecomision']== null)? '0': obj[index]['diasdecomision'];

        // console.log('cms:',cms)
        var diascomis  = cms.split(',');
        var diasliquis = liq.split(',');
        diascoms = diascomis;
        diasliqs = diasliquis;

        for (var i = 0; i < diasliquis.length; i++) {
            var dliqs = diasliquis[i];
            $('input[name ="dliq"][value="'+dliqs+'"]').attr('checked','checked');
        }

        $('.btnfiles').prop('disabled', false);
        $('#btneditar').css('display','block');
        $('#guardarE').css('display','none');

        for (var j = 0; j < diascomis.length; j++) {
            var dcoms = diascomis[j];
             $('input[name ="dcom"][value="'+dcoms+'"]').attr('checked','checked');
        }

       /*remoteFolder;*/
        //transest,cobrotrans,factrans,cobtrans
        $("#txtransac").val(obj[index]['transest']);
        $("#txtcostotrans").val(obj[index]['cobrotrans']);
        $("#tipofactura").val(obj[index]['factrans']);//combo

        var  cktrans  = obj[index]['cobtrans'];

        if(cktrans == 1){
          $('#chktrans').attr('checked','checked');
          $('#divcobtrans').css('display','block');
        }

        $("input[type='hidden'][name='nIdDoc'][idtipodoc='1']").val(obj[index]['tipodoc1']);
        $("input[type='hidden'][name='nIdDoc'][idtipodoc='2']").val(obj[index]['tipodoc2']);
        $("input[type='hidden'][name='nIdDoc'][idtipodoc='4']").val(obj[index]['tipodoc4']);
        $("input[type='hidden'][name='nIdDoc'][idtipodoc='10']").val(obj[index]['tipodoc10']);

        //txtransac,txtcostotrans,chktrans,

				$("#beneficiario").val(obj[index]['beneficiario']);
				$("#telefono").val(obj[index]['telefono']);
				$("#correo").val(obj[index]['correo']);
				$("#comision").val(obj[index]['comision']);
				$("#liquidacion").val(obj[index]['liquidacion']);
				$("#perComision").val(obj[index]['porcentajeComision']*100	);
				$("#clabe").val(obj[index]['clabe']);
				$("#retencion").val(obj[index]['retencion']);
				$("#txtCalle").val(obj[index]['calle']);
				$("#int").val(obj[index]['numeroInterior']);
				$("#ext").val(obj[index]['numeroExterior']);
				$("#txtCP").val(obj[index]['codigoPostal']);
        //$("#cmbColonia").val(obj[index]['colonia']);
        var nidPaisx = obj[index]['nIdPais'];

        $("#cmbpais").val(nidPaisx);

        seleccionapais(nidPaisx);

        if(nidPaisx == 164){
          nIdColonia = obj[index]['idcolonia'];
          //console.log('colonia:'+nIdColonia);
          buscarColonias(obj[index]['codigoPostal'], obj[index]['idcolonia']);
        }

        $("#txtColonia").val(obj[index]['colonia']);
		    $("#txtCiudad").val(obj[index]['municipio']);
        $("#txtEstado").val(obj[index]['estado']);
        $("#rfc").val(obj[index]['rfc']);

				//$("#cmbEstado").val(obj[index]['estado']);
				$("#tipoEmisor").val(obj[index]['tipoEmisor']);

        tipocliente = obj[index]['tipoEmisor'];

        if(obj[index]['metodolinea'] > 0){
          //$('#ctetipo').attr('checked','checked');
          $('#divenlinea').css('display','block');
          $('#chkenlinea').attr('checked','checked');
          $('#divmetodoenlinea').css('display','block');
          $('#cbmetodoenlinea').val(obj[index]['metodolinea']);
        }else{
          $('#ctetipo3').attr('checked','checked');
        }
				//$("#cmbMunicipio").val(obj[index]['municipio']);
				$("#referencia").val(obj[index]['numerica']);
				$("#referenciaAlfa").val(obj[index]['alfanumerica']);
				$("#cuentaContable").val(obj[index]['cuentaContable']);
				$("#idAcceso").val(obj[index]['id']);
				$("#token").val(obj[index]['token']);
				$("#token1").val(obj[index]['token']);

				$("#host").val(obj[index]['host']);
				$("#port").val(obj[index]['port']);
				$("#user").val(obj[index]['userFtp']);
				$("#password").val(obj[index]['passwordFtp']);
				$("#remoteFolder").val(obj[index]['remoteFolder']);

				var tipoReferencia = obj[index]['tipoReferencia'];
				var bitmap =  obj[index]['bitmap'];
        //console.log('bitmap '+bitmap);
        if(bitmap == 1000){
          $('#cbnotif').val(bitmap);
          $('#confcorreos').css('display','block');
        }else{
          $('#cbnotif').val(2);
          $('#cbmetent').val(bitmap);
        }

				$('input[name=entrega][value='+bitmap+']').attr('checked', true);
				if(bitmap == '1100' || bitmap == '1010' || bitmap == '1001'){
					document.getElementById("datosFtp").style.display="inline-block";
				}else{
					document.getElementById("datosFtp").style.display="none";
				}
        $('#cbref').val(tipoReferencia);

				separador = ",";

        if (obj[index]['correosReporte'] != null) {
          var correosenv = obj[index]['correosReporte'].split(separador);

          for (var i = 0; i < correosenv.length; i++) {
            $('#contenedordecorreos1').append('<div class="col-xs-12 formCorreos" ><input type="text" id="camposCorreos" class="form-control m-bot15 lecturaCorreos" name="correos" value="'+correosenv[i]+'" style="width: 300px; display:inline-block;" disabled><button  class="remove_button lecturaCorreos btn btn-sm inhabilitar" id="remove" style="margin-left:3px;width:150px" value="'+correosenv[i]+'" onclick="removercorreo(this.value);"  disabled >Quitar  <i class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
          }
        }

				analizarCLABE2(obj[index]['clabe']);
		});
		}
	})
  .fail(function(response){
    alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
  })
  $('input').attr('disabled', true);
  $('select').attr('disabled', true);
}


function autorizaPremisor(preemisor){

	var confx= confirm('Desea Cambiar De Preemisor a Proveedor');

    if(confx == true){
			$.post('/ayddo/ajax/premisor.php',{p_nIdPreemisor:preemisor,tipo:2},function(res){
				if(res.code == 0){
          $('body').append('<form action="consultaClientes.php"  method="post" id="formemisorsend"><input type="text" name="nIdTipoCliente"  value="'+nIdTipoCliente+'"/> </form>');
          $( "#formemisorsend" ).submit();
				}else{
					jAlert(res.msg);
				}
	 },"JSON");
		}

}

//actualizarPreemisor
function guardarPreemisor(){
  var actualizar = confirm('Desea actualizar la información del Preemisor?');

  if (actualizar == true){
    //datos generales
    var nombreComercial = $("#nombreComercial").val();
    var razonSocial = $("#razonSocial").val();
    var rfc = $("#rfc").val();
    var integrador = $("#idIntegrador").val();
  	var beneficiario = $("#beneficiario").val();
  	var telefono = $("#telefono").val();
  	var correo = $("#correo").val();
    //direccion
    var calle = $("#txtCalle").val();
    var numeroInterior = $("#int").val();
    var numeroExterior = $("#ext").val();
    var codigoPostal = $("#txtCP").val();
    var idPais = $("#idPais").val();
    var idColonia = $("#cmbColonia").val();
  	var idEstado = $("#cmbEntidad").val();
  	var idMunicipio = $("#cmbCiudad").val();
    //cmbColonia,cmbEntidad,cmbCiudad
    // datos bancarios

    var clabe = $("#clabe").val();
    var correo = $("#correo").val();
    validacionCorreo = validar_email(correo);
    analizar = analizarCLABE2(clabe);
    var idBanco = $("#banco").val();
    //var referencia = $("#referencia").val();
    var referencia = "";
    //var referenciaAlfa = $("#referenciaAlfa").val();
    var referenciaAlfa = rfc;

    var cuentaContable = $("#cuentaContable").val();

    //var edocta = $('#txtNIdDocEstadoCuenta').val();
    //documentos
    var compdomint  = $("input[type='hidden'][name='nIdDoc'][idtipodoc='1']").val();
    var rfcdocint   = $("input[type='hidden'][name='nIdDoc'][idtipodoc='2']").val();
    var edoctaint   = $("input[type='hidden'][name='nIdDoc'][idtipodoc='4']").val();
    var contratoint = "0";
    //var contratoint = $("input[type='hidden'][name='nIdDoc'][idtipodoc='10']").val();

    var lack = "";
    var error = "";

    if(nombreComercial == undefined || nombreComercial.trim() == '' || nombreComercial <= 0){lack +='Nombre Comercial\n';}
    if(razonSocial == undefined || razonSocial.trim() == '' || razonSocial <= 0){lack +='Razon Social\n';}
    if(rfc == undefined || rfc.trim() == '' || rfc <= 0){lack +='RFC\n';}
    if(beneficiario == undefined || beneficiario.trim() == '' || beneficiario <= 0){lack +='Beneficiario\n';}
    if(telefono == undefined || telefono.trim() == '' ){lack +='Telefono\n';}
    if(correo == undefined || correo.trim() == '' ){lack +='Correo\n';}

    // validacion direccion
    if(calle == undefined || calle.trim() == '' ){lack +='Calle\n';}
    if(numeroExterior == undefined || numeroExterior.trim() == '' ){lack +='Numero Exterior\n';}
    if(codigoPostal == undefined || codigoPostal.trim() == '' || codigoPostal <= 0){lack +='Codigo Postal\n';}
    if(idColonia == undefined || idColonia.trim() == '' || idColonia <= 0){lack +='Colonia\n';}

    // validacion datos bancarios
    if(clabe == undefined || clabe.trim() == '' || clabe <= 0){lack +='Cuenta CLABE\n';}
    //if(edocta == undefined || edocta.trim() == '' || edocta == 0){lack +='Documento Estado de Cuenta \n';}

    //validacion de documentos
    if(compdomint == '' || compdomint == 0 ){lack +='Archivo Comprobante de Domicilio\n';}
    if(rfcdocint == '' || rfcdocint == 0 ){lack +='Archivo Comprobante de RFC\n';}
    if(edoctaint == '' || edoctaint == 0 ){lack +='Archivo Estado de Cuenta\n';}
    //if(contratoint == '' || contratoint == 0 ){lack +='Archivo Contrato\n';}

    if(lack != "" || error != ""){
      var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
      jAlert(black + '\n' + lack+'\n' );
      event.preventDefault();
    }else{
      if(validacionCorreo == false){
        jAlert('El correo no es valido');
      }else{
        analizar = analizarCLABE2(clabe);
        console.log(analizar);
        if(analizar == true){
          var $this = $(this);
          $this.button('loading');
          $.post("/paycash/ajax/Afiliacion/afiliacion.php",{
            idpreem:preem,
            // datos generales
            nombreComercial : nombreComercial,
            razonSocial : razonSocial,
            rfc : rfc,
            integrador:integrador,
            beneficiario : beneficiario,
            telefono : telefono,
            correo : correo,

            //direccion
            calle: calle,
            numeroInterior: numeroInterior,
            numeroExterior: numeroExterior,
            codigoPostal: codigoPostal,
            idColonia: idColonia,
            idEstado: idEstado,
            idMunicipio: idMunicipio,
            idPais: idPais,

            // datos  bancarios
            clabe : clabe,
            banco: idBanco,
            cuentaContable : cuentaContable,
            referencia: referencia,
            referenciaAlfa: referenciaAlfa,
            //edocta:edocta,
            //documentos
            compdomint :  compdomint,
            rfcdocint  :  rfcdocint,
            edoctaint  :  edoctaint,
            contratoint:  contratoint,
            tipo: 11
          },

          function(res){
            if(res.code == 0){
              jAlert(res.msg,'Mensaje',function(){
                $('body').append('<form action="" method="post" id="formidrec"><input type="hidden" value="'+preem+'" name="txtidpreem"/><input type="hidden" value="'+integ+'" name="txtidinteg"/></form>');
                $( "#formidrec" ).submit();
              });
            }else{
              jAlert(res.msg);
              $("#guardarR").css('display','none')
              document.getElementById("guardarR").style.display="none";
              $this.button('reset');
            }
          },"JSON")
          .fail(function(response){
            $this.button('reset');
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
          })
        }else{
          jAlert('La clabe interbancaria es incorrecta');
        }
      }
    }
  }
}

function afiliarPreemisor(){
  var actualizar = confirm('Autorizar este Preemisor, se hara la afiliacion para Emisor ?');

  if (actualizar == true){
    //datos generales
    var nombreComercial = $("#nombreComercial").val();
    var razonSocial = $("#razonSocial").val();
    var rfc = $("#rfc").val();
    var integrador = $("#idIntegrador").val();
    var beneficiario = $("#beneficiario").val();
    var telefono = $("#telefono").val();
    var correo = $("#correo").val();
    //direccion
    var calle = $("#txtCalle").val();
    var numeroInterior = $("#int").val();
    var numeroExterior = $("#ext").val();
    var codigoPostal = $("#txtCP").val();
    var idPais = $("#idPais").val();
    var idColonia = $("#cmbColonia").val();
    var idEstado = $("#cmbEntidad").val();
    var idMunicipio = $("#cmbCiudad").val();
    //cmbColonia,cmbEntidad,cmbCiudad

    // datos bancarios
    var clabe = $("#clabe").val();
    var correo = $("#correo").val();
    validacionCorreo = validar_email(correo);
    analizar = analizarCLABE2(clabe);
    var idBanco = $("#banco").val();
    var referencia = $("#referencia").val();
    var referenciaAlfa = $("#referenciaAlfa").val();
    var cuentaContable = $("#cuentaContable").val();

    //var edocta = $('#txtNIdDocEstadoCuenta').val();
    //documentos
    var compdomint  = $("input[type='hidden'][name='nIdDoc'][idtipodoc='1']").val();
    var rfcdocint   = $("input[type='hidden'][name='nIdDoc'][idtipodoc='2']").val();
    var edoctaint   = $("input[type='hidden'][name='nIdDoc'][idtipodoc='4']").val();
    var contratoint = "0";
    //var contratoint = $("input[type='hidden'][name='nIdDoc'][idtipodoc='4']").val();

    var lack = "";
    var error = "";

    if(nombreComercial == undefined || nombreComercial.trim() == '' || nombreComercial <= 0){lack +='Nombre Comercial\n';}
    if(razonSocial == undefined || razonSocial.trim() == '' || razonSocial <= 0){lack +='Razon Social\n';}
    if(rfc == undefined || rfc.trim() == '' || rfc <= 0){lack +='RFC\n';}
    if(beneficiario == undefined || beneficiario.trim() == '' || beneficiario <= 0){lack +='Beneficiario\n';}
    if(telefono == undefined || telefono.trim() == '' ){lack +='Telefono\n';}
    if(correo == undefined || correo.trim() == '' ){lack +='Correo\n';}

    // validacion direccion
    if(calle == undefined || calle.trim() == '' ){lack +='Calle\n';}
    if(numeroExterior == undefined || numeroExterior.trim() == '' ){lack +='Numero Exterior\n';}
    if(codigoPostal == undefined || codigoPostal.trim() == '' || codigoPostal <= 0){lack +='Codigo Postal\n';}
    if(idColonia == undefined || idColonia.trim() == '' || idColonia <= 0){lack +='Colonia\n';}

    // validacion datos bancarios
    if(clabe == undefined || clabe.trim() == '' || clabe <= 0){lack +='Cuenta CLABE\n';}
    //if(edocta == undefined || edocta.trim() == '' || edocta == 0){lack +='Documento Estado de Cuenta \n';}
    //validacion de documentos

    if(compdomint == '' || compdomint == 0 ){lack +='Archivo Comprobante de Domicilio\n';}
    if(rfcdocint == '' || rfcdocint == 0 ){lack +='Archivo Comprobante de RFC\n';}
    if(edoctaint == '' || edoctaint == 0 ){lack +='Archivo Estado de Cuenta\n';}
    //if(contratoint == '' || contratoint == 0 ){lack +='Archivo Contrato\n';}

    if(lack != "" || error != ""){
      var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
  		jAlert(black + '\n' + lack+'\n' );
  		event.preventDefault();
  	}else{
      if(validacionCorreo == false){
        jAlert('El correo no es valido');
      }else{
        analizar = analizarCLABE2(clabe);

        if(analizar == true){
          $.post('../../paycash/ajax/Afiliacion/afiliacion.php',{tipo: 12,preem:preem,usr:usr},function(res){
            if(res.cod == 0){
              jAlert(res.msg);
              $('body').append('<form id="formregresar" action="./consultaClientes.php" methond="post"><input type="hidden" name="escondido" value="0"/></form>');
              $("#formregresar").submit();
              //tenemos que poner alguna otra funcion aqui  que regrese a la lista de los emisores

            } else {
              jAlert(res.msg);
            }
          },"JSON")
          .fail(function(response){
            console.log(response);
            alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
          })
        }else{
          jAlert('La clabe interbancaria es incorrecta');
        }
      }
    }
  }
}

function configPagoLiquidaciones(){ 
  $("#p_nIdProgramacion").change(function(){
    var value = $("#p_nIdProgramacion option:selected" ).val();
    $("#diaDePago").remove();
    $("#relleno").remove();
    $("#nDiaCorte").attr("style","display:block");

    if (value == 1) {

      $("#tipoSeleccionado").append('<div class="form-group col-xs-6" id="diaDePago"><label class="control-label">Se paga el día: </label></div>');

      $(".diaSemana").each(function(index, element){
        $("#diaDePago").append('<select class="form-control m-bot15" id="diaPago_'+element.value+'" ><option value="-1" selected disabled hidden>Seleccione</option></select><br>');

        $(".diaSemana").each(function(indexSelect, elementSelect){
          if (indexSelect != 6 && indexSelect != 5) {
            $("#diaPago_"+element.value).append('<option value="'+indexSelect+'">'+elementSelect.value+'</option>');
          }
        });
      });

    }else if (value == 2) {
      $("#relleno").remove();
      $("#nDiaCorte").attr("style","display:none");
      $("#tipoSeleccionado").append('<div class="form-group col-xs-3" id="relleno"></div><div class="form-group col-xs-6" id="diaDePago"><label class="control-label">Dia de pago del siguiente mes: </label></div>');

      $("#diaDePago").append('<select class="form-control m-bot15" id="diaPagoSelect"><option value="-1" selected disabled hidden>Seleccione</option></select><br>');
      var dia = 1;
      while (dia <= 31) {
        $("#diaPagoSelect").append('<option value="'+dia+'">'+dia+'</option>');
        dia++;
      }


    }else if (value == 3) {
      $("#relleno").remove();
      $("#nDiaCorte").attr("style","display:none");
      $("#tipoSeleccionado").append('<div class="form-group col-xs-3" id="relleno"></div><div class="form-group col-xs-6" id="diaDePago"><label class="control-label" id="labelDiaPago">Dia de pago siguiente inmediato</label></div>');

      $("#diaDePago").append('<select class="form-control m-bot15" id="diaPagoSelect"><option value="-1" selected disabled hidden>Seleccione</option></select><br>');
      var dia = 1;
      while (dia <= 31) {
        $("#diaPagoSelect").append('<option value="'+dia+'">'+dia+'</option>');
        dia++;
      }

    }
  });
}


function obtenerconfigliquidacion(cte,tipocte){

  $.post('../ajax/Afiliacion/consultaClientes.php',{cte:cte,tipocte:tipocte,tipo:12},function(res){

      $.each(res,function(index,value){
          var diaxc = [res[index]['diapag'],res[index]['diasops'] + ""];
          var diaspagss = res[index]['diasops'];
          var diaxx = res[index]['diapag'];
          var dps = diaspagss.split(",");


          if(diaxx == 2){for(var i = 0; i< dps.length; i++){  lun.push(dps[i])}}
          if(diaxx == 3){for(var i = 0; i< dps.length; i++){  mar.push(dps[i])}}
          if(diaxx == 4){for(var i = 0; i< dps.length; i++){  mie.push(dps[i])}}
          if(diaxx == 5){for(var i = 0; i< dps.length; i++){  jue.push(dps[i])}}
          if(diaxx == 6){for(var i = 0; i< dps.length; i++){  vie.push(dps[i])}}

          //cobrardias.push(diaxc + "");
          cuentadias = 28;
          //console.log(diaxc );
          $.each(dps,function(index,value){
                $("input[type='checkbox'][value="+value+"][dp="+diaxx+"]").attr('checked',true);

           })
      });

       pushdias();
   },"JSON");


}


function obtenerconfigliquidacioninteg(cte,tipocte){

  $.post('../ajax/Afiliacion/consultaClientes.php',{cte:cte,tipocte:tipocte,tipo:13},function(res){

      $.each(res,function(index,value){

          var diaxc = [res[index]['diapag'],res[index]['diasops'] + ""];
          var diaspagss = res[index]['diasops'];
          var diaxx = res[index]['diapag'];
          var dps = diaspagss.split(",");



          if(diaxx == 2){for(var i = 0; i< dps.length; i++){  lun.push(dps[i])}}
          if(diaxx == 3){for(var i = 0; i< dps.length; i++){  mar.push(dps[i])}}
          if(diaxx == 4){for(var i = 0; i< dps.length; i++){  mie.push(dps[i])}}
          if(diaxx == 5){for(var i = 0; i< dps.length; i++){  jue.push(dps[i])}}
          if(diaxx == 6){for(var i = 0; i< dps.length; i++){  vie.push(dps[i])}}



          //cobrardias.push(diaxc + "");
          cuentadias = 28;
          //console.log(diaxc );
          $.each(dps,function(index,value){
                $("input[type='checkbox'][value="+value+"][dp="+diaxx+"]").attr('checked',true);

           })
      });

       pushdias();
   },"JSON");


}

